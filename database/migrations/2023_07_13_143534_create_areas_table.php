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
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->string('area_name');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')
            ->references('id')->on('cities')
            ->onUpdate('cascade')->onDelete('restrict');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->tinyInteger('status');  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
