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
            'title' => 'required|string|min:5',
            'template' => 'required|string',

            //* Personal info
            'personal_info' => 'required|array',
            'personal_info.name' => 'required|string|max:255',
            'personal_info.email' => 'required|email',
            'personal_info.phone_number' => 'required|string|max:50',

            //* Experience
            'experience' => 'nullable|array',
            'experience.*.company' => 'required_with:experience|string:max:255',
            'experience.*.role' => 'required_with:experience|string|max:255',
            'experience.*.start_date' => 'nullable|date',
            'experience.*.end_date' => 'nullable|date',
            'experience.*.description' => 'nullable|string|max:855',

            //* Education
            'education' => 'nullable|array',
            'education.*.school' => 'required_with:education|string|max:255',
            'education.*.degree' => 'nullable|string|max:255',
            
            //* Skills
            'skills' => 'nullable|array',
            'skills.*.name' => 'required_with:skills|string|max:100',

            //* Languages
            'languages' => 'nullable|array',
            'languages.*.name' => 'required_with:languages|string|max:100',
            'languages.*.level' => 'nullable|string|max:50',

            //* Projects
            'projects' => 'nullable|array',
            'projects.*.title' => 'required_with:projects|string|max:255',
            'projects.*.description' => 'nullable|string',

            'profile_picture' => 'nullable|image|max:2048',
        ];
    }
}
