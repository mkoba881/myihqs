<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mail extends Model
{
    use HasFactory;
    
    protected $guarded = array('id');
    
    public static $rules = array(
    'user_mailformat' => 'required',
    'admin_mailformat' => 'required',
    );

}
