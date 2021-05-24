<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class IntegrationRequest extends FormRequest
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
            'providerName' => filter_var($this->providerName, FILTER_SANITIZE_SPECIAL_CHARS),
            'providerType' => filter_var($this->providerType, FILTER_SANITIZE_SPECIAL_CHARS),
            'description' => filter_var($this->description, FILTER_SANITIZE_SPECIAL_CHARS),
            'acUrl' => filter_var($this->acUrl, FILTER_SANITIZE_SPECIAL_CHARS),
            'acToken' => filter_var($this->acToken, FILTER_SANITIZE_SPECIAL_CHARS),
            'clientId' => filter_var($this->clientId, FILTER_SANITIZE_SPECIAL_CHARS),
            'clientSecret' => filter_var($this->clientSecret, FILTER_SANITIZE_SPECIAL_CHARS),
            'basic' => filter_var($this->basic, FILTER_SANITIZE_SPECIAL_CHARS),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->providerName === 'Active Campaign') {
            return [
                'providerName' => 'required|string|min:3',
                'providerType' => 'required|string|min:3',
                'description' => 'required_if:providerName,Active Campaign|string|min:3',
                'acUrl' => 'required_if:providerName,Active Campaign|min:3|url|starts_with:https://|ends_with:api-us1.com',
                'acToken' => 'required_if:providerName,Active Campaign|string|alpha_dash|min:3',
            ];
        }

        if (request()->providerName === 'Hotmart') {
            return [
                'providerName' => 'required|string|min:3',
                'providerType' => 'required|string|min:3',
                'description' => 'required_if:providerName,Hotmart|string|min:3',
                'clientId' => 'required_if:providerName,Hotmart|string|alpha_dash|min:3',
                'clientSecret' => 'required_if:providerName,Hotmart|string|alpha_dash|min:3',
                'basic' => 'required_if:providerName,Hotmart|string|min:3'
            ];
        }

        if (request()->providerName === 'Facebook') {
            return [
                'providerName' => 'required|string|min:3',
                'providerType' => 'required|string|min:3',
                'description' => 'required_if:providerName,Facebook|string|min:3',
                'fbToken' => 'required_if:providerName,Facebook|string|alpha_dash|min:3',
                'expiresIn' => 'required',
                'adAccounts' => 'required',
            ];
        }

        if (request()->providerName === 'Google') {
           // Does not apply...
        }
    }

    /**
     * @return string[]
     */
    public function attributes()
    {
        return [
            'role_id' => 'role',
        ];
    }
}
