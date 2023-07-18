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
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')
            ->references('id')->on('cities')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedBigInteger('area_id');
            $table->foreign('area_id')
            ->references('id')->on('areas')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')
            ->references('id')->on('types')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->integer('advance');
            $table->integer('rent');
            $table->date('from_date');
            $table->string('contact_no', 15);
            $table->string('detailed_address');
            $table->string('image', 1000);
            $table->tinyInteger('status');
            $table->integer('created_by');
            $table->integer('updated_by');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('houses');
    }
};
