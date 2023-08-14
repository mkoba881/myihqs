<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMailColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mails', function (Blueprint $table) {
            $table->text('user_mailformat')->change();
            $table->text('remind_mailformat')->change();
            $table->text('admin_mailformat')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mails', function (Blueprint $table) {
            $table->string('user_mailformat')->change();
            $table->string('remind_mailformat')->change();
            $table->string('admin_mailformat')->change();
        });
    }
}
