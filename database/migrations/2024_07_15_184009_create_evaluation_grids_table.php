<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_grids', function (Blueprint $table) {
            $table->id();
            $table->integer('evaluation_id')->nullable();
            $table->text('identifier')->nullable();
            $table->longText('data')->nullable();
            $table->longText('evaluation_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evaluation_grids');
    }
};
