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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->text('record_number')->nullable();
            $table->text('due_date')->nullable();
            $table->integer('inititor_id')->nullable();
            $table->text('initiation_date')->nullable();
            $table->integer('division_id')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->integer('reference_document')->nullable();
            $table->text('site')->nullable();
            $table->text('department_name')->nullable();
            $table->text('sop_review_date')->nullable();
            $table->text('sop_title')->nullable();
            $table->longText('initial_attachment')->nullable();
            $table->text('reviewer')->nullable();
            $table->text('approver')->nullable();
            $table->text('initiated_by')->nullable();
            $table->text('initiated_on')->nullable();
            $table->text('stage')->nullable();
            $table->text('status')->nullable();

            $table->longText('reviewer_feedback')->nullable();
            $table->longText('reviewer_comment')->nullable();
            $table->longText('reviewer_attachment')->nullable();
            $table->text('reviewed_by')->nullable();
            $table->text('reviewed_on')->nullable();

            $table->longText('approver_feedback')->nullable();
            $table->longText('approver_comment')->nullable();
            $table->longText('approver_byattachment')->nullable();
            $table->text('approved_by')->nullable();
            $table->text('approved_on')->nullable();
            
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
        Schema::dropIfExists('evaluations');
    }
};