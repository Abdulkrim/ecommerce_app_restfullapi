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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name_en',100);
            $table->string('name_ar',100);
            $table->string('desc_en',255);
            $table->string('desc_ar',255);
            $table->string('image',255)->nullable();
            $table->unsignedInteger('count');
            $table->boolean('active')->default(1);;
            $table->float('price',8,2);
            $table->smallInteger('discount');
            $table->unsignedBigInteger('category_id');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
