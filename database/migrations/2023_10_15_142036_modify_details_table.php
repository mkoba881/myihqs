<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDetailsTable extends Migration
{
    public function up()
    {
        Schema::table('details', function (Blueprint $table) {
            // NULLを許容する設定
            $table->string('priority')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('details', function (Blueprint $table) {
            // ロールバック操作を記述
        });
    }
}
