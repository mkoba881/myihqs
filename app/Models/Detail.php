<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    
    public static $rules = array(
    'option1' => 'required',
    'option2' => 'required',
    'option3' => 'required',
    'option4' => 'required',
    'option5' => 'required',
    'priority' => 'required',
    );
    
    // // Itemとのリレーションを追加
    // public function item()
    // {
    //     return $this->belongsTo(Item::class);
    // }
    
    public function Answer()
    {
        return $this->hasMany('App\Models\Answer');
    }

}
