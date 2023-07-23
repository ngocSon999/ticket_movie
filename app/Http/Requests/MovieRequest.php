<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
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
        return [
            'name' => sprintf('required|max:255|unique:movies,name, %s', $this->id),
            'description' => 'max:500',
            'age_limit' => 'required|max:2',
            'banner' => 'required|max:255',
            'trailer' => 'max:255',
            'director_id' => 'nullable|integer|',
            'start_date' => 'nullable|date|',
            'end_date' => 'nullable|date|',
        ];
    }
}
