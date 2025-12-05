@extends('layouts.admin')

@section('title', 'Dashboard - Admin')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2>Dashboard</h2>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase mb-0">Tổng bài viết</h6>
                        <h2 class="mb-0">{{ $stats['total_posts'] }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-file-text" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase mb-0">Đã xuất bản</h6>
                        <h2 class="mb-0">{{ $stats['published_posts'] }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase mb-0">Chờ duyệt</h6>
                        <h2 class="mb-0">{{ $stats['pending_posts'] }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-uppercase mb-0">Người dùng</h6>
                        <h2 class="mb-0">{{ $stats['total_users'] }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Bài viết mới nhất</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Tiêu đề</th>
                            <th>Tác giả</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recent_posts as $post)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.posts.edit', $post) }}">
                                        {{ Str::limit($post->title, 50) }}
                                    </a>
                                </td>
                                <td>{{ $post->user->name }}</td>
                                <td>
                                    @if($post->status === 'published')
                                        <span class="badge bg-success">Đã xuất bản</span>
                                    @elseif($post->status === 'pending')
                                        <span class="badge bg-warning">Chờ duyệt</span>
                                    @else
                                        <span class="badge bg-secondary">Nháp</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Chưa có bài viết</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Bình luận mới</h5>
            </div>
            <div class="list-group list-group-flush">
                @forelse($recent_comments as $comment)
                    <div class="list-group-item">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $comment->user->name }}</h6>
                            <small>{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1 small">{{ Str::limit($comment->content, 60) }}</p>
                        <small class="text-muted">
                            <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank">
                                {{ Str::limit($comment->post->title, 40) }}
                            </a>
                        </small>
                    </div>
                @empty
                    <div class="list-group-item text-center text-muted">
                        Chưa có bình luận
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
