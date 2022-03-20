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

        $this->redirect = route(
            'resource.create',
            [
                request()->get('lesson_id'), 'submitType' => request()->routeIs('syllabi.storeByUrl')
                    ? 'syllabus' : (request()->routeIs('presentations.uploadByUrl')
                        ? 'presentation'
                        :  'general'), 'uploadTab' => 'storage'
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
            'fileUrl' => 'required|string',
            'course_id' => 'required|string',
            'lesson_id' => 'required|string',
            'title' => 'required|string',
            // 'description' => 'required|string'
        ];
    }
}
