<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Add this import
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    public function showLoginForm()
    {
        return view('auth.login');  // Adjust if your Blade file is somewhere else
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Debugging: Check if authenticated() is being called
            Log::info('Login successful', ['user_id' => Auth::id()]);

            return $this->authenticated($request, Auth::user())
                ?: redirect()->intended($this->redirectPath());
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        // Debugging: Log the user's roles
        Log::debug('User roles:', ['roles' => $user->getRoleNames()->toArray()]);

        if ($user->hasRole('SuperAdmin')) {
            return redirect()->route('backend.controlpanel.superadmin.dashboard');
        }
        if ($user->hasRole('Admin')) {
            return redirect()->route('backend.controlpanel.admin.dashboard');
        }
        // ... other role checks

        Log::warning('No role match for user', ['user_id' => $user->id]);
        return redirect('/');
    }
}
