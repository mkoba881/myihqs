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
        Schema::create('qn_item', function (Blueprint $table) {
            $table->foreignId('qn_fmt_id')->constrained('qn');//->onDelete('cascade');//外部キーの設定
            $table->integer('qn_answer_id');
            $table->integer('qn_item_id');
            $table->integer('sort_order');
            $table->timestamps();
            
            $table->unique(['qn_fmt_id', 'qn_answer_id']);//プライマリーキーの設定
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qnitem');
    }
};
