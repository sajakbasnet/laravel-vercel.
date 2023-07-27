<?php

// app/Http/Controllers/TwoFactorController.php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FA\Support\Google2FA;

class TwoFactorController extends Controller
{
    /**
     * Show the 2FA setup page.
     *
     * @return \Illuminate\View\View
     */
    public function showSetupForm()
    {
        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();

        // Store the secret key in the user's session temporarily
        session(['google2fa_secret' => $secretKey]);

        $qrCodeUrl = $google2fa->getQRCodeGoogleUrl(
            config('app.name'),
            Auth::user()->email,
            $secretKey
        );

        return view('auth.2fa-setup', compact('qrCodeUrl', 'secretKey'));
    }

    /**
     * Enable 2FA for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function enable2FA(Request $request)
    {
        $request->validate([
            'token' => 'required|numeric',
        ]);

        $google2fa = new Google2FA();

        // Verify the provided token against the secret key
        if ($google2fa->verifyKey(session('google2fa_secret'), $request->input('token'))) {
            // Store the secret key in the database and mark 2FA as enabled
            $user = Auth::user();
            $user->google2fa_enabled = true;
            $user->google2fa_secret = encrypt(session('google2fa_secret'));
            $user->save();

            $request->session()->forget('google2fa_secret');

            return redirect()->route('home')->with('success', 'Two-Factor Authentication enabled successfully.');
        }

        return back()->withErrors(['token' => 'Invalid verification code. Please try again.']);
    }

    /**
     * Show the 2FA verification page.
     *
     * @return \Illuminate\View\View
     */
    public function showVerificationForm()
    {
        return view('auth.2fa-verify');
    }

    /**
     * Verify the 2FA token for login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyToken(Request $request)
    {
        $request->validate([
            'token' => 'required|numeric',
        ]);

        $google2fa = new Google2FA();

        // Verify the provided token against the user's secret key
        if ($google2fa->verifyKey(decrypt(Auth::user()->google2fa_secret), $request->input('token'))) {
            // The token is valid, log in the user
            return redirect()->intended('/home');
        }

        return back()->withErrors(['token' => 'Invalid verification code. Please try again.']);
    }

    /**
     * Disable 2FA for the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disable2FA()
    {
        $user = Auth::user();
        $user->google2fa_enabled = false;
        $user->google2fa_secret = null;
        $user->save();

        return redirect()->route('home')->with('success', 'Two-Factor Authentication disabled successfully.');
    }
}

