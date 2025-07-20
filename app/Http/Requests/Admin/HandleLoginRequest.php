<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class HandleLoginRequest extends FormRequest
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
            'user_credential' => 'required',
            'user_password' => 'required',
        ];
    }

    public function authenticate()
    {
        if (Auth::guard('admin')->attempt(['email' => $this->user_credential, 'password' => $this->user_password, 'status' => 1, 'delete' => 0]) || Auth::guard('admin')->attempt(['phone' => $this->user_credential, 'password' => $this->user_password, 'status' => 1, 'delete' => 0]) || Auth::guard('admin')->attempt(['username' => $this->user_credential, 'password' => $this->user_password, 'status' => 1, 'delete' => 0])) {
            return true;
        } else {
            return false;
        }

    }
}
