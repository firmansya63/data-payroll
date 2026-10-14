<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->date('tanggal');
            $table->decimal('nominal', 12, 2);
            $table->string('keterangan')->nullable();
            $table->enum('status', ['belum_dipotong','sudah_dipotong'])->default('belum_dipotong');
            $table->foreignId('payroll_id')->nullable()->constrained('payrolls')->nullOnDelete();
            $table->timestamps();
            $table->index('tanggal');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('deductions');
    }
};
