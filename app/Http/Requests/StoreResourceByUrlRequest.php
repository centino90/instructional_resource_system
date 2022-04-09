<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResourceByUrlRequest extends FormRequest
{
    protected $redirect = '';

    public function __construct()
    {
        if (request()->routeIs('resource.storeNewVersionByUrl')) {
            $this->redirect = route(
                'resource.createNewVersion',
                [request()->get('resource_id'), 'uploadTab' => 'storage']
            );
            return;
        }

        if (request()->routeIs('syllabi.create')) {
            $this->redirect = route(
                'syllabi.create',
                [request()->get('course'), 'uploadTab' => 'storage']
            );
            return;
        }

        $this->redirect = route(
            'resource.create',
            [
                request()->get('lesson_id'), 'submitType' => request()->routeIs('presentations.uploadByUrl')
                    ? 'presentation' : 'general', 'uploadTab' => 'storage'
            ]
        );
    }

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
            'course_id' => 'nullable|string',
            'description' => 'nullable|string',
            'fileUrl' => 'required|url',
            'title' => 'required|string'
        ];
    }
}
