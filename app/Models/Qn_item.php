<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qn_item extends Model
{
    use HasFactory;
    
    // テーブル名
    protected $table = 'qn_item';
    
    // プライマリキー設定
    protected $primaryKey = ['qn_fmt_id', 'qn_answer_id'];
    
    public static $rules = array(
        'sort_order' => 'required',
    );
}
