@extends('admins.layouts.master')
@section('style')
@endsection
@section('content')
    @if(!empty($category))
        <form class="mt-4" action="{{ route('admin.categories.update', ['id' => $category->id]) }}" method="POST">
            @method('PUT')
            @else
                <form class="mt-4" action="{{ route('admin.categories.store') }}" method="POST">
                    @endif
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tên danh mục<span class="color-red">*</span></label>
                        <input type="text" maxlength="100" class="form-control" name="name"
                               value="{{ old('name') ?? !empty($category->name) ? $category->name : '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Xác nhận</button>
                </form>
        @endsection
