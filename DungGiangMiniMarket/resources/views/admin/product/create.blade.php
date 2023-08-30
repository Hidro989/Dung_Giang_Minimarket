@extends('layouts.app-admin')
 
@section('title', 'Products')

@php 
    $product = true;
    $create = 'active';
@endphp

@section('content')
    <style>
        input[name="is_variant"]{
            width:20px;
            height:30px;
        }
    </style>
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
            <button type=" button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="container">
        <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" class="form-select form-control" aria-label="Default select example" name="category_id">
                    @foreach ($categories as $item)
                        <option value="{{ $item->id}}">{{ $item->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="featured_image">Ảnh đặc trưng:</label>
                <input type="file" name="featured_image" class="form-control-file" id="featuredImageInput" onchange="previewFeaturedImage(event)" accept=".jpg, .jpeg, .png">
                <img class="mt-3" id="featuredImagePreview" src="#" alt="Featured Image Preview" style="max-width: 200px; display: none;">
                @error('featured_image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="video">Video:</label>
                <input type="file" name="video" class="form-control-file" id="videoInput" accept=".mp4,.avi,.mov" onchange="previewVideo(event)">
                <video class="mt-3" id="videoPreview" controls style="max-width: 400px; display: none;">
                    <source id="videoSource" src="" type="video/mp4">
                </video>
            </div>
            
            <div class="form-group">
                <label for="weight">Cân nặng: (Kg)</label>
                <input type="number" name="weight" class="form-control" value="{{ old('weight') }}">
            </div>            

            <div class="form-group d-flex align-items-center ">
                <label for="is_variant" class="mr-2">Phân loại:</label>
                @if(old('is_variant') == null)
                <input type="checkbox" name="is_variant" id="isVariantCheckbox" onchange="toggleVariantFields()">
                @else
                <input type="checkbox" name="is_variant" id="isVariantCheckbox" onchange="toggleVariantFields()" checked>
                @endif
            </div>
{{-- variant of product --}}
            <div id="variantFieldsGroup" style="display: none">
                <div class="variant-control">
                    <div id="add-classify" class="btn btn-primary mb-3">Thêm nhóm phân loại</div>
                    
                </div>

                <div id="variant-list" class="form-group mt-3">
                    <label for="" class="mr-5">Danh sách phân loại:</label>
                    <div class="input-group bulk-apply">
                        <input type="number" aria-label="First name" class="form-control" placeholder="Giá sản phẩm" name="bulk-price" value="{{old('bulk-price')}}">
                        <input type="number" aria-label="Last name" class="form-control" placeholder="Số lượng kho" name="bulk-stock" value="{{old('bulk-stock')}}">
                        <div class="input-group-append" id="button-addon4">
                            <button id="bulk-apply-btn" class="btn btn-primary" type="button">Áp dụng cho tất cả</button>
                        </div>
                    </div>
                </div>
                <table id="variant-table" class="table table-bordered mt-4">
                
                </table>
            </div>

            <div id="simpleFieldsGroup">
                <div class="form-group">
                    <label for="unit_price">Giá: (VND)</label>
                    <input type="text" name="unit_price" class="form-control @error('unit_price') is-invalid @enderror" value="{{ old('unit_price') }}">
                    @error('unit_price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="stock">Số lượng trong kho:</label>
                    <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock') }}" >
                    @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Tạo sản phẩm</button>
            </div>
        </form>
    </div>
    
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/bootstrap-table.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            toggleVariantFields();
        })
        function previewFeaturedImage(event) {
            var input = event.target;
            var previewImage = document.getElementById("featuredImagePreview");
        
            if (input.files && input.files[0]) {
                var reader = new FileReader();
        
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = "block";
                };
        
                reader.readAsDataURL(input.files[0]);
            } else {
                previewImage.src = "#";
                previewImage.style.display = "none";
            }
        }
        function previewVideo(event) {
            var input = event.target;
            var videoPreview = document.getElementById("videoPreview");
            var videoSource = document.getElementById("videoSource");
            if (input.files && input.files[0]) {
                videoSource.src = URL.createObjectURL(input.files[0]);
                videoPreview.style.display = "block";
                videoPreview.load(); 
                } else {
                    videoSource.src = "";
                    videoPreview.style.display = "none";
                }
        }
        function toggleVariantFields() {
            var isVariantCheckbox = document.getElementById("isVariantCheckbox");
            var variantFieldsGroup = document.getElementById("variantFieldsGroup");
            var simpleFieldsGroup = document.getElementById("simpleFieldsGroup");

            if (isVariantCheckbox.checked) {
                variantFieldsGroup.style.display = "block";
                simpleFieldsGroup.style.display = "none";
                $(simpleFieldsGroup).find("input").prop("disabled",true);
                $(variantFieldsGroup).find("input").prop("disabled",false);
                if(classify.length == 0){
                    var variantControl = document.querySelector('.variant-control');
                    variantControl.insertAdjacentHTML('beforeend', classify1Html);
                }
            } else {
                variantFieldsGroup.style.display = "none";
                simpleFieldsGroup.style.display = "block";
                $(simpleFieldsGroup).find("input").prop("disabled",false);
                $(variantFieldsGroup).find("input").prop("disabled",true);
            }
        }

        var addClassify = document.getElementById('add-classify');
        var classify = document.getElementsByClassName('classify');
        var classify1Html = `<div class="input-group classify">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Phân loại 1</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="attributeName[]" placeholder="VD: Màu" oninput="generateTable()">
                    <input type="text" aria-label="Last name" class="form-control" name="attributeValue[]" placeholder="VD: đỏ,vàng,xanh" oninput="generateTable()">
                    <div class="input-group-append" id="button-addon4">
                        <button class="btn btn-danger deleteClassify" type="button" onclick="deleteEvent()">Xóa</button>
                    </div>
                </div>`
        var classify2Html = `<div class="input-group mt-3 classify">
                <div class="input-group-prepend">
                      <span class="input-group-text">Phân loại 2</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="attributeName[]" placeholder="VD: Kích thước" oninput="generateTable()">
                    <input type="text" aria-label="Last name" class="form-control" name="attributeValue[]" placeholder="VD: X,S,M" oninput="generateTable()">
                    <div class="input-group-append" id="button-addon4">
                        <button class="btn btn-danger deleteClassify" type="button" onclick="deleteEvent()">Xóa</button>
                    </div>
                </div>`
        addClassify.onclick = function(){
            var variantControl = document.querySelector('.variant-control');
            if(classify.length == 0){
                variantControl.insertAdjacentHTML('beforeend', classify1Html);
            }else if(classify.length == 1){
                variantControl.insertAdjacentHTML('beforeend', classify2Html);
            }
            if(classify.length >= 2){
                addClassify.style.display = 'none';
                return;
            }
        }
        function deleteEvent(){
            if(classify.length > 0){
                var variantControl = document.querySelector('.variant-control');
                classify[classify.length - 1].remove();
                addClassify.style.display = 'inline-block';
                if (classify.length == 0){
                    var isVariantCheckbox = document.getElementById("isVariantCheckbox")
                    isVariantCheckbox.click();
                    return;
                }
                generateTable();
            }
        }

        function generateTable(){
            $('#variant-table').bootstrapTable('destroy');
            let [classify1,classify2] = classify;
            let name1,value1,name2,value2;
            let columns = [];
            let data = [];
            if(classify1 != null && classify2 == null){
                [name1,value1] = classify1.querySelectorAll('input');
                columns = [ {field : 'classify1',title: name1.value}, {field : 'feturedImage',title: 'Ảnh'}, {field : 'price', title: 'Giá (VND)'}, {field : 'stock',title: 'Kho'} ];
                if(value1.value.trim() != ""){
                    value1 = value1.value.split(',');
                    for( let [index,value] of value1.entries()){
                        data.push({
                            classify1: `${value} <input type="hidden" name="variant[${index}][name][]" value="${value}">`,
                            feturedImage: `<input type="file" name="variant[${index}]" accept=".jpg,.png,.jpeg">`,
                            price: `<input type="number" class="form-control variant-price" name="variant[${index}][unit_price]">`,
                            stock: `<input type="number" class="form-control variant-stock" name="variant[${index}][stock]">`
                        })
                    }
                }
            } else if(classify2 != null){
                [name1,value1] = classify1.querySelectorAll('input');
                [name2,value2] = classify2.querySelectorAll('input');
                columns = [{ field : 'classify1', title: name1.value, }, {field : 'classify2',title: name2.value}, {field : 'feturedImage',title: 'Ảnh'}, {field : 'price', title: 'Giá (VND)'}, {field : 'stock',title: 'Kho'} ];
                if(value2.value.trim() != ""){
                    value1 = value1.value.split(',');
                    value2 = value2.value.split(',');
                    let index = 0;
                    for( let [i,val1] of value1.entries() ){
                        for( let [j,val2] of value2.entries() ){
                            data.push({
                                classify1: `${val1} <input type="hidden" name="variant[${index}][name][]" value="${val1}">`,
                                classify2: `${val2} <input type="hidden" name="variant[${index}][name][]" value="${val2}"`,
                                feturedImage: `<input type="file" name="variant[${index}]" accept=".jpg,.png,.jpeg">`,
                                price: `<input type="text" class="form-control variant-price" name="variant[${index}][unit_price]">`,
                                stock: `<input type="text" class="form-control variant-stock" name="variant[${index}][stock]">`
                            })
                            index++;
                        }
                    }
                }
            }
            if(columns.length != 0){
                $('#variant-table').bootstrapTable({
                    columns,
                    data,
                    formatLoadingMessage: function() {
                        return ''; 
                    }
                })
            }            
        }
        $('#bulk-apply-btn').on('click',function(){
            const [price,stock] = $('.bulk-apply .form-control');
            if(price.value.trim() != ""){
                $('.variant-price').val(price.value);
            }
            if(stock.value.trim() != ""){
                $('.variant-stock').val(stock.value);
            }
        })
        </script>
@endpush
