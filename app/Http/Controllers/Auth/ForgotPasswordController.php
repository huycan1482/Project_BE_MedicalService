<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    public function checkEmail () {
        return view ('auth.checkEmail');
    }

    public function postCheckEmail (Request $request) {
        $request->validate([
            'email' => 'required|exists:users,email',
        ], [
            'email.required' => 'Yêu cầu không để trống',
            'email.exists' => 'Email không tồn tại',
        ]);

        $check_user = User::where([['email', '=', $request->input('email')], ['is_active', '=', 1]])->get();

        if (empty($check_user)) {
            return redirect()->back()->withErrors(['msg'=> 'Email không tồn tại']);
        }

        $user = User::find($check_user->first()->id);
        $random_token = random_int(100000, 999999);
        $user->verification_code = $random_token;
        $user->save();

        Mail::to($request->input('email'))->send(new SendMail($random_token, 'reset_token'));
        return redirect()->route('resetPassword');
    }

    public function checkToken () {
        return view ('auth.checkToken');
    }
}
