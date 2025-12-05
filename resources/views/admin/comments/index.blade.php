@extends('layouts.admin')

@section('title', 'Quản lý Bình luận - Admin')

@section('content')
<div class="mb-4">
    <h2>Quản lý Bình luận</h2>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.comments.index') }}" method="GET" class="row g-3 mb-3">
            <div class="col-md-4">
                <label for="post_id" class="form-label">Lọc theo bài viết</label>
                <input type="number" class="form-control" id="post_id" name="post_id" 
                       value="{{ request('post_id') }}" placeholder="ID bài viết">
            </div>
            <div class="col-md-4">
                <label for="user_id" class="form-label">Lọc theo người dùng</label>
                <input type="number" class="form-control" id="user_id" name="user_id" 
                       value="{{ request('user_id') }}" placeholder="ID người dùng">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-funnel"></i> Lọc
                </button>
                <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Xóa bộ lọc
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card mt-3">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th>Người dùng</th>
                    <th>Bài viết</th>
                    <th>Nội dung</th>
                    <th style="width: 100px">Trạng thái</th>
                    <th style="width: 120px">Ngày tạo</th>
                    <th style="width: 180px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                    <tr>
                        <td>{{ $comment->id }}</td>
                        <td>
                            <strong>{{ $comment->user->name }}</strong><br>
                            <small class="text-muted">{{ $comment->user->email }}</small>
                        </td>
                        <td>
                            <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank">
                                {{ Str::limit($comment->post->title, 40) }}
                            </a>
                        </td>
                        <td>{{ Str::limit($comment->content, 60) }}</td>
                        <td>
                            @if($comment->is_visible)
                                <span class="badge bg-success">Hiện</span>
                            @else
                                <span class="badge bg-secondary">Ẩn</span>
                            @endif
                        </td>
                        <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <form action="{{ route('admin.comments.toggle-visibility', $comment) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $comment->is_visible ? 'warning' : 'success' }}" 
                                            title="{{ $comment->is_visible ? 'Ẩn' : 'Hiện' }}">
                                        <i class="bi bi-eye{{ $comment->is_visible ? '-slash' : '' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline" 
                                      onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Chưa có bình luận nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $comments->links() }}
</div>
@endsection
