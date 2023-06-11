<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    
    public static $rules = array(
    'question_name' => 'required',
    'sortorder' => 'required',
    );

    public function Detail()
    {
        return $this->hasMany('App\Models\Detail');
    }

    
}
