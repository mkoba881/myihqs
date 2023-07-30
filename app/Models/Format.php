<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Format extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    
    
    public static function getValidationRules($questionCount)
    {
        $rules = [
            'ankate_name' => 'required',
            'questionCount'=> 'required|integer|min:1',
        ];
    
        for ($i = 1; $i <= $questionCount; $i++) {
            $rules["question{$i}"] = 'required';
        }

    return $rules;
    }
    
    // public static $rules = array(
    // 'ankate_name' => 'required',
    // 'question' => 'required',
    // );
    
    
    // Item Modelに関連付けを行う
    public function Item()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function Mail()
    {
        return $this->hasMany('App\Models\Mail');
    }
    
    public function Survey_Participant()
    {
        return $this->hasMany('App\Models\Survey_Participant');
    }


}
