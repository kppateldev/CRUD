<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;


class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except([
            'logout', 'dashboard'
        ]);
        $this->middleware('auth')->only('logout', 'dashboard');
    }

    private function checkLoginRedirect()
    {
    	return redirect('admin');
    }

    public function login()
    {
        if ( auth()->guard('admin')->check() ):
            return $this->checkLoginRedirect();
		endif;
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $auth = auth()->guard('admin');
        if($auth->attempt($credentials))
        {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')
                ->withSuccess('You have successfully logged in!');
        }

        return back()->withErrors([
            'email' => 'Your provided credentials do not match in our records.',
        ])->onlyInput('email');

    } 
    
    public function dashboard()
    {
        if(Auth::guard('admin')->check())
        {
            return view('admin.dashboard');
        }
        
        return redirect()->route('admin/login')
            ->withErrors([
            'email' => 'Please login to access the dashboard.',
        ])->onlyInput('email');
    } 
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin/login')
            ->withSuccess('You have logged out successfully!');;
    }    

}