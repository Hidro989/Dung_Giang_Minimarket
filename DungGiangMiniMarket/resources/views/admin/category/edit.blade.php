@extends('layouts.app-admin')

@section('title', 'Sửa loại hàng')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý loại hàng</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sửa loại hàng</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.update', $category->id ) }}" class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $category->id }}">
                <div class="form-group form-row">
                    <div class="col-md-6 mb-6">
                        <label for="nameCategory">Tên loại hàng</label>
                        <input type="text" name="name" id="nameCategory" class="form-control @error('name') is-invalid @enderror" value="{{ old('name',$category->name) }}">
                        
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="form-group form-row">
                    <div class="col-md-6 mb-6">
                        <label for="nameCategory">Ảnh loại hàng</label>
                        <input type="file" name="image" id="imageCategory" class="form-control @error('image') is-invalid @enderror">
                        
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Sửa</button>
            </form>
        </div>
    </div>

@endsection