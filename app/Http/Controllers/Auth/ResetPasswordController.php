<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    protected $redirectTo = '/dashboard';

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected function sendResetResponse(Request $request, $response)
    {
        activity()
            ->causedBy(Auth::id())
            ->performedOn(Auth::user())
            ->log('Mengatur Ulang Kata Sandi');

        return redirect($this->redirectPath())
            ->with('status', 'Kata sandi Anda berhasil diubah.');
    }
}
