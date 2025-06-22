<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Mail\Admin\PasswordResetMail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

use function Pest\Laravel\json;

class AdminAuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkIfLoggedIn')->only(['forgetPassword','resetPasswordIndex','resetPasswordUpdate']);
    }


    public function forgetPassword(Request $data) : JsonResponse {
        $data->validate([
            'email' => ['required','exists:admins,email'],
        ],[
            'email.exists'=>__("admin_local.Couldn't find this email"),
        ]);

        
        Mail::to($data->email)->send(new PasswordResetMail(generateRandomString(),$data->email));


        return response()->json([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.A password reset link sent successfully to your email . Please check your email .'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ],200);
    }


    public function resetPasswordIndex() : View {
        return view('backend.auth.reset_password');
    }
    

    public function resetPasswordUpdate (ResetPasswordRequest $data) : RedirectResponse {
        $status = $data->resetPassword();
        if($status=== Password::PASSWORD_RESET){
            return redirect()->route('admin.login')->with('login_first', __('admin_local'.$status));
        }else{
            return back()->withErrors(['email' => [__('admin_local'.$status)]]);
        }
    }
}
