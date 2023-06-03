<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qn extends Model
{
    use HasFactory;
    
    // 以下を追記
    protected $guarded = array('id');
    //protected $primaryKey = 'qn_fmt_id';

    public static $rules = array(
        'qn_name' => 'required',
    );
    
    public function qn_item()
    {
        return $this->hasMany('App\Models\Qn_item');
    }

}
