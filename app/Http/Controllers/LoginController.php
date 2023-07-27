<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use ParagonIE\ConstantTime\Base32;

class LoginController extends Controller
{
    protected $redirectTo = '/home';

    public function showLoginForm()
    {
        return view('system.auth.login');
    }


    public function login(Request $request)
    {
        $this->validateLogin($request);

        try {
            if (
                method_exists($this, 'hasTooManyAttempts') &&
                $this->hasTooManyAttempts($request, Config::get('constants.DEFAULT_LOGIN_ATTEMPT_LIMIT')) // maximum attempts
            ) {
                $this->customFireLockoutEvent($request);

                return $this->customLockoutResponse($request);
            }
            $user = $this->loginType($request);
            if (Auth::attempt($user)) {


                $user = Auth::guard()->user();
                $data['secret'] = $this->generateSecret();

                //encrypt and then save secret.
                $google2fa = app('pragmarx.google2fa');
                if (!$user->google2fa_secret) {
                    $user->google2fa_secret = $google2fa->generateSecretKey();
                    $user->save();
                }
                //generate image for QR barcode
                if ($user->google2fa_secret) {
                    $data['imageDataUri'] = $google2fa->getQRCodeInline(
                        config('app.name'),
                        $user->email,
                        $user->google2fa_secret
                    );
                }
                $data['user'] = $user;
                return view('system.auth.2fa-setup', $data);
            }

            // Authentication failed, redirect back to the login form with an error message
            return redirect()->route('login')->withErrors(['alert-danger' => 'Invalid Credentials!']);
        } catch (\Exception $e) {
            if (Auth::guard() != null) {
                Auth::guard()->logout();
            }
        }
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    public function loginType(Request $request)
    {
        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        $request->merge([
            $login_type => $request->input('email'),
        ]);

        return [
            $login_type => $request->get($login_type),
            'password' => $request->get('password'),
        ];
    }



    private function generateSecret()
    {
        $randomBytes = random_bytes(10);

        return Base32::encodeUpper($randomBytes);
    }

    public function logout(Request $request)
    {
        Auth::guard()->logout();
        $request->session()->invalidate();
        return redirect('/login')->withErrors(['alert-success' => 'Successfully logged out!']);
    }
}
