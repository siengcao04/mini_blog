@extends('layouts.admin')

@section('title', 'Tạo Tag Mới - Admin')

@section('content')
<div class="mb-4">
    <h2>Tạo Tag Mới</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.tags.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên tag <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Slug sẽ được tạo tự động từ tên tag</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Lưu tag
                </button>
                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
