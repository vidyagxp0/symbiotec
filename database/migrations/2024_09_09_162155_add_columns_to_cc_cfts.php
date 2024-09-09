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
            $table->longText('qa_final_attach')->nullable();
            $table->longText('hod_assessment_comments')->nullable();
            $table->longText('intial_update_comments')->nullable();
            $table->longText('qa_cqa_comments')->nullable();
            $table->longText('implementation_verification_comments')->nullable();
            $table->longText('hod_final_review_comment')->nullable();
            $table->text('RA_data_person')->nullable();
            $table->longText('qa_final_comments')->nullable();
            $table->longText('QA_CQA_person')->nullable();
            $table->longText('ra_tab_comments')->nullable();
            $table->longText('hod_assessment_attachment')->nullable();

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
