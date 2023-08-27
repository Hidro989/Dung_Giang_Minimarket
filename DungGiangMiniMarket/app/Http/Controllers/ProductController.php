<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'featured_image' => 'max:2048',
            'video' => 'mimes:mp4,avi,mov|max:200000',
            'weight' => 'numeric',
        ]; 

        $messages = [
            'required' => 'Không được bỏ trống :attribute',
            'numeric'  => 'Giá trị phải là số',
            'min' => 'Giá trị phải là số nguyên dương'
        ];

        $attributes = [
            'name' => 'tên sản phẩm',
            'description' => 'mô tả',
            'featured_image' => 'hỉnh ảnh',
            'unit_price' => 'giá',
            'stock' => 'kho'
        ];
                
        $validator = Validator::make($request->input(),$rules,$messages,$attributes);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
        $imgPath = Storage::put('public',$request->file('featured_image'));
        $imgUrl = Storage::url($imgPath);
        $video = $request->file('video');
        if(isset($video)){
            $videoPath = Storage::put('public',$request->file('video'));
            $videoUrl = Storage::url($videoPath);
        }else{
            $videoPath = "";
            $videoUrl = "";
        }
        if(isset($data['is_variant'])){
            $attrIDs = [];
            $variantImgs = $request->file('variant');
            for($i = 0 ; $i < count($data['attributeName']) ; $i++){
                Attribute::insert([
                    'name'  => $data['attributeName'][$i],
                    'value' => $data['attributeValue'][$i],
                ]);
                $attrIDs[] = DB::getPdo()->lastInsertId();
            }
            Product::insert([
                'category_id'    => $data['category_id'],
                'name'           => $data['name'],
                'description'    => $data['description'],
                'featured_image' => $imgUrl,
                'video'          => $videoUrl,
                'attribute_ids'  => implode(',',$attrIDs),
                'weight'         => $data['weight'],
                'is_variant'     => 1
            ]);
            $productID = DB::getPdo()->lastInsertId();
            foreach( $data['variant'] as $index=>$variant){
                if(isset($variantImgs[$index])){
                    $variantImgPath = Storage::put('public',$variantImgs[$index],'public');
                    $variantImgUrl = Storage::url($variantImgPath);
                }
                $variantImgUrl = "";
                Variant::insert([
                    'product_id'       => $productID,
                    'feature_image'    => $variantImgUrl,
                    'attribute_values' => implode(',' ,$variant['name']),
                    'unit_price'       => $variant['unit_price'],
                    'stock'            => $variant['stock']
                ]);
            }

        }else{
            Product::insert([
                'category_id'    => $data['category_id'],
                'name'           => $data['name'],
                'description'    => $data['description'],
                'video'          => $videoUrl,
                'featured_image' => $imgUrl,
                'weight'         => $data['weight'],
                'is_variant'     => 0,
                'unit_price'     => $data['unit_price'],
                'stock'          => $data['stock']
            ]);
            $productID = DB::getPdo()->lastInsertId();
        }
        return redirect()->route('admin.product.create')->with('success','Thêm sản phẩm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
