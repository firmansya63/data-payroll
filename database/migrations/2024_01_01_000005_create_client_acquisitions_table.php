<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_acquisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->cascadeOnDelete();
            $table->string('nama_klien');
            $table->text('alamat_klien')->nullable();
            $table->date('tanggal');
            $table->decimal('nominal_insentif', 12, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->index('tanggal');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('client_acquisitions');
    }
};
