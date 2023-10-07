<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->string('option1')->nullable()->change();
            $table->string('option2')->nullable()->change();
            $table->string('option3')->nullable()->change();
            $table->string('option4')->nullable()->change();
            $table->string('option5')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->string('option1')->change();
            $table->string('option2')->change();
            $table->string('option3')->change();
            $table->string('option4')->change();
            $table->string('option5')->change();
        });
    }
}
