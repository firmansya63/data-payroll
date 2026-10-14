<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->unsignedTinyInteger('periode_bulan');
            $table->unsignedSmallInteger('periode_tahun');
            $table->decimal('gaji_pokok', 12, 2)->default(0);
            $table->integer('jml_hadir')->default(0);
            $table->decimal('bonus_kehadiran', 12, 2)->default(0);
            $table->decimal('total_insentif', 12, 2)->default(0);
            $table->decimal('total_potongan', 12, 2)->default(0);
            $table->decimal('total_terima', 12, 2)->default(0);
            $table->enum('status', ['draft','final'])->default('final');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->unique(['employee_id','periode_bulan','periode_tahun']);
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('payrolls');
    }
};
