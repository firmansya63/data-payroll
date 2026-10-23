<?php

namespace App\Exceptions;

use Illuminate\Database\DetectsLostConnections;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Str;
use PDOException;
use Throwable;

class Handler extends ExceptionHandler
{
    use DetectsLostConnections;

    /**
     * Jeda (detik) sebelum halaman "Koneksi Database Terputus" mencoba ulang otomatis.
     */
    protected const RETRY_AFTER_SECONDS = 20;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // Halaman khusus (bukan stack trace) saat database tidak bisa diakses.
        $this->renderable(function (Throwable $e, $request) {
            if (! $this->isDatabaseUnavailable($e)) {
                return null;
            }

            // Bypass untuk developer: ?full=1 membiarkan Laravel/Ignition menampilkan error aslinya.
            if ($request->boolean('full')) {
                return null;
            }

            $diagnostics = $this->databaseDiagnostics($e);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Koneksi database terputus. Silakan coba beberapa saat lagi.',
                    'code' => $diagnostics['code'],
                    'reference' => $diagnostics['ref'],
                    'retry_after' => self::RETRY_AFTER_SECONDS,
                ], 503)
                    ->header('Retry-After', (string) self::RETRY_AFTER_SECONDS)
                    ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
            }

            try {
                return response()
                    ->view('errors.database-down', $diagnostics, 503)
                    ->header('Retry-After', (string) self::RETRY_AFTER_SECONDS)
                    ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
            } catch (Throwable $renderError) {
                // Jaring pengaman: jangan pernah tampilkan halaman kosong bila view gagal dirender.
                report($renderError);

                return $this->plainDatabaseDownResponse();
            }
        });
    }

    /**
     * Apakah exception ini disebabkan database/server database tidak dapat diakses?
     */
    protected function isDatabaseUnavailable(Throwable $e): bool
    {
        foreach ($this->exceptionChain($e) as $exception) {
            if (! $exception instanceof QueryException && ! $exception instanceof PDOException) {
                continue;
            }

            if ($this->causedByLostConnection($exception)) {
                return true;
            }

            if (Str::contains($exception->getMessage(), [
                'SQLSTATE[HY000] [2002]',
                'SQLSTATE[HY000] [2003]',
                'SQLSTATE[HY000] [2005]',
                'SQLSTATE[HY000] [1045]',
                'SQLSTATE[HY000] [1049]',
                'SQLSTATE[08001]',
                'SQLSTATE[08004]',
                'SQLSTATE[08006]',
                'could not find driver',
                'Unknown MySQL server host',
                'Unknown database',
                'Access denied for user',
                'getaddrinfo failed',
                'No such file or directory',
                'Connection refused',
                'Connection timed out',
                'Network is unreachable',
                'MySQL server has gone away',
            ])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Kumpulkan rantai exception (asli + previous) tanpa loop tak berujung.
     *
     * @return array<int, Throwable>
     */
    protected function exceptionChain(Throwable $e): array
    {
        $chain = [];

        for ($current = $e; $current !== null && count($chain) < 8; $current = $current->getPrevious()) {
            $chain[] = $current;
        }

        return $chain;
    }

    /**
     * Data yang aman ditampilkan pada halaman error (tanpa credential).
     *
     * @return array<string, mixed>
     */
    protected function databaseDiagnostics(Throwable $e): array
    {
        $connection = (string) config('database.default', 'mysql');
        $config = (array) config("database.connections.{$connection}", []);

        [$code, $rawMessage] = $this->connectionFailureCode($e);

        $reasons = [
            '2002' => 'Layanan MySQL/MariaDB kemungkinan belum berjalan, atau host/port pada konfigurasi tidak sesuai.',
            '2003' => 'Server database tidak dapat dijangkau dari host ini (firewall atau alamat server salah).',
            '2005' => 'Nama host database tidak dikenal — periksa kembali DB_HOST.',
            '2006' => 'Koneksi ke server database terputus (server timeout atau baru saja restart).',
            '2013' => 'Koneksi ke server database terputus di tengah proses.',
            '1045' => 'Akses ditolak — username atau password database salah.',
            '1049' => 'Database belum dibuat di server MySQL/MariaDB.',
            '08001' => 'Aplikasi gagal membuat koneksi ke server database.',
            '08004' => 'Server database menolak koneksi dari aplikasi.',
            '08006' => 'Koneksi ke server database terputus.',
            'DRIVER' => 'Ekstensi PHP untuk driver database belum aktif (mis. pdo_mysql).',
        ];

        $reason = $reasons[$code]
            ?? 'Server database tidak merespons. Periksa kembali layanan dan konfigurasi database.';

        return [
            'appName' => (string) config('app.name', 'Datanet'),
            'driver' => $connection,
            'host' => (string) ($config['host'] ?? '-'),
            'port' => (string) ($config['port'] ?? '-'),
            'database' => (string) ($config['database'] ?? '-'),
            'code' => $code,
            'reason' => $reason,
            'ref' => 'DB-'.$code.'-'.now()->format('ymd-His'),
            'checkedAt' => now()->format('d M Y H:i:s'),
            'retrySeconds' => self::RETRY_AFTER_SECONDS,
            'debug' => (bool) config('app.debug', false),
            'detail' => $this->sanitizeDetail($rawMessage),
        ];
    }

    /**
     * Ambil kode kegagalan koneksi (mis. 2002) dari pesan exception.
     *
     * @return array{0: string, 1: string}
     */
    protected function connectionFailureCode(Throwable $e): array
    {
        $message = '';

        foreach ($this->exceptionChain($e) as $exception) {
            $isDatabaseException = $exception instanceof QueryException || $exception instanceof PDOException;

            if ($isDatabaseException && $exception->getMessage() !== '') {
                $message = $exception->getMessage();
                break;
            }
        }

        foreach (['2002', '2003', '2005', '2006', '2013', '1045', '1049', '08001', '08004', '08006'] as $known) {
            if (Str::contains($message, '['.$known.']')) {
                return [$known, $message];
            }
        }

        if (Str::contains($message, 'could not find driver')) {
            return ['DRIVER', $message];
        }

        return ['N/A', $message];
    }

    /**
     * Buang bagian SQL/binding dari pesan exception agar tidak membocorkan data.
     */
    protected function sanitizeDetail(string $message): string
    {
        $parts = preg_split('/\s*\(Connection:\s*/i', $message);

        $message = $parts[0] ?? $message;
        $message = trim((string) preg_replace('/\s+/', ' ', $message));

        return Str::limit($message, 240);
    }

    /**
     * Response HTML minimal jika view halaman error gagal dikompilasi.
     */
    protected function plainDatabaseDownResponse()
    {
        $html = '<!DOCTYPE html><html lang="id"><head><meta charset="utf-8">'
            .'<meta name="viewport" content="width=device-width, initial-scale=1">'
            .'<title>Koneksi Database Terputus</title></head>'
            .'<body style="margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;'
            .'background:linear-gradient(160deg,#1e1b4b,#2e1065,#4c1d95);color:#fff;'
            .'font-family:system-ui,-apple-system,Segoe UI,Roboto,sans-serif;padding:24px;text-align:center">'
            .'<div><h1 style="font-size:20px;margin:0 0 8px">Koneksi Database Terputus</h1>'
            .'<p style="margin:0;color:#c7d2fe;font-size:14px;line-height:1.6">Aplikasi tidak dapat terhubung '
            .'ke server database. Silakan muat ulang halaman ini beberapa saat lagi.</p></div></body></html>';

        return response($html, 503)
            ->header('Content-Type', 'text/html; charset=UTF-8')
            ->header('Retry-After', (string) self::RETRY_AFTER_SECONDS)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }
}
