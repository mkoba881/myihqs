<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

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
    
    public function updatePreviousAt()
    {
        $now = Carbon::now();
        
        $this->where('start', '<=', $now)
            ->where('end', '>=', $now)
            ->whereNull('previous_at') // 既に previous_at が設定されていない場合にのみ更新
            ->update(['previous_at' => $now]);
        return 'Previous_at dates updated successfully.';
        
    }
    
    public static function updatePreviousEnd()
    {
        // 現在の日付を取得
        $currentDate = now();

        // フォーマットの終了日が現在の日付よりも過去の場合、previous_endを更新
        self::where('end', '<', $currentDate)->update(['previous_end' => $currentDate]);

        // 更新完了メッセージ
        return 'Previous end dates updated successfully.';
    }

}
