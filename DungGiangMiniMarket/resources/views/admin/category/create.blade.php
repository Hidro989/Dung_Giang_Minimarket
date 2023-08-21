@extends('layouts.app-admin')

@section('title', 'Tạo loại hàng')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý loại hàng</h1>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thêm loại hàng</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.category.store') }}" class="needs-validation" method="POST" novalidate>
                @csrf
                <div class="form-group form-row">
                    <div class="col-md-6 mb-6">
                        <label for="nameCategory">Tên loại hàng</label>
                        <input type="text" name="name" id="nameCategory" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                        
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Thêm</button>
            </form>
        </div>
    </div>

@endsection