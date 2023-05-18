<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreFieldsInInstallmentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instalment_types', function (Blueprint $table) {
            $table->integer('value');
            $table->boolean('balloon_payment')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instalment_types', function (Blueprint $table) {
            Schema::dropIfExists('instalment_types');
        });
    }
}
