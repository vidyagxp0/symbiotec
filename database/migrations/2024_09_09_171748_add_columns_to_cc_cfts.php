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
        Schema::table('cc_cfts', function (Blueprint $table) {
            $table->longText('qa_cqa_attach')->nullable();
            $table->longText('intial_update_attach')->nullable();
            $table->longText('hod_final_review_attach')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cc_cfts', function (Blueprint $table) {
            //
        });
    }
};
