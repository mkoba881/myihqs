<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    
    public static $rules = array(
    'format_id' => 'required',
    'item_id' => 'required',
    'detail_id' => 'required',
    'user_id' => 'required',
    'answer_result' => 'required',
    'priority' => 'required',
    );

}
