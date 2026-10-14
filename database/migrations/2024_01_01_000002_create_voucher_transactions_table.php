<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('voucher_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reseller_id')->constrained('resellers')->cascadeOnDelete();
            $table->date('tanggal');
            $table->decimal('nominal', 12, 2);
            $table->enum('status', ['lunas','belum_lunas'])->default('belum_lunas');
            $table->text('keterangan')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['tanggal','status']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('voucher_transactions');
    }
};
