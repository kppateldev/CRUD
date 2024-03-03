<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use Redirect;
use App\Models\User;
use App\Models\Admin;
use Artisan;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function dashboard()
    {   
        return view('admin.dashboard');
    }

    public function logout()
    {
        $auth = auth()->guard('admin');
        $auth->logout();
        return Redirect::route('admin.login');
    }

}
