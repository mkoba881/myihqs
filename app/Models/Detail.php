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

}
