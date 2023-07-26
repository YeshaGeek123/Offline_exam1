<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
                'code' => 'required',
                'exam_date_range' => 'required',
                'facility_name' => 'required',
                'state' => 'required',
                'zip' => 'required',
                'address' => 'required',
                'evaluators' => 'required',
                'assistants' => 'required',
                'invigilators' => 'required',
      
            ];          
        }

        return [
            'examinput' => 'required|mimes:xlsx',    
            'evaluators' => 'required',
            'assistants' => 'required',
            'invigilators' => 'required',    
        ];
    }
}
