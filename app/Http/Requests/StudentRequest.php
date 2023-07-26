<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
                'exam_id' => 'required',
                'first_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'email' => 'required|email',
                'sequence_number' => 'required',
                'address' => 'required',
                'social' => 'required',
                'school' => 'required',
                'graduation_date' => 'required',
            ];          
        }

        return [
            'exam_id' => 'required',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email',
            'sequence_number' => 'required',
            'address' => 'required',
            'social' => 'required',
            'school' => 'required',
            'graduation_date' => 'required',
        ];
    }
}
