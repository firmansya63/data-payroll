<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('jabatan', ['teknisi','marketing','admin','lainnya'])->default('teknisi');
            $table->decimal('gaji_pokok', 12, 2)->default(0);
            $table->decimal('bonus_per_hadir', 12, 2)->default(0);
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
