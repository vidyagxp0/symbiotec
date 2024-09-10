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
        Schema::table('extension_news', function (Blueprint $table) {
            $table->text('parent_type ')->nullable();
            $table->text('record  ')->nullable();
            $table->longText('related_records ')->nullable();
            $table->longText('justification_reason ')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extension_news', function (Blueprint $table) {
            //
        });
    }
};
