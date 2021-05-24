<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => filter_var($this->name, FILTER_SANITIZE_SPECIAL_CHARS),
            'email' => filter_var($this->email, FILTER_SANITIZE_EMAIL),
            'country_code' => filter_var($this->country_code, FILTER_SANITIZE_SPECIAL_CHARS),
            'phone_number' => filter_var($this->phone_number, FILTER_SANITIZE_SPECIAL_CHARS),
            'photo' => filter_var($this->photo, FILTER_SANITIZE_SPECIAL_CHARS),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique((new User)->getTable())->ignore(auth()->id())],
            'country_code' => ['nullable', 'min:1', 'integer'],
            'phone_number' => ['nullable', 'min:8'],
            'photo' => ['nullable', 'image'],
        ];
    }
}
