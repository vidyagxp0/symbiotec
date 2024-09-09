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
        Schema::table('action_items', function (Blueprint $table) {
            $table->text('related_records')->nullable();
            $table->text('parent_record_number')->nullable();
            $table->longText('final_attach')->nullable();
            $table->text('acknowledgement_by')->nullable();
            $table->text('acknowledgement_on')->nullable();
            $table->longText('acknowledgement_comment')->nullable();
            $table->text('work_completion_by')->nullable();
            $table->text('work_completion_on')->nullable();
            $table->longText('work_completion_comment')->nullable();
            $table->text('qa_varification_by')->nullable();
            $table->text('qa_varification_on')->nullable();
            $table->longText('qa_varification_comment')->nullable();
            $table->text('more_work_completion_by')->nullable();
            $table->text('more_work_completion_on')->nullable();
            $table->longText('more_work_completion_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('action_items', function (Blueprint $table) {
            //
        });
    }
};
