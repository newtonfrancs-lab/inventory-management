<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the Glassmorphic Login Form.
     */
    public function showLoginForm()
    {
        // If user is already logged in, send them to dashboard
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('login');
    }

    /**
     * Handle the Login Request (Email or Phone).
     */
// app/Http/Controllers/Auth/LoginController.php

public function login(Request $request)
{
    // 1. Validate inputs
    $request->validate([
        'login_identity' => 'required',
        'password' => 'required',
    ]);

    $identity = $request->input('login_identity');
    $fieldType = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

    $credentials = [
        $fieldType => $identity,
        'password' => $request->password,
    ];

    // 2. Attempt Login
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('home');
    }

    // 3. If it reaches here, login FAILED. 
    // Let's return with a specific error message.
    return back()->withErrors([
        'login_identity' => 'Login failed. Check if user exists for: ' . $fieldType,
    ]);
}

public function logout(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'You have been logged out.');
}

}