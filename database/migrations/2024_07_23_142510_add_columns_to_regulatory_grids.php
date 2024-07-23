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
            $table->longText('observation_detail')->nullable();
            $table->longText('referenceNo')->nullable();
            $table->longText('divisionCode')->nullable();
            $table->longText('auditingAgency')->nullable();
            $table->longText('audittype')->nullable();
            $table->longText('auditStartDate')->nullable();
            $table->longText('observationCategory')->nullable();
            $table->longText('observationType')->nullable();
            $table->longText('observationArea')->nullable();
            $table->longText('observationAreaSubCat')->nullable();
            $table->longText('capaRequired')->nullable();
            $table->longText('capaOwner')->nullable();
            $table->longText('capaDescription')->nullable();
            $table->longText('capaDueDate')->nullable();
            $table->longText('capaSatus')->nullable();
            $table->longText('delayJustification')->nullable();
            $table->longText('delayCategory')->nullable();
            $table->longText('remarks')->nullable();

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
