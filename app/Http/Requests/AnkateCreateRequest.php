<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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

        for ($i = 1; $i <= $questionCount; $i++) {
            $rules["question{$i}"] = 'required|string';
            // 他の質問に関するルールも追加
        }

        return $rules;
    }
    
}
