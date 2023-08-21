<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
    private $user;

    public function handle_login( Request $request ) {
        $username = $request->input('username');
        $password = $request->input('password');


        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'required' => 'Vui lòng nhập trường :attribute',
            ],
            [
                'username' => 'tên tài khoản',
                'password' => 'mật khẩu',
            ]
        );

        if( $validator->fails() ) {
            return back()
            ->withInput()
            ->withErrors($validator);
        }

        try{
            $this->user = DB::table('users')->where( 'username', $username )->where( 'password', $password )->first();     
        }catch (\Throwable $th) {
            return redirect()->route('login')->withInput()->with('error',"Đăng nhập thất bại");
        }

        if( ! isset($this->user) ){
            return redirect()->route('login')->withInput()->with('error', "Thông tin tài khoản hoặc mật khẩu không chính xác");
        }

        $cookie = cookie('user', json_encode($this->user), 1440);
        switch( $this->user->role ) {
            case 0:
                return redirect()->route('admin.dashboard')->withCookie( $cookie );
                break;
            case 1:
                return redirect()->route('/')->withCookie( $cookie );
                break;
            default: 
        }
    }

    public function login() {
        return view('login');
    }

    public function index( Request $request ) {

        $user = $request->cookie('user');
        
        View::share('user', $user );
        return view('admin.index');
    }

    public function home( Request $request ) {
        $user = $request->cookie('user');
        View::share('user', $user);
        return view('home');
    }


    public function logout() {
        $cookie = cookie('user', null, 0);
        return redirect()->route('login')->withCookie( $cookie );
    }

    public function register() {
        return view('register');
    }

    public function handle_register( Request $request ) {
        
    }

}
