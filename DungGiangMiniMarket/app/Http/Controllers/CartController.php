<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index() {
        $carts = DB::table('cart_items')
        ->join('products', 'cart_items.product_id', '=', 'products.id')
        ->select( 'cart_items.*', 'products.name', 'products.unit_price', 'products.featured_image' )
        ->get();
        return view('shopping-cart', compact('carts'));
    }

    public function add( Request $request ) {

        $cart_item = [
            'user_id' => $request->get('user_id'),
            'product_id' => $request->get('product_id'),
            'quantity' => $request->get('quantity'),
        ];

        $item = DB::table('cart_items')->where('product_id', $cart_item['product_id'])->where('user_id', $cart_item['user_id'])->first();

        if( $cart_item['quantity'] === null ){

            if($item !== null) {
                $cart_item['quantity'] = $item->quantity + 1;
                DB::table('cart_items')->where('product_id', $cart_item['product_id'])->where('user_id', $cart_item['user_id'])->update($cart_item);

            }else{
                $cart_item['quantity'] = 1;
                DB::table('cart_items')->insert($cart_item);
            }


        }else{
            if($item !== null) {
                $cart_item['quantity'] += $item->quantity;
                DB::table('cart_items')->where('product_id', $cart_item['product_id'])->where('user_id', $cart_item['user_id'])->update($cart_item);
            }else{
                DB::table('cart_items')->insert($cart_item);
            }
        }

        return response()->json(['success' => 'Thêm vào giỏ hàng thành công']);

    }

    public function update( Request $request ) {
        DB::table('cart_items')->where('id', $request->get('id'))->update(['quantity' => $request->get('quantity')]);
        return response()->json(['success' => 'Cập nhật thành công']);
    }

    public function destroy( Request $request ) {
        DB::table('cart_items')->delete($request->get('id'));
        return response()->json(['success' => 'Xóa giỏ thành công']);
    }
}
