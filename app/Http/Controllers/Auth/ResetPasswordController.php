<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    public function resetPassword () {
        return view ('auth.resetPassword');
    }

    public function postResetPassword (Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'verification_code' => 'required|string|max:255',
        ], [
            'email.required' => 'Yêu cầu nhập đủ',
            'email.email' => 'Dữ liệu sai định dạng ',
            'email.exists' => 'Email không tồn tại',
            'password.required' => 'Yêu cầu nhập đủ',
            'password.string' => 'Dữ liệu sai định dạng',
            'password.min' => 'Mật khẩu phải lớn hơn 8 kí tự ',
            'password.confirmed' => 'Mật khẩu nhập lại không trùng khớp',
            'verification_code.required' => 'Yêu cầu nhập đủ',
            'verification_code.string' => 'Dữ liệu sai định dạng',
            'verification_code.max' => 'Dữ liệu sai định dạng',
            'verification_code.exists' => 'Mã xác nhận không tồn tại',
        ]);

        $user = User::where([['email', '=', $request->input('email')], ['verification_code', '=', $request->input('verification_code')]])->get();

        if (empty($user->first())) {
        }

        $user->first()->password = Hash::make($request->input('password'));
        $user->first()->verification_code = '';
        $user->first()->save();

        return redirect()->route('login');
    }
}
