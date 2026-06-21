<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard.index');
        } else {
            return response()->view('auth.login');
        }
    }

    public function authenticate(Request $request)
    {
        $login_type = filter_var($request->input('email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $credentials = [$login_type => $request->$login_type, 'password' => $request->input('password')];

        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json(['message' => 'تم تسجيل الدخول بنجاح'], Response::HTTP_OK);
        } else {
            return response()->json(['message' => 'البيانات المدخلة غير صحيحة'], Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        return redirect()->route('auth.login');
    }
}
