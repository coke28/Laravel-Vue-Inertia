<?php

namespace App\Http\Requests;

use App\Rules\UniqueExceptCurrent;
use Illuminate\Foundation\Http\FormRequest;

class JobPostingRequest extends FormRequest
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
            'job_name' => [
                'required',
                'string',
                // Use the UniqueExceptCurrent rule conditionally
                new UniqueExceptCurrent('job_postings', 'job_name', $this->route('jobPosting')),
            ],
            'job_description' => 'required|string',
            'status' => 'required|in:1,0',
        ];
    }
}
