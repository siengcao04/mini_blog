@extends('layouts.admin')

@section('title', 'Chỉnh sửa bài viết - Admin')

@section('content')
<div class="mb-4">
    <h2>Chỉnh sửa bài viết</h2>
</div>

<form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Trích dẫn</label>
                        <textarea name="excerpt" id="excerpt" rows="2" class="form-control @error('excerpt') is-invalid @enderror">{{ old('excerpt', $post->excerpt) }}</textarea>
                        @error('excerpt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="15" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Xuất bản</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Nháp</option>
                            <option value="pending" {{ old('status', $post->status) === 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                            <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Xuất bản</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Cập nhật bài viết
                    </button>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Danh mục</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Chọn danh mục <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Tags</h5>
                </div>
                <div class="card-body">
                    <div class="mb-0">
                        @foreach($tags as $tag)
                            <div class="form-check">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="tag{{ $tag->id }}" class="form-check-input" 
                                    {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label for="tag{{ $tag->id }}" class="form-check-label">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-0">Hình ảnh</h5>
                </div>
                <div class="card-body">
                    @if($post->thumbnail)
                        <div class="mb-2">
                            <img src="{{ Storage::url($post->thumbnail) }}" class="img-fluid rounded" alt="Current thumbnail">
                        </div>
                    @endif
                    <div class="mb-0">
                        <label for="thumbnail" class="form-label">Ảnh đại diện mới</label>
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/*">
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Định dạng: JPG, PNG, GIF. Tối đa 2MB</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
