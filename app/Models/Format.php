<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Format extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    
    public static $rules = array(
    'ankate_name' => 'required',
    'question' => 'required',
    );
    
    
    // Item Modelに関連付けを行う
    public function Item()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function Mail()
    {
        return $this->hasMany('App\Models\Mail');
    }

}
