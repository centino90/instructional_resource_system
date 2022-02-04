<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
        return [
            'title' => 'required|string',
            'code' => 'required|string',
            'program_id' => 'required|int',
            'year_level' => 'required|int',
            'semester' => 'required|int',
            'term' => 'required|int',
            'is_archived' => 'nullable|boolean'
        ];
    }
}
