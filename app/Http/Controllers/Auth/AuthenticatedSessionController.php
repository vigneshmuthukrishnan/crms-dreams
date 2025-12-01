<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Attendance;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();
        if ($user->admin == 0) {
            $today = date('Y-m-d');
            $attendance = \App\Models\Attendance::where('user_id', $user->id)->where('date', $today)->first();
            if(!$attendance){
                \App\Models\Attendance::create([
                    'user_id'    => $user->id,
                    'date'       => $today,
                    'login_time' => now(),
                ]);
            }
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function closeDay(Request $request)
    {
        $today = date('Y-m-d');
        $user = Auth::user();
        $attendance = Attendance::where('user_id', $user->id)->where('date', $today)->first();
        if($attendance && !$attendance->logout_time){
            $attendance->logout_time = now();
            $attendance->save();
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
             return redirect('/login')->with('success', 'Your day has been closed and you have been logged out.');
        } else {
            return back()->with('info', 'Your day is already closed.');
        }
    }
}
