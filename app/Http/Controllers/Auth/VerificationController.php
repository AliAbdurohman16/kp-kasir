<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function resend()
    {
        // Call the parent method to handle resend logic
        $response = $this->sendVerificationEmail(Auth::user());

        // Log the action
        activity()
            ->causedBy(Auth::user())
            ->performedOn(Auth::user())
            ->log('Kirim Ulang Verifikasi Email.');

        return $response;
    }

    protected function sendVerificationEmail($user)
    {
        $user->sendEmailVerificationNotification();

        return redirect()->back()->with('resent', true);
    }

    public function verify(Request $request)
    {
        $response = $this->verifyEmail($request);

        return $response;
    }

    protected function verifyEmail(Request $request)
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath())->with('verified', true);
        }

        if ($user->markEmailAsVerified()) {
            // Log the verification action
            activity()
                ->causedBy($user)
                ->performedOn($user)
                ->log('Email Verifikasi.');
        }

        return redirect($this->redirectPath())->with('verified', true);
    }
}
