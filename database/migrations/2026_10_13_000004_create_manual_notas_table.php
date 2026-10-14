<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manual_notas', function (Blueprint $table) {
            $table->id();
            $table->string('no_nota')->unique();
            $table->date('tanggal');
            $table->date('jatuh_tempo')->nullable();
            $table->string('pelanggan_nama');
            $table->string('pelanggan_hp')->nullable();
            $table->text('pelanggan_alamat')->nullable();
            $table->string('jenis')->default('campuran'); // barang, jasa, campuran
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->string('diskon_tipe')->nullable(); // nominal, persen
            $table->decimal('diskon_nilai', 15, 2)->default(0);
            $table->decimal('biaya_lain', 15, 2)->default(0);
            $table->string('biaya_lain_label')->nullable();
            $table->decimal('total', 15, 2)->default(0);
            $table->decimal('dp_nominal', 15, 2)->default(0);
            $table->decimal('sisa_tagihan', 15, 2)->default(0);
            $table->enum('status', ['lunas','belum_lunas','dp'])->default('belum_lunas');
            $table->string('metode_bayar')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('catatan_nota')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['tanggal','status']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('manual_notas');
    }
};
