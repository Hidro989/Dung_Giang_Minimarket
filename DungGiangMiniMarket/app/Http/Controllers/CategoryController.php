<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Category::all();
        return view('admin.category.index', compact('data') );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $imagePath = '';
        $imageName = '';
        $image = $request->file('image');
        if( $request->hasFile('image') ){
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('assets/img/categories', $imageName, 'public');
        }
        

        $request->validate(
            [ 
                'name' => 'required|max:255',
                'image' => 'required|image|max:10000' 
            ],
            [
                 'name.required' => 'Vui lòng nhập tên loại hàng',
                 'name.max' => 'Tên loại hàng không lớn hơn 255 kí tự',
                 'image.required' => 'Vui lòng chọn ảnh',
                 'image.image' => 'Vui lòng chọn ảnh',
                 'image.max' => 'Kích thước ảnh tối đa là 10MB'

            ],
        );

        try {
            Category::insert([ 'name' => $name, 'image' => $imagePath] );
            $image->move('assets/img/categories', $imageName);
        }catch(\Throwable $th) {
            $name = $request->old('name');
            return redirect()->route('admin.category.create');
        }

        return redirect()->route('admin.category.index')->with(['success' => 'Thêm mới loại hàng thành công']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category  = DB::table('categories')->find($id);
        } catch (\Throwable $e) {
            return redirect()->route('admin.category.index')->withErrors('Không tìm thấy bản ghi', 'error');
        }
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $category = DB::table('categories')->find($id);
        } catch (\Throwable $e) {
            return redirect()->route('admin.category.index')->withErrors('Không tìm thấy bản ghi', 'error');
        }
        
        $name = $request->input('name');

        $imagePath = '';
        $imageName = '';
        $image = $request->file('image');
        if( $request->hasFile('image') ){
            $imageName = $image->getClientOriginalName();
            $imagePath = $image->storeAs('assets/img/categories', $imageName, 'public');
        }
        

        $request->validate(
            [ 
                'name' => 'required|max:255',
            ],
            [
                 'name.required' => 'Vui lòng nhập tên loại hàng',
                 'name.max' => 'Tên loại hàng không lớn hơn 255 kí tự',
            ],
        );
        
        if( $name === $category->name && $imagePath === $category->image ){
            return redirect()->route('admin.category.index');
        }

        $filePath = public_path($category->image);

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        try {

            DB::table('categories')->where('id', $id)->update(['name' => $name, 'image' => $imagePath]);
            $image->move('assets/img/categories', $imageName);

        }catch(\Throwable $th) {
            $request->flash();
            return redirect()->route('admin.category.edit', $id)->withInput();
        }

        return redirect()->route('admin.category.index')->with(['success' => 'Cập nhật loại hàng thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
        }catch(\Throwable $th) {
            return redirect()->route('admin.category.index')->with(['error' => 'Xoá loại hàng thất bại']);
        }

        return redirect()->route('admin.category.index')->with(['success' => 'Xoá loại hàng thành công']);
    }
}
