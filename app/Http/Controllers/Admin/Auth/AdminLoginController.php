<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HandleLoginRequest;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkIfLoggedIn')->only(['login','handleLogin']);
    }
    public function login() : View {
        return view('backend.auth.login');
    }

    public function handleLogin(HandleLoginRequest $data) : RedirectResponse {
        try {
            if($data->authenticate()){
                return to_route('admin.index')->with('success_login',1);
            }else{
                return back()->with('invalid_login', 1);
            }
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }

    public function index() : View{
        return view('backend.blade.dashboard.index');
    }

    public function handleLogout() : RedirectResponse {
        try {
            Auth::guard('admin')->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return to_route('admin.login');
        } catch (\Throwable $th) {
            return response(['status' => 'error', 'message' => __('admin_local.Someting went wrong!')]);
        }
    }

    public function adminProfile() : View {
        $profile_info = LoggedAdmin();
        // dd($profile_info);
        return view('backend.blade.user.admin_profile',compact('profile_info'));
    }

    public function updateBasicInfo(Request $data) : Response {
        $data->validate([
            'user_name' => 'required|max:50',
            'user_email' => 'required|email|max:50|unique:users,email,' . loggedAdmin()->id,
            'user_phone' => 'required|max:14|unique:users,phone,' . loggedAdmin()->id,
            'username' => 'required|max:50|unique:users,username,' . loggedAdmin()->id,
        ]);
        $update = Admin::where('id', loggedAdmin()->id)->update([
            'name' => $data->user_name,
            'email' => $data->user_email,
            'phone' => $data->user_phone,
            'username' => $data->username,
            'updated_at' => Carbon::now(),
        ]);

        if ($update) {
            return response(Admin::where('id', loggedAdmin()->id)->first());
        } else {
            return response(Admin::where('id', loggedAdmin()->id)->first());
        }
    }

    public function updatePassword(Request $data) : JsonResponse
    {
        $data->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'retype_password' => 'required|same:new_password',
        ]);
        $user = Admin::find(loggedAdmin()->id);
        // return $data->new_password;
        if(Hash::check($data->old_password,$user->password)){
            $update = Admin::where('id',loggedAdmin()->id)->update([
                'password' => Hash::make($data->new_password),
                'updated_at' => Carbon::now(),
            ]);
            return response()->json(['message'=>1]);
        }else{
            return response()->json(['message'=>'Invalid user password'],422);
        }
    }
}
