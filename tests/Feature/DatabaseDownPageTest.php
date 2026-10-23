<?php

namespace Tests\Feature;

use App\Exceptions\Handler;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use PDOException;
use Tests\TestCase;

class DatabaseDownPageTest extends TestCase
{
    /**
     * QueryException yang meniru kondisi MySQL/MariaDB mati (kode 2002).
     */
    private function connectionFailure(): QueryException
    {
        return new QueryException(
            'mysql',
            'select * from `users` where `id` = 1 limit 1',
            [],
            new PDOException('SQLSTATE[HY000] [2002] No connection could be made because the target machine actively refused it')
        );
    }

    public function test_database_mati_menampilkan_halaman_khusus_503(): void
    {
        $response = app(Handler::class)->render(Request::create('/dashboard', 'GET'), $this->connectionFailure());

        $this->assertSame(503, $response->getStatusCode());
        $this->assertSame('20', $response->headers->get('Retry-After'));

        $html = (string) $response->getContent();

        $this->assertStringContainsString('Koneksi Database Terputus', $html);
        $this->assertStringContainsString('Kesalahan Database', $html);
        $this->assertStringContainsString('Coba Lagi', $html);

        // Tidak boleh membocorkan stack trace, SQL, maupun detail infrastruktur.
        $this->assertStringNotContainsString('vendor/laravel', $html);
        $this->assertStringNotContainsString('select * from', $html);
        $this->assertStringNotContainsString('Detail teknis', $html);
        $this->assertStringNotContainsString('DB_HOST', $html);
        $this->assertStringNotContainsString('DB_DATABASE', $html);

        $mysql = (array) config('database.connections.mysql');

        foreach (['host', 'port', 'database'] as $key) {
            $value = (string) ($mysql[$key] ?? '');

            if ($value !== '') {
                $this->assertStringNotContainsString($value, $html, "Halaman 503 tidak boleh memuat {$key} database.");
            }
        }
    }

    public function test_request_json_mendapat_response_json_503(): void
    {
        $request = Request::create('/dashboard', 'GET', [], [], [], ['HTTP_ACCEPT' => 'application/json']);

        $response = app(Handler::class)->render($request, $this->connectionFailure());

        $this->assertSame(503, $response->getStatusCode());
        $this->assertSame('20', $response->headers->get('Retry-After'));

        $payload = json_decode((string) $response->getContent(), true);

        // Hanya pesan umum: tanpa kode error, referensi, maupun detail koneksi.
        $this->assertSame(['message', 'retry_after'], array_keys((array) $payload));
        $this->assertSame('Koneksi database terputus. Silakan coba beberapa saat lagi.', $payload['message'] ?? null);
        $this->assertSame(20, $payload['retry_after'] ?? null);
    }

    public function test_error_query_biasa_tidak_dianggap_database_mati(): void
    {
        $exception = new QueryException(
            'mysql',
            'update `payrolls` set `signature_hash` = ? where `id` = ?',
            ['abc', 1],
            new PDOException("SQLSTATE[42S22]: Column not found: 1054 Unknown column 'signature_hash' in 'field list'")
        );

        $response = app(Handler::class)->render(Request::create('/payrolls', 'GET'), $exception);

        $this->assertNotSame(503, $response->getStatusCode());
        // Halaman DB-down selalu mengirim header Retry-After; error query biasa tidak.
        $this->assertNull($response->headers->get('Retry-After'));
    }
}
