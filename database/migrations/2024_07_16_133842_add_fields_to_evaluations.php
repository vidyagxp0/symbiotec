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
        Schema::table('evaluations', function (Blueprint $table) {
            $table->integer('checkbox_1')->nullable();
            $table->longText('initiatorRemark_1')->nullable();
            $table->longText('reviewerRemark_1')->nullable();
            $table->longText('approverRemark_1')->nullable();

            $table->integer('checkbox_2')->nullable();
            $table->longText('initiatorRemark_2')->nullable();
            $table->longText('reviewerRemark_2')->nullable();
            $table->longText('approverRemark_2')->nullable();

            $table->integer('checkbox_3')->nullable();
            $table->longText('initiatorRemark_3')->nullable();
            $table->longText('reviewerRemark_3')->nullable();
            $table->longText('approverRemark_3')->nullable();

            $table->integer('checkbox_4')->nullable();
            $table->longText('initiatorRemark_4')->nullable();
            $table->longText('reviewerRemark_4')->nullable();
            $table->longText('approverRemark_4')->nullable();

            $table->integer('checkbox_5')->nullable();
            $table->longText('initiatorRemark_5')->nullable();
            $table->longText('reviewerRemark_5')->nullable();
            $table->longText('approverRemark_5')->nullable();

            $table->integer('checkbox_6')->nullable();
            $table->longText('initiatorRemark_6')->nullable();
            $table->longText('reviewerRemark_6')->nullable();
            $table->longText('approverRemark_6')->nullable();

            $table->integer('checkbox_7')->nullable();
            $table->longText('initiatorRemark_7')->nullable();
            $table->longText('reviewerRemark_7')->nullable();
            $table->longText('approverRemark_7')->nullable();

            $table->integer('checkbox_8')->nullable();
            $table->longText('initiatorRemark_8')->nullable();
            $table->longText('reviewerRemark_8')->nullable();
            $table->longText('approverRemark_8')->nullable();
            $table->longText('evaluation_comment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluations', function (Blueprint $table) {
            //
        });
    }
};
