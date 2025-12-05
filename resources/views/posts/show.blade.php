@extends('layouts.frontend')

@section('title', $post->title . ' - Mini Blog')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Bài viết</a></li>
                    <li class="breadcrumb-item active">{{ $post->title }}</li>
                </ol>
            </nav>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <article class="mb-4">
                <h1 class="mb-3">{{ $post->title }}</h1>

                <div class="text-muted mb-3">
                    <i class="bi bi-person"></i> {{ $post->user->name }} |
                    <i class="bi bi-calendar"></i> {{ $post->published_at->format('d/m/Y H:i') }} |
                    <i class="bi bi-eye"></i> {{ $post->views }} lượt xem |
                    <i class="bi bi-folder"></i> {{ $post->category->name }}
                </div>

                <div class="mb-3">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}" class="badge bg-secondary text-decoration-none me-1">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>

                @if($post->thumbnail)
                    <img src="{{ Storage::url($post->thumbnail) }}" class="img-fluid rounded mb-4" alt="{{ $post->title }}">
                @endif

                @if($post->post_type === 'video' && $post->video_url)
                    <div class="ratio ratio-16x9 mb-4">
                        @if(str_contains($post->video_url, 'youtube.com') || str_contains($post->video_url, 'youtu.be'))
                            @php
                                preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $post->video_url, $matches);
                                $videoId = $matches[1] ?? '';
                            @endphp
                            @if($videoId)
                                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" allowfullscreen></iframe>
                            @endif
                        @else
                            <video controls class="w-100">
                                <source src="{{ $post->video_url }}" type="video/mp4">
                                Trình duyệt của bạn không hỗ trợ video.
                            </video>
                        @endif
                    </div>
                @endif

                <div class="content">
                    {!! $post->content !!}
                </div>
            </article>

            <hr>

            <section class="comments mb-4">
                <h3 class="mb-3">Bình luận ({{ $post->comments->where('is_visible', true)->count() }})</h3>

                @auth
                    <form action="{{ route('comments.store') }}" method="POST" class="mb-4">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <div class="mb-3">
                            <label for="content" class="form-label">Viết bình luận</label>
                            <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" rows="3" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
                    </form>
                @else
                    <div class="alert alert-info">
                        Vui lòng <a href="{{ route('login') }}">đăng nhập</a> để bình luận.
                    </div>
                @endauth

                <div class="comments-list">
                    @forelse($post->comments->where('is_visible', true) as $comment)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>{{ $comment->user->name }}</strong>
                                        <span class="text-muted small">- {{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    @auth
                                        @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editCommentModal{{ $comment->id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                                <p class="mb-0">{{ $comment->content }}</p>
                            </div>
                        </div>

                        @auth
                            @if(auth()->id() === $comment->user_id || auth()->user()->isAdmin())
                                <div class="modal fade" id="editCommentModal{{ $comment->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('comments.update', $comment) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Sửa bình luận</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <textarea name="content" class="form-control" rows="3" required>{{ $comment->content }}</textarea>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth
                    @empty
                        <p class="text-muted">Chưa có bình luận nào.</p>
                    @endforelse
                </div>
            </section>

            <!-- Bài viết liên quan -->
            @if($relatedPosts->count() > 0)
                <section class="related-posts mb-4">
                    <h3 class="mb-3 border-bottom pb-2">
                        <i class="bi bi-newspaper"></i> Bài viết liên quan
                    </h3>
                    <div class="row">
                        @foreach($relatedPosts as $related)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100">
                                    <div class="row g-0">
                                        @if($related->thumbnail)
                                            <div class="col-4">
                                                <img src="{{ Storage::url($related->thumbnail) }}" class="img-fluid h-100" style="object-fit: cover;" alt="{{ $related->title }}">
                                            </div>
                                        @endif
                                        <div class="col-{{ $related->thumbnail ? '8' : '12' }}">
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1">
                                                    <a href="{{ route('posts.show', $related->slug) }}" class="text-decoration-none text-dark">
                                                        {{ Str::limit($related->title, 60) }}
                                                    </a>
                                                </h6>
                                                <p class="card-text small text-muted mb-0">
                                                    <i class="bi bi-calendar"></i> {{ $related->published_at->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Tin hot -->
            @if($hotPosts->count() > 0)
                <section class="hot-posts mb-4">
                    <h3 class="mb-3 border-bottom pb-2">
                        <i class="bi bi-fire text-danger"></i> Tin hot (Xem nhiều nhất)
                    </h3>
                    <div class="list-group">
                        @foreach($hotPosts as $hot)
                            <a href="{{ route('posts.show', $hot->slug) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($hot->title, 70) }}</h6>
                                        <small class="text-muted">
                                            <i class="bi bi-eye"></i> {{ $hot->views }} lượt xem
                                        </small>
                                    </div>
                                    @if($hot->thumbnail)
                                        <img src="{{ Storage::url($hot->thumbnail) }}" alt="{{ $hot->title }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </div>
</div>
@endsection
