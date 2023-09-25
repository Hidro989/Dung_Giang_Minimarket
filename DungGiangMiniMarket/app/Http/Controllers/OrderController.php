<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index() {
        $orders = DB::table('orders')
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->select('orders.*', 'users.fullname', 'users.date_of_birth', 'users.gender', 'users.phone')
        ->get();

        $order_details = DB::table('order_details')
        ->join('products', 'order_details.product_id', '=', 'products.id')
        ->select('order_details.*', 'products.name', 'products.unit_price', 'products.featured_image')
        ->get();
        $list_orders = array();
    
        foreach($orders as $order) {
            $arr = json_decode(json_encode ( $order ) , true);
            foreach($order_details as $detail) {
                if( $order->id == $detail->order_id ){
                    $arr['order_details'][] = $detail;
                }
            }
            $list_orders[] = $arr;
        }
        return view('admin.order.index', compact('list_orders'));
    }

    public function checkout( $user_id ) {
        
        $user = DB::table('users')->where('id', $user_id)->first();
        $carts = DB::table('cart_items')
        ->where('user_id', $user_id)
        ->join('products', 'cart_items.product_id', '=', 'products.id')
        ->select( 'cart_items.*', 'products.name', 'products.unit_price')
        ->get();
        return view('checkout', compact('carts', 'user'));
    }

    public function stored( Request $request ) {
       
        if( $request->input('payment_form') !== 'cod') {
            abort(404);
        }

        if( $request->input('cart_items') == null) {
            return redirect()->route('/');
        }

        $address = '';
        if( $request->input('sub_address') !== null ) {
            $address = $request->input('main_address') . ' ' . $request->input('sub_address');
        }else {
            $address = $request->input('main_address');
        }
        $order_data = [
            'user_id' => $request->input('user_id'),
            'status' => 0,
            'total_price' => 0,
            'created_date' => date('Y-m-d'),
            'address' => $address,
        ];

        $order_id = DB::table('orders')->insertGetId($order_data);
        $total_order_price = 0;
        foreach ( $request->input('cart_items') as $id) {
            $item = DB::table('cart_items')
            ->where('cart_items.id', $id)
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->select( 'cart_items.*', 'products.name', 'products.unit_price' )
            ->first();
            
            $order_detail_data = [
                'order_id' => $order_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'total_price' => $item->quantity * $item->unit_price,
            ];

            $total_order_price += $order_detail_data['total_price'];

            DB::table('order_details')->insert($order_detail_data);
            DB::table('cart_items')->delete($id);
        }

        DB::table('orders')->where('id', $order_id)->update(['total_price' => $total_order_price]);
        
        return view('checkout-success', compact('order_id'));
    }

    public function update_status( Request $request ) {
        DB::table('orders')->where('id', $request->get('id'))->update(['status' => $request->get('new_status')]);
        return redirect()->back();
    }

    public function get_12month_revenue(){
        $results = DB::table('orders')
        ->select(DB::raw('YEAR(created_date) as year'), DB::raw('MONTH(created_date) as month'), DB::raw('SUM(total_price) as revenue'))
        ->where('created_date', '>=', now()->subMonths(12))
        ->where('status', 2)
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        return response()->json($results);
    }
}
