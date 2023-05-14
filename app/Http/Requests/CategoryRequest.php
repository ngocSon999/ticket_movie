<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:150|unique:categories,name,'.$this->id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục phim không được để trống',
            'name.unique' => 'Tên danh mục phim đã tồn tại trên hệ thống',
            'name.max' => 'Tên danh mục phim không được vượt quá :max ký tự'
        ];
    }
}
