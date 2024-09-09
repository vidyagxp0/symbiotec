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
            $table->text('record_number')->nullable();
            $table->longText('acknowledge_comment')->nullable();
            $table->longText('qa_cqa_review_comment')->nullable();
            $table->longText('qa_cqa_approval_comment')->nullable();
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
