<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreviousEndToFormats extends Migration
{
    public function up()
    {
        Schema::table('formats', function (Blueprint $table) {
            $table->timestamp('previous_end')->nullable();
        });
    }

    public function down()
    {
        Schema::table('formats', function (Blueprint $table) {
            $table->dropColumn('previous_end');
        });
    }
}
