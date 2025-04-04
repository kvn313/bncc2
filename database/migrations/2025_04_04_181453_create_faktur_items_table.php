<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('faktur_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('faktur_id');
            $table->string('nama_barang');
            $table->string('kategori');
            $table->integer('harga');
            $table->integer('qty');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('faktur_id')->references('id')->on('fakturs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faktur_items');
    }
};
