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
    <div class="container">
        <form action="{{ route('product.store') }}" method="POST">
            <div class="form-group">
                <label for="name">Tên sản phẩm:</label>
                <input type="text" name="name" class="form-control" >
            </div>
            
            <div class="form-group">
                <label for="description">Mô tả:</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            
            <div class="form-group">
                <label for="featured_image">Ảnh đặc trưng:</label>
                <input type="file" name="featured_image" class="form-control-file" id="featuredImageInput" onchange="previewFeaturedImage(event)" accept=".jpg, .jpeg, .png">
                <img class="mt-3" id="featuredImagePreview" src="#" alt="Featured Image Preview" style="max-width: 200px; display: none;">
            </div>
            
            <div class="form-group">
                <label for="video">Video:</label>
                <input type="file" name="video" class="form-control-file" id="videoInput" accept=".mp4, .avi, .mov" onchange="previewVideo(event)">
                <video class="mt-3" id="videoPreview" controls style="max-width: 400px; display: none;">
                    <source id="videoSource" src="" type="video/mp4">
                </video>
            </div>
            
            <div class="form-group">
                <label for="weight">Cân nặng: (Kg)</label>
                <input type="number" name="weight" class="form-control" >
            </div>            

            <div class="form-group d-flex align-items-center ">
                <label for="is_variant" class="mr-2">Phân loại:</label>
                <input type="checkbox" name="is_variant" id="isVariantCheckbox" value="1" onchange="toggleVariantFields()">
            </div>
{{-- variant of product --}}
            <div id="variantFieldsGroup" style="display: none;">
                <div class="variant-control">
                    <div id="add-classify" class="btn btn-primary mb-3">Thêm nhóm phân loại</div>
                </div>
                <div id="variant-list" class="form-group mt-3">
                    <label for="" class="mr-5">Danh sách phân loại:</label>
                    <div class="input-group">
                        <input type="text" aria-label="First name" class="form-control" name="variant-price" placeholder="Giá sản phẩm">
                        <input type="text" aria-label="Last name" class="form-control" name="variant-stock" placeholder="Số lượng kho">
                        <div class="input-group-append" id="button-addon4">
                            <button class="btn btn-primary" type="button">Áp dụng cho tất cả</button>
                        </div>
                    </div>
                </div>
                <table id="variant-table" class="table table-bordered mt-4">
                    <thead>
                        <tr>
                            <th>Phân loại 1</th>
                            <th>Phân loại 2</th>
                            <th>Ảnh</th>
                            <th>Giá (VND)</th>
                            <th>Kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td rowspan="3" class="align-middle text-center">Trắng</td>
                            <td>S</td>
                            <td><input type="file" name="variant-featured-image[]" accept=".jpg,.png,.jpeg"></td>
                            <td><input type="text" class="form-control"></td>
                            <td><input type="text" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td><input type="file" name="variant-featured-image[]" accept=".jpg,.png,.jpeg"></td>
                            <td><input type="text" class="form-control"></td>
                            <td><input type="text" class="form-control"></td>
                        </tr>
                        <tr>
                            <td>L</td>
                            <td><input type="file" name="variant-featured-image[]" accept=".jpg,.png,.jpeg"></td>
                            <td><input type="text" class="form-control"></td>
                            <td><input type="text" class="form-control"></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div id="simpleFieldsGroup" style="display: block;">
                <div class="form-group">
                    <label for="unit_price">Giá: (VND)</label>
                    <input type="text" name="unit_price" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="stock">Số lượng trong kho:</label>
                    <input type="number" name="stock" class="form-control" >
                </div>
            </div>

            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">Tạo sản phẩm</button>
            </div>
        </form>
    </div>
    <script>
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
            } else {
                variantFieldsGroup.style.display = "none";
                simpleFieldsGroup.style.display = "block";
            }
        }

        var addClassify = document.getElementById('add-classify');
        var classify = document.getElementsByClassName('classify');
        let classify1Html = `<div class="input-group classify">
                    <div class="input-group-prepend">
                      <span class="input-group-text">Phân loại 1</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="attributeName1" placeholder="VD: Màu">
                    <input type="text" aria-label="Last name" class="form-control" name="attributeValue1" placeholder="VD: đỏ,vàng,xanh">
                    <div class="input-group-append" id="button-addon4">
                        <button class="btn btn-danger deleteClassify" type="button">Xóa</button>
                    </div>
                </div>`
        let classify2Html = `<div class="input-group mt-3 classify">
                <div class="input-group-prepend">
                      <span class="input-group-text">Phân loại 2</span>
                    </div>
                    <input type="text" aria-label="First name" class="form-control" name="attributeName2" placeholder="VD: Kích thước">
                    <input type="text" aria-label="Last name" class="form-control" name="attributeValue2" placeholder="VD: X,S,M">
                    <div class="input-group-append" id="button-addon4">
                        <button class="btn btn-danger deleteClassify" type="button">Xóa</button>
                    </div>
                </div>`
        addClassify.onclick = function(){
            var variantControl = document.querySelector('.variant-control');
            if(classify.length == 0){
                variantControl.insertAdjacentHTML('beforeend', classify1Html);
            }else if(classify.length == 1){
                variantControl.insertAdjacentHTML('beforeend', classify2Html);
            }
            addDeleteEvent();
            if(classify.length >= 2){
                addClassify.style.display = 'none';
                return;
            }
        }
        addDeleteEvent();
        function addDeleteEvent(){
            var deleteBtns = document.getElementsByClassName('deleteClassify');
            for(let btn of deleteBtns){
                btn.onclick = function(){
                    if(classify.length > 0){
                        var variantControl = document.querySelector('.variant-control');
                        classify[classify.length - 1].remove();
                        addClassify.style.display = 'inline-block';
                        variantControl.removeChild(e.target.closset('.input-group-prepend'));
                    }
                }
            }
        }
        function generateTable(){
            
        }
        </script>
@endsection
