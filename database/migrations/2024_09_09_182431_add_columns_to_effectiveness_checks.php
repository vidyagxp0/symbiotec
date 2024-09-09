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
        Schema::table('effectiveness_checks', function (Blueprint $table) {
            $table->longText('acknowledge_Attachment')->nullable();
            $table->longText('qa_cqa_review_Attachment')->nullable();
            $table->longText('qa_cqa_approval_Attachment')->nullable();
            $table->longText('submit_comment')->nullable();

            $table->text('work_complition_by')->nullable();
            $table->text('work_complition_on')->nullable();
            $table->longText('work_complition_comment')->nullable();

            $table->text('effectiveness_check_complete_by')->nullable();
            $table->text('effectiveness_check_complete_on')->nullable();
            $table->longText('effectiveness_check_complete_comment')->nullable();

            $table->text('hod_review_complete_by')->nullable();
            $table->text('hod_review_complete_on')->nullable();
            $table->longText('hod_review_complete_comment')->nullable();

            $table->longText('effective_comment')->nullable();
            $table->longText('effective_approval_complete_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('effectiveness_checks', function (Blueprint $table) {
            //
        });
    }
};
