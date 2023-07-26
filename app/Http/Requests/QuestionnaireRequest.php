<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionnaireRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('PATCH')) {
            return [
                'exam_type_id' => 'required',
                'section_id' => 'required',
                'procedure_id' => 'required',
                'category_id' => 'required',
                'title' => 'required'
            ]; 
        }

        return [
            'exam_type_id' => 'required',
            'section_id' => 'required',
            'procedure_id' => 'required',
            'category_id' => 'required',
            'title' => 'required',
            'criterias' => 'required',
        ];
    }
}
