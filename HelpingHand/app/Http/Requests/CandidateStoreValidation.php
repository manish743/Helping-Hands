<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidateStoreValidation extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return ([
            'id' => 'required',
            'email' => 'required|email|unique:users,email',
            'first_name' => 'required',
            'last_name' => 'required',
            'contact' => 'required',
            'password' => 'required|confirmed',
            'current_salary' => 'required',
            'expected_salary' => 'required',
            'area_of_speciality' => 'required',
            'job_type' => 'required',

            'current_job_title' => 'required',
            'current_job_tenure' => 'required',
            'current_company_name' => 'required',
            'current_responsibility' => 'required',
            'current_achievement' => 'required',
            'current_skills_developed' => 'required',

            'previous_job_title' => 'required',
            'previous_job_tenure' => 'required',
            'previous_company_name' => 'required',
            'previous_responsibility' => 'required',
            'previous_achievement' => 'required',
            'previous_skills_developed' => 'required',


            'hard_skill' => 'required',
            'skill_detail' => 'required',
            'area_of_interest' => 'required',
            'true_box' => 'required',
            'terms_agree' => 'required',
            'image' => 'image|mimes:jpeg,png,gif|max:2048',
            'cv' => 'file|mimes:pdf',

        ]);
    }
    public function messages()
    {
        return [
            'id.required'=>'ID is required',
            'email.required'=>'Email is required',
            'email.unique:users,email'=>'Email already existed try new email',
            'first_name.required'=>'First Name is required',
            'last_name.required'=>'Last Name is required',
            'contact.required'=>'Contact is required',
            'job_type.required'=>'Type of Employement is required',
            
            'current_salary.required'=>'Current salary is required',
            'expected_salary.required'=>'Expected Salary is required',
            'area_of_speciality.required'=>'Ara of Speciality is required',

            'current_job_title.required'=>'Job Title is required',
            'current_job_tenure.required'=>' Job Tenure is required',
            'current_company_name.required'=>'Company is required',
            'current_responsibility.required'=>'Responsibility is required',
            'current_achievement.required'=>'Acheivement is required',
            'current_skills_developed.required'=>'Skills Developed is required',

            'previous_job_title.required'=>'Job Title is required',
            'previous_job_tenure.required'=>' Job Tenure is required',
            'previous_company_name.required'=>'Company is required',
            'previous_responsibility.required'=>'Responsibility is required',
            'previous_achievement.required'=>'Acheivement is required',
            'previous_skills_developed.required'=>'Skills Developed is required',


            'hard_skill.required'=>'Hard Skill is required',
            'skill_detail.required'=>'Skill Detail is required',
            'area_of_interest.required'=>'Area of Interest is required',
            'true_box.required'=>'Must agree that the information are True',
            'terms_agree.required'=>'Must agree to the terms',
            'image.image'=>'Invalid File Type!! Image Required',
            'image.max:2048'=>'Too Large file!! Upload file less than 2 MB',
            
            'cv.mimes'=>' Invalid File Type!! PDF Required',
            
            
        ];
    }
}
