@extends('layouts.frontend')

@section('title', 'Danh sách bài viết - Mini Blog')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="mb-4">Bài viết mới nhất</h1>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('posts.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Tìm kiếm bài viết..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>

            @forelse($posts as $post)
                <div class="card mb-3">
                    <div class="row g-0">
                        @if($post->thumbnail)
                            <div class="col-md-4">
                                <img src="{{ Storage::url($post->thumbnail) }}" class="img-fluid rounded-start h-100 object-fit-cover" alt="{{ $post->title }}">
                            </div>
                        @endif
                        <div class="col-md-{{ $post->thumbnail ? '8' : '12' }}">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark">
                                        {{ $post->title }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small">
                                    <i class="bi bi-person"></i> {{ $post->user->name }} |
                                    <i class="bi bi-calendar"></i> {{ $post->published_at->format('d/m/Y') }} |
                                    <i class="bi bi-eye"></i> {{ $post->views }} lượt xem
                                </p>
                                @if($post->excerpt)
                                    <p class="card-text">{{ Str::limit($post->excerpt, 150) }}</p>
                                @endif
                                <div class="d-flex gap-2 flex-wrap">
                                    <span class="badge bg-primary">{{ $post->category->name }}</span>
                                    @foreach($post->tags as $tag)
                                        <span class="badge bg-secondary">{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Chưa có bài viết nào.</div>
            @endforelse

            {{ $posts->links() }}
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Danh mục</h5>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($categories as $category)
                        <a href="{{ route('posts.index', ['category' => $category->slug]) }}" 
                           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            {{ $category->name }}
                            <span class="badge bg-primary rounded-pill">{{ $category->posts_count ?? 0 }}</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Tags</h5>
                </div>
                <div class="card-body">
                    @foreach($tags as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}" class="badge bg-secondary text-decoration-none me-1 mb-1">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
