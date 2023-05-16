<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
        return [
            'bead_row' => ['numeric', 'min:1', 'max:1000'],
            'bead_col' => ['numeric', 'min:1', 'max:1000'],
            'bead_delica' => ['numeric', 'nullable'],
            'width' => ['numeric', 'min:1', 'max:1000'],
            'long' => ['numeric', 'min:1', 'max:1000'],
            'type' => ['max:50'],
            'name' => ['min:3', 'max:250'],
        ];
    }
}