<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manual_nota_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manual_nota_id')->constrained('manual_notas')->cascadeOnDelete();
            $table->string('nama');
            $table->enum('kategori', ['barang','jasa'])->default('barang');
            $table->decimal('qty', 12, 2)->default(1);
            $table->string('satuan')->default('pcs');
            $table->decimal('harga_satuan', 15, 2)->default(0);
            $table->decimal('diskon_item', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->text('keterangan_item')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('manual_nota_items');
    }
};
