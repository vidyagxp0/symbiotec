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
        Schema::table('regulatory_grids', function (Blueprint $table) {
            $table->longText('siteId')->nullable();
            $table->longText('observationShortDesc')->nullable();
            $table->longText('observationSubCat')->nullable();
            $table->longText('frequency')->nullable();
            $table->longText('observation_category')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regulatory_grids', function (Blueprint $table) {
            //
        });
    }
};
