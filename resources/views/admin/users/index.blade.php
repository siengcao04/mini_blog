@extends('layouts.admin')

@section('title', 'Quản lý Người dùng - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý Người dùng</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tạo người dùng mới
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card mb-3">
    <div class="card-body">
        <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="role" class="form-label">Lọc theo vai trò</label>
                <select class="form-select" id="role" name="role">
                    <option value="">Tất cả</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="author" {{ request('role') == 'author' ? 'selected' : '' }}>Author</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-funnel"></i> Lọc
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Xóa bộ lọc
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th>Tên</th>
                    <th>Email</th>
                    <th style="width: 100px">Vai trò</th>
                    <th style="width: 100px">Trạng thái</th>
                    <th style="width: 120px">Ngày tạo</th>
                    <th style="width: 200px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @elseif($user->role == 'author')
                                <span class="badge bg-primary">Author</span>
                            @else
                                <span class="badge bg-secondary">User</span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">Hoạt động</span>
                            @else
                                <span class="badge bg-warning">Bị khóa</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle-active', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $user->is_active ? 'secondary' : 'success' }}" 
                                            title="{{ $user->is_active ? 'Khóa' : 'Mở khóa' }}">
                                        <i class="bi bi-{{ $user->is_active ? 'lock' : 'unlock' }}"></i>
                                    </button>
                                </form>
                                @if(auth()->id() != $user->id)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" 
                                          onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Chưa có người dùng nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $users->links() }}
</div>
@endsection
