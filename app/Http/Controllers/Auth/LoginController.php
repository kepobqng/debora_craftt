<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        // Ambil redirect dari query string
        $redirect = $request->query('redirect');
        return view('auth.login', ['redirect' => $redirect]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Jika ada redirect URL, validasi dan redirect ke sana
            if ($request->has('redirect') && $request->redirect) {
                $redirectUrl = $request->redirect;
                // Validasi bahwa URL adalah internal (untuk keamanan)
                if (filter_var($redirectUrl, FILTER_VALIDATE_URL)) {
                    $parsedUrl = parse_url($redirectUrl);
                    $appUrl = parse_url(config('app.url'));
                    // Hanya izinkan redirect ke domain yang sama
                    if (isset($parsedUrl['host']) && $parsedUrl['host'] === $appUrl['host']) {
                        return redirect($redirectUrl);
                    }
                } elseif (str_starts_with($redirectUrl, '/')) {
                    // Jika relative URL, langsung redirect
                    return redirect($redirectUrl);
                }
            }
            
            // Redirect berdasarkan role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        throw ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
