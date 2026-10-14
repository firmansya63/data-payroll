<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->decimal('jam_lembur', 5, 2)->default(0)->after('total_potongan');
            $table->decimal('total_lembur', 12, 2)->default(0)->after('jam_lembur');
            $table->string('catatan_lembur')->nullable()->after('total_lembur');
        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn(['jam_lembur', 'total_lembur', 'catatan_lembur']);
        });
    }
};
