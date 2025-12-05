@extends('layouts.admin')

@section('title', 'Sửa Tag - Admin')

@section('content')
<div class="mb-4">
    <h2>Sửa Tag</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên tag <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $tag->name) }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Slug hiện tại</label>
                <input type="text" class="form-control" value="{{ $tag->slug }}" disabled>
                <small class="form-text text-muted">Slug sẽ được cập nhật tự động khi thay đổi tên</small>
            </div>

            <div class="mb-3">
                <label class="form-label">Số bài viết</label>
                <input type="text" class="form-control" value="{{ $tag->posts()->count() }}" disabled>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
