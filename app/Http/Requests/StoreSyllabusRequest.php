<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSyllabusRequest extends FormRequest
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
            // 'syllabus' => 'required',
        ];
    }
}

            // 'course_code' => 'required',
            // 'course_title' => 'required',
            // 'credit' => 'required',
            // 'time_allotment' => 'required',
            // 'professor' => 'required',

            // 'course_description.paragraphs.*' => 'required',

            // 'course_outcomes.paragraphs.*' => 'required',
            // 'course_outcomes.lists.*' => 'required',

            // 'learning_outcomes.paragraphs.*' => 'required',
            // 'learning_outcomes.lists.*' => 'required',

            // 'learning_plan.lo.*' => 'required',
            // 'learning_plan.weeks.*' => 'required',
            // 'learning_plan.topic.*' => 'required',
            // 'learning_plan.activities.*' => 'required',
            // 'learning_plan.resources.*' => 'required',
            // 'learning_plan.assessment_tools.*' => 'required',

            // 'student_outputs.paragraphs.*' => 'required',
            // 'student_outputs.lists.*' => 'required'
