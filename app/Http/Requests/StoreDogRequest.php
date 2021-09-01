<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDogRequest extends FormRequest

{

    protected $redirectRoute = 'dogs.create';
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
            'types.paragraphs.*' => 'required',
            'types.lists.*' => 'required'
        ];
    }
}