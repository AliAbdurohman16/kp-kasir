<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
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
    }

    public function confirm(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|string'
        ]);

        if (Hash::check($request->password, Auth::user()->password)) {
            if (Auth::check()) {
                activity()
                    ->causedBy(Auth::user())
                    ->performedOn(Auth::user())
                    ->log('Konfirmasi Kata Sandi');
            }

            return redirect()->intended($this->redirectTo);
        }

        return back()->withErrors(['password' => 'Kata sandi yang berikan tidak cocok.']);
    }
}
