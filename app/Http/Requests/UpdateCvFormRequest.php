<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCvFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|min:5',
            'template' => 'sometimes|string',

            //* Personal info
            'personal_info' => 'sometimes|array',
            'personal_info.name' => 'sometimes|string|max:255',
            'personal_info.email' => 'sometimes|email',
            'personal_info.phone_number' => 'sometimes|string|max:50',

            //* Experience
            'experience' => 'nullable|array',
            'experience.*.company' => 'sometimes_with:experience|string:max:255',
            'experience.*.role' => 'sometimes_with:experience|string|max:255',
            'experience.*.start_date' => 'nullable|date',
            'experience.*.end_date' => 'nullable|date',
            'experience.*.description' => 'nullable|string|max:855',

            //* Education
            'education' => 'nullable|array',
            'education.*.school' => 'sometimes_with:education|string|max:255',
            'education.*.degree' => 'nullable|string|max:255',
            
            //* Skills
            'skills' => 'nullable|array',
            'skills.*.name' => 'sometimes_with:skills|string|max:100',

            //* Languages
            'languages' => 'nullable|array',
            'languages.*.name' => 'sometimes_with:languages|string|max:100',
            'languages.*.level' => 'nullable|string|max:50',

            //* Projects
            'projects' => 'nullable|array',
            'projects.*.title' => 'sometimes_with:projects|string|max:255',
            'projects.*.description' => 'nullable|string',

            'profile_picture' => 'nullable|image|max:2048',
        ];
    }
}
