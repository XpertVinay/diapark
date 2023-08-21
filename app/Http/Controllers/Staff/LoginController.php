<?php

namespace App\Http\Controllers\Staff;

use Hash;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Staffs;

class LoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::STAFF_HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login(Request $request)
    {
    	return view('staff.login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function doLogin(Request $request)
    {
        $model = Staffs::where('email', $request->email)->first();
        if (!$model) {
            return  redirect('/staff/login')->with("message", "User not found");
        }
        if(!Hash::check($request->password, $model->password, [])){
            return  redirect('/staff/login')->with("message", "Wrong email or password");
        }
        $request->session()->put('restaurantid', $model->restaurantid);
        $request->session()->put('id', $model->id);
        $request->session()->put('name', $model->name);
        $request->session()->put('email', $model->email);
        return redirect('/staff/tablereservation');
    }
}
