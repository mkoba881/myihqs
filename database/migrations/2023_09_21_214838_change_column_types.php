<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypes extends Migration
{
    public function up()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->text('question')->change();
            $table->text('option1')->change();
            $table->text('option2')->change();
            $table->text('option3')->change();
            $table->text('option4')->change();
            $table->text('option5')->change();
        });
    }

    public function down()
    {
        Schema::table('details', function (Blueprint $table) {
            $table->string('question', 255)->change();
            $table->string('option1', 255)->change();
            $table->string('option2', 255)->change();
            $table->string('option3', 255)->change();
            $table->string('option4', 255)->change();
            $table->string('option5', 255)->change();

            // データを切り詰める操作を記述
            $columns = ['question', 'option1', 'option2', 'option3', 'option4', 'option5'];

            foreach ($columns as $column) {
                DB::table('details')->whereRaw("LENGTH($column) > 255")->update([$column => DB::raw("SUBSTRING($column, 1, 255)")]);
            }
        });
    }
}
