@extends('layouts.admin')

@section('title', 'Sửa Người dùng - Admin')

@section('content')
<div class="mb-4">
    <h2>Sửa Người dùng</h2>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="name" class="form-label">Tên <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Để trống nếu không muốn thay đổi. Tối thiểu 8 ký tự</small>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" class="form-control" 
                       id="password_confirmation" name="password_confirmation">
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Vai trò <span class="text-danger">*</span></label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                    <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                    <option value="author" {{ old('role', $user->role) == 'author' ? 'selected' : '' }}>Author</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active" name="is_active" required>
                    <option value="1" {{ old('is_active', $user->is_active) == '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('is_active', $user->is_active) == '0' ? 'selected' : '' }}>Bị khóa</option>
                </select>
                @error('is_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Thông tin</label>
                <ul class="list-unstyled">
                    <li><strong>Ngày đăng ký:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</li>
                    <li><strong>Số bài viết:</strong> {{ $user->posts()->count() }}</li>
                    <li><strong>Số bình luận:</strong> {{ $user->comments()->count() }}</li>
                </ul>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Cập nhật
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
