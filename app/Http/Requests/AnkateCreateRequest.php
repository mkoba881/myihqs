<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnkateCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'ankate_name' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'required|date',
            'questionCount' => 'required|integer|min:1',
            'status' => 'required|in:1,2',
        ];

        $questionCount = $this->input('questionCount');

        // for ($i = 1; $i <= $questionCount; $i++) {
            
            
        //     $rules["question_name{$i}"] = 'required|string';
            
        //     $rules["question{$i}"] = 'required|string';
        //     $rules["sortorder{$i}"] = 'required|string';
        //     // 他の質問に関するルールも追加
        // }
        
        $existingQuestionNames = [];
        $existingQuestions = [];
        $existingSortOrders = [];
        
        for ($i = 1; $i <= $questionCount; $i++) {
            $questionNameKey = $this->input("question_name{$i}");
            $questionKey = $this->input("question{$i}");
            $sortOrderKey = $this->input("sortorder{$i}");
        
            // 既存のフィールド名と重複するかチェック
            if (in_array($questionNameKey, $existingQuestionNames)) {
                die("質問名が重複しています。");
            }
            
            if (in_array($questionKey, $existingQuestions)) {
                die("質問が重複しています。");
            }
        
            if (in_array($sortOrderKey, $existingSortOrders)) {
                die("ソート順が重複しています。");
            }
        
            // フィールド名を追加
            $existingQuestionNames[] = $questionNameKey;
            $existingQuestions[] = $questionKey;
            $existingSortOrders[] = $sortOrderKey;
        
            // バリデーションルールを設定
            $rules["question_name{$i}"] = 'required|string';
            $rules["question{$i}"] = 'required|string';
            $rules["sortorder{$i}"] = 'required|string';
        
            // 他の質問に関するルールも追加
        }
        
        return $rules;
    }

}
