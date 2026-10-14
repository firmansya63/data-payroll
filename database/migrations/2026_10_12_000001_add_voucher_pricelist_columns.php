<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voucher_transactions', function (Blueprint $table) {
            $table->string('voucher_type', 10)->nullable()->after('reseller_id')->comment('3k,5k,10k');
            $table->unsignedInteger('qty')->nullable()->after('voucher_type');
            $table->decimal('harga_satuan', 12, 2)->nullable()->after('qty')->comment('harga reseller per pcs');
            $table->decimal('harga_retail', 12, 2)->nullable()->after('harga_satuan')->comment('harga ecer ke pelanggan');
        });
    }

    public function down(): void
    {
        Schema::table('voucher_transactions', function (Blueprint $table) {
            $table->dropColumn(['voucher_type', 'qty', 'harga_satuan', 'harga_retail']);
        });
    }
};
