<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->string('signature_hash')->nullable()->after('total_terima');
            $table->timestamp('signed_at')->nullable()->after('signature_hash');
            $table->string('barcode_type')->default('code128')->after('signed_at');
            $table->text('barcode_data')->nullable()->after('barcode_type');
        });

        Schema::table('company_settings', function (Blueprint $table) {
            $table->boolean('signature_enabled')->default(true)->after('footer_text');
            $table->string('signature_type')->default('barcode')->after('signature_enabled');
            $table->string('signature_salt')->nullable()->after('signature_type');
        });
    }

    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            $table->dropColumn(['signature_hash', 'signed_at', 'barcode_type', 'barcode_data']);
        });

        Schema::table('company_settings', function (Blueprint $table) {
            $table->dropColumn(['signature_enabled', 'signature_type', 'signature_salt']);
        });
    }
};