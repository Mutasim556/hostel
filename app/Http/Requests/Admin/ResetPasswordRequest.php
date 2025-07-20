<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class ResetPasswordRequest extends FormRequest
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
            'email'=>['required','email','exists:password_reset_tokens,email'],
            'reset_code'=>['required'],
            'new_password'=>['required'],
            'retype_new_password'=>['required','same:new_password'],
        ];
    }

    public function resetPassword(){
       $status = Password::broker('admins')->reset(['email'=>$this->email,'password'=>$this->new_password,'password_confirmation'=>$this->retype_new_password,'token'=>$this->reset_code],
            function (Admin $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(generateRandomString());
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        return $status ;
    }   
}
