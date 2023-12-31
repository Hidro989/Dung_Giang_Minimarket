<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    private $user;

    public function get_all_user(){
        $users = DB::table('users')->where('role', 1)->get();
        return view('admin.user.index', compact('users'));
    }

    private function formatProducts( $products ){
        foreach($products as $product){
            if(count($product->variants) != 0 ){
                $newPrice = formatCurrency($product->variants->min('unit_price')) ." - ". formatCurrency($product->variants->max('unit_price'));
                $product->setAttribute('unit_price',$newPrice);
            }else{
                $product->setAttribute('unit_price',formatCurrency($product->unit_price));
            }
        }
    }

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

    public function index() {
        $month = date('m');

        $monthly_revenue = DB::table('orders')
        ->where('status', 2)
        ->whereMonth('created_date', $month)
        ->sum('total_price');

        $total_orders_delivered = DB::table('orders')
        ->where('status', 2)
        ->count();

        $total_orders = DB::table('orders')
        ->count();

        $date_revenue = DB::table('orders')
        ->where('status', 2)
        ->whereDate('created_date', date('Y-m-d'))
        ->sum('total_price');

        $order_awaiting_confirmation = DB::table('orders')
        ->where('status', 0)
        ->count();

        $percent_of_total_order = ($total_orders_delivered / $total_orders) * 100;

        return view('admin.index', compact('monthly_revenue', 'date_revenue', 'order_awaiting_confirmation', 'percent_of_total_order'));
    }

    public function home() {
        $categories = Category::all();
        $products = Product::select('products.*', DB::raw('COUNT(reviews.id) as review_count'), DB::raw('AVG(reviews.stars) as star_rate'))
        ->groupBy('products.id')
        ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
        ->get();
        $ratestProducts = Product::select('products.*', DB::raw('COUNT(reviews.id) as review_count'), DB::raw('AVG(reviews.stars) as star_rate'))
        ->join('reviews', 'products.id', '=', 'reviews.product_id')
        ->groupBy('products.id')
        ->orderByDesc('review_count')
        ->take(6)
        ->get();
        $lastProducts = Product::select('products.*', DB::raw('COUNT(reviews.id) as review_count'), DB::raw('AVG(reviews.stars) as star_rate'))
        ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
        ->groupBy('products.id')
        ->orderBy('id','desc')
        ->take(6)
        ->get();
        $this->formatProducts($lastProducts);
        $this->formatProducts($products);
        $this->formatProducts($ratestProducts);
        return view('home', compact( 'categories','products','lastProducts', 'ratestProducts' ));
    }


    public function logout() {
        $cookie = cookie('user', null, 0);
        return redirect()->route('login')->withCookie( $cookie );
    }

    public function register() {
        return view('register');
    }

    public function handle_register( Request $request ) {
        $user = [
            'fullname'      => $request->input('fullname'),
            'username'      => $request->input('username'),
            'password'      => $request->input('password'),
            'phone'         => $request->input('phone'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender'        => $request->input('gender'),
            'address'       => $request->input('address'),
            'role'          => 1,
        ];


        $validator = Validator::make(
            $request->all(),
            [
                'fullname'           => 'required',
                'username'           => 'required|min:4|unique:users',
                'password'           => 'required|min:6|confirmed',
                'phone'              => 'required|numeric|digits:10',
                'date_of_birth'      => 'required|date',
                'gender'             => 'required',
                'address'            => 'required',
            ],
            [
                'required'           => 'Vui lòng nhập trường :attribute',
                'min'                => 'Độ dài tối thiểu của :attribute là :min kí tự',
                'confirmed'          => 'Xác nhận mật khẩu không khớp',
                'date'               => 'Định dạng ngày tháng không hợp lệ',
                'numeric'            => 'Định dạng số điện thoại không hợp lệ',
                'digits'             => 'Số điện thoại phải có 10 chữ số',
                'unique'             => 'Tên tài khoản đã tồn tại',
            ],
            [
                'fullname'           => 'họ và tên',
                'username'           => 'tên tài khoản',
                'password'           => 'mật khẩu',
                'phone'              => 'số điện thoại',
                'date_of_birth'      => 'ngày sinh',
                'gender'             => 'giới tính',
                'address'            => 'địa chỉ',
            ]
        );
        if( $validator->fails() ) {
            return back()
            ->withInput()
            ->withErrors($validator);
        }
        
        
        try {
            DB::table('users')->insert($user);
        }catch(\Throwable $th){
            return back()->withInput()->with('error','Tạo tài khoản thất bại');
        }
        return redirect()->route('login');

    }

    public function changePassword( Request $request ) {
        $old_password = $request->input('old_password');
        $user_id = $request->input('user_id');
        $new_password = $request->input('password');

        $validator = Validator::make(
            $request->all(),
            [
                'user_id'            => 'required',
                'password'           => 'required|min:6|confirmed',
                'old_password'       => 'required|min:6',
            ],
            [
                'required'           => 'Vui lòng nhập trường :attribute',
                'min'                => 'Độ dài tối thiểu của :attribute là :min kí tự',
                'confirmed'          => 'Xác nhận mật khẩu không khớp',

            ],
            [
                'old_password'       => 'mật khẩu cũ',
                'password'           => 'mật khẩu',
            ]
        );

        if( $validator->fails() ) {
            return response()->json(
            [
                'errors' => $validator->errors(),
                'old_input' => $request->all(),
            ], 422);
        }

        $user = DB::table('users')->where('id', $user_id)->first();
        if( $user->password !== $old_password ) {
            return response()->json(
                [
                    'errors' => ['old_password' => ['Mật khẩu cũ không chính xác']],
                    'old_input' => $request->all(),
                ], 422);
        }

        DB::table('users')->where('id', $user_id)->update(['password' => $new_password]);

        return response()->json(['success' => 'Thay đổi mật khẩu thành công']);
    }

    public function updateInformation( Request $request ) {
        $user_id = $request->input('user_id');
        $user = [
            'fullname'      => $request->input('fullname'),
            'phone'         => $request->input('phone'),
            'date_of_birth' => $request->input('date_of_birth'),
            'gender'        => $request->input('gender'),
            'address'       => $request->input('address'),
        ];


        $validator = Validator::make(
            $request->all(),
            [
                'fullname'           => 'required',
                'phone'              => 'required|numeric|digits:10',
                'date_of_birth'      => 'required|date',
                'gender'             => 'required',
                'address'            => 'required',
            ],
            [
                'required'           => 'Vui lòng nhập trường :attribute',
                'min'                => 'Độ dài tối thiểu của :attribute là :min kí tự',
                'date'               => 'Định dạng ngày tháng không hợp lệ',
                'numeric'            => 'Định dạng số điện thoại không hợp lệ',
                'digits'             => 'Số điện thoại phải có 10 chữ số',
            ],
            [
                'fullname'           => 'họ và tên',
                'phone'              => 'số điện thoại',
                'date_of_birth'      => 'ngày sinh',
                'gender'             => 'giới tính',
                'address'            => 'địa chỉ',
            ]
        );

        if( $validator->fails() ) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                    'old_input' => $request->all(),
                ], 422);
        }
        DB::table('users')->where('id', $user_id)->update($user);
        $this->user = DB::table('users')->where('id', $user_id)->first();
        $cookie = cookie('user', json_encode($this->user), 1440);
        return response()->json(['success' => 'Cập nhật thông tin thành công'])->cookie($cookie);;
    }


    public function destroy(Request $request)
    {
        $id = $request->input('id');
        try {
            $user = User::findOrFail($id);
            $user->delete();
        }catch(\Throwable $th) {
            return redirect()->route('admin.user.index')->with(['error' => 'Xoá loại hàng thất bại']);
        }

        return redirect()->route('admin.user.index')->with(['success' => 'Xoá loại hàng thành công']);
    }

}
