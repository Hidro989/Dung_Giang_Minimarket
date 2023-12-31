<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Review;
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
    public function search(Request $request){
        $key = $request->input('key');
        $categories = Category::all();
        $products = Product::select('products.*', DB::raw('COUNT(reviews.id) as review_count'), DB::raw('AVG(reviews.stars) as star_rate'))
        ->groupBy('products.id')
        ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
        ->where(function ($query) use ($key){
            $query->where('name', 'LIKE', '%' . $key . '%');
        })->with('variants')->paginate(10);
        $lastProducts = Product::orderBy('id','desc')->take(6)->get();
        $this->formatProducts($lastProducts);
        $this->formatProducts($products);
        return view('shop-grid',compact('products','categories','lastProducts'));
    }
    public function shop_grid($catetory_id){
        if($catetory_id == 'all'){
            $products = Product::select('products.*', DB::raw('COUNT(reviews.id) as review_count'), DB::raw('AVG(reviews.stars) as star_rate'))
            ->groupBy('products.id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')->paginate(10);
        }else{
            $products = Product::select('products.*', DB::raw('COUNT(reviews.id) as review_count'), DB::raw('AVG(reviews.stars) as star_rate'))
            ->groupBy('products.id')
            ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
            ->where('category_id',$catetory_id)->with('variants')->paginate(10);
        }
        $categories = Category::all();
        $lastProducts = Product::select('products.*', DB::raw('COUNT(reviews.id) as review_count'), DB::raw('AVG(reviews.stars) as star_rate'))
        ->leftJoin('reviews', 'products.id', '=', 'reviews.product_id')
        ->groupBy('products.id')
        ->orderBy('id','desc')
        ->take(6)
        ->get();
        $this->formatProducts($lastProducts);
        $this->formatProducts($products);
        return view('shop-grid',compact('products','categories','lastProducts'));       
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
    public function index()
    {
        $products = Product::with('variants')->with('category')->get();
        $this->formatProducts($products);
        $categories = Category::all();
        return view('admin.product.index',compact('products','categories'));
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
    public function find(Request $request){
       $productId = $request->input('id');
       $attribute1 = $request->has('attribute0') ? $request->input('attribute0') : null;
       $attribute2 = $request->has('attribute0') ? $request->input('attribute1') : null;
       $data = null;
       if($attribute1 != null && $attribute2 == null){
            $data = Variant::where([
                'product_id' => $productId,
                'attribute_values' => $attribute1
            ])->get()->first();
       }else if ($attribute1 != null && $attribute2 != null ){
            $data = Variant::where('product_id',$productId)->where(function ($query) use ($attribute1,$attribute2){
                $query->where('attribute_values', 'LIKE', '%' . $attribute1 . ',' . $attribute2 . '%')
                ->orWhere('attribute_values', 'LIKE', '%' . $attribute2 . ',' . $attribute1 . '%');
            })->get()->first();
       }else{
            $data = Product::find($productId);
       }
       $data->setAttribute('unit_price',formatCurrency($data->unit_price));
       return response()->json($data);
    }
    public function store(Request $request)
    {
        $data = $request->input();
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'featured_image' => 'required',
            'video' => 'mimes:mp4,avi,mov|max:200000',
            'weight' => 'numeric',
        ]; 

        $messages = [
            'required' => 'Không được bỏ trống :attribute',
            'numeric'  => 'Giá trị phải là số',
            'min'      => 'Giá trị phải là số nguyên dương'
        ];

        $attributes = [
            'name'           => 'tên sản phẩm',
            'description'    => 'mô tả',
            'featured_image' => 'hỉnh ảnh',
            'unit_price'     => 'giá',
            'stock'          => 'kho'
        ];
                
        $validator = Validator::make($request->all(),$rules,$messages,$attributes);
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
                $variantImgUrl = "";
                if(isset($variantImgs[$index])){
                    $variantImgPath = Storage::put('public',$variantImgs[$index],'public');
                    $variantImgUrl = Storage::url($variantImgPath);
                }
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
    public function show($id)
    {
        $product = Product::with('variants')->with('category')->find($id);
        $categories = Category::all();
        if (!$product) {
            abort(404);
        }
        $reviews = Review::where('product_id',$id)->with('user',)->get();
        $relatedProducts = Product::whereNotIn('id',[$product->id])->where('category_id',$product->category->id)->get();
        $this->formatProducts($relatedProducts);
        $attrIds = explode(',',$product->attribute_ids);
        $attributes = Attribute::whereIn('id',$attrIds)->get();
        foreach($attributes as $attribute){
            $attribute->setAttribute('value',explode(',',$attribute->value));

        }
        if(count($product->variants) != 0 ){
            $newPrice = formatCurrency($product->variants->min('unit_price')) ." - ". formatCurrency($product->variants->max('unit_price'));
            $product->setAttribute('unit_price',$newPrice);
        }else{
            $product->setAttribute('unit_price',formatCurrency($product->unit_price));
        }
        return view('shop-detail', compact('product', 'attributes','relatedProducts','reviews','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::all();
        $productEdit = Product::with('variants')->with('category')->find($id);
        $attrIds =  explode(',',$productEdit->attribute_ids);
        $attributes = Attribute::whereIn('id',$attrIds)->get();
        $productEdit->setAttribute('attributes',$attributes);
        return view('admin.product.edit', compact('categories','productEdit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = DB::table('products')->find($id);
        $data = $request->all();
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
            'min'      => 'Giá trị phải là số nguyên dương'
        ];

        $attributes = [
            'name'           => 'tên sản phẩm',
            'description'    => 'mô tả',
            'featured_image' => 'hỉnh ảnh',
            'unit_price'     => 'giá',
            'stock'          => 'kho'
        ];
                
        $validator = Validator::make($request->input(),$rules,$messages,$attributes);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        if(isset($data['is_variant'])){
           
        }
        else{
            if(isset($data['featured_image'])){
                $imgPath = Storage::put('public',$data['featured_image']);
                $imgUrl = Storage::url($imgPath);
            }else{
                $imgUrl = $product->featured_image;
            }
            if(isset($data['video'])){
                $videoPath = Storage::put('public',$data['video']);
                $videoUrl = Storage::url($videoPath);
            }else{
                $videoUrl = $product->video;
            }
            try {
                DB::table('products')->where('id', $id)->update([
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
            }catch(\Throwable $th) {
                $request->flash();
                return redirect()->route('admin.product.edit', $id)->withInput();
            }
        }
        return redirect()->route('admin.product.edit', $id)->with('success','Sửa sản phẩm thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Product::destroy($product->id);
        return redirect()->route('admin.product.index')->with('success','Xóa sản phẩm thành công');
    }
}
