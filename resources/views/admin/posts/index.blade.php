@extends('layouts.admin')

@section('title', 'Quản lý bài viết - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Quản lý bài viết</h2>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tạo bài viết mới
    </a>
</div>

<div class="card">
    <div class="card-header">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="row g-3">
            <div class="col-auto">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">Tất cả trạng thái</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Nháp</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                </select>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width: 50px">ID</th>
                    <th>Tiêu đề</th>
                    <th>Tác giả</th>
                    <th>Danh mục</th>
                    <th>Trạng thái</th>
                    <th style="width: 100px">Lượt xem</th>
                    <th style="width: 150px">Ngày tạo</th>
                    <th style="width: 180px">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>
                            <a href="{{ route('posts.show', $post->slug) }}" target="_blank">
                                {{ Str::limit($post->title, 60) }}
                            </a>
                        </td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{ $post->category->name }}</td>
                        <td>
                            @if($post->status === 'published')
                                <span class="badge bg-success">Đã xuất bản</span>
                            @elseif($post->status === 'pending')
                                <span class="badge bg-warning">Chờ duyệt</span>
                            @else
                                <span class="badge bg-secondary">Nháp</span>
                            @endif
                        </td>
                        <td>{{ $post->views }}</td>
                        <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($post->status === 'pending')
                                    <form action="{{ route('admin.posts.approve', $post) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success" title="Duyệt bài">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                    </form>
                                @endif
                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-warning" title="Sửa">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Xóa">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Chưa có bài viết nào</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
        <div class="card-footer">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
