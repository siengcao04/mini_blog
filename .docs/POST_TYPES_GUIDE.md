# Hướng dẫn Loại Tin tức & Tin Nổi bật

## Tổng quan

Hệ thống hỗ trợ 3 loại tin tức khác nhau và tính năng đánh dấu tin nổi bật.

## Các loại tin tức

### 1. Tin thường (Text)
- Bài viết dạng văn bản thông thường
- Sử dụng TinyMCE editor
- Hỗ trợ định dạng phong phú

### 2. Tin hình ảnh (Image)
- Bài viết tập trung vào hình ảnh
- Upload thumbnail chính
- Có thể chèn nhiều ảnh trong nội dung

### 3. Tin video (Video)
- Bài viết có video đính kèm
- Hỗ trợ 2 định dạng:
  - **YouTube URL**: Tự động nhúng video
  - **Video trực tiếp**: Link file .mp4, .webm, .ogg

## Cấu trúc Database

### Migration: `add_post_type_and_featured_to_posts_table.php`

```php
Schema::table('posts', function (Blueprint $table) {
    $table->enum('post_type', ['text', 'image', 'video'])
        ->default('text')
        ->after('slug');
    $table->string('video_url')->nullable()->after('thumbnail');
    $table->boolean('is_featured')->default(false)->after('video_url');
});
```

### Cột mới trong bảng `posts`

| Cột | Kiểu | Mô tả |
|-----|------|-------|
| `post_type` | ENUM | Loại bài viết: text, image, video |
| `video_url` | VARCHAR | URL video (bắt buộc nếu post_type = video) |
| `is_featured` | BOOLEAN | Đánh dấu tin nổi bật |

## Model Post

### Fillable fields

```php
protected $fillable = [
    'user_id', 'category_id', 'title', 'slug',
    'post_type', 'excerpt', 'content', 'thumbnail',
    'video_url', 'status', 'is_featured',
    'published_at', 'views'
];
```

### Casts

```php
protected $casts = [
    'published_at' => 'datetime',
    'is_featured' => 'boolean',
];
```

### Scope

```php
public function scopeFeatured($query)
{
    return $query->where('is_featured', true);
}
```

## Validation

### Admin\PostController

```php
$validated = $request->validate([
    'title' => 'required|string|max:255',
    'category_id' => 'required|exists:categories,id',
    'post_type' => 'nullable|in:text,image,video',
    'excerpt' => 'nullable|string|max:500',
    'content' => 'required|string',
    'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    'video_url' => 'nullable|url',
    'status' => 'required|in:draft,pending,published',
    'is_featured' => 'nullable|boolean',
    'tags' => 'nullable|array',
    'tags.*' => 'exists:tags,id',
], [
    'title.required' => 'Tiêu đề không được để trống.',
    'category_id.required' => 'Vui lòng chọn danh mục.',
    'post_type.in' => 'Loại tin tức không hợp lệ.',
    'content.required' => 'Nội dung không được để trống.',
    'video_url.url' => 'URL video không hợp lệ.',
    'status.required' => 'Vui lòng chọn trạng thái.',
]);
```

## Form Admin

### Dropdown chọn loại tin

```html
<div class="mb-3">
    <label for="post_type" class="form-label">Loại tin tức</label>
    <select name="post_type" id="post_type" class="form-select">
        <option value="text" selected>Tin thường</option>
        <option value="image">Tin hình ảnh</option>
        <option value="video">Tin video</option>
    </select>
</div>
```

### Checkbox tin nổi bật

```html
<div class="form-check">
    <input type="checkbox" name="is_featured" id="is_featured" 
        class="form-check-input" value="1">
    <label for="is_featured" class="form-check-label">
        <i class="bi bi-star-fill text-warning"></i> 
        Đánh dấu tin nổi bật
    </label>
</div>
```

### Input URL video (hiển thị động)

```html
<div class="card" id="video-url-card" style="display: none;">
    <div class="card-header">
        <i class="bi bi-play-circle"></i> URL Video
    </div>
    <div class="card-body">
        <input type="url" name="video_url" id="video_url" 
            class="form-control" placeholder="https://youtube.com/watch?v=...">
        <small class="text-muted">
            Nhập URL YouTube hoặc link video trực tiếp (.mp4, .webm)
        </small>
    </div>
</div>
```

### JavaScript hiển thị động

```javascript
document.getElementById('post_type').addEventListener('change', function() {
    const videoCard = document.getElementById('video-url-card');
    if (this.value === 'video') {
        videoCard.style.display = 'block';
    } else {
        videoCard.style.display = 'none';
    }
});
```

## Hiển thị Frontend

### 1. Tin nổi bật trên trang chủ

**Controller**: `PostController@index`

```php
$featuredPosts = Post::featured()
    ->published()
    ->latest('published_at')
    ->limit(3)
    ->get();

return view('posts.index', compact('posts', 'categories', 'tags', 'featuredPosts'));
```

**View**: `resources/views/posts/index.blade.php`

```blade
@if($featuredPosts->count() > 0)
    <div class="mb-5">
        <h2 class="mb-3 border-bottom pb-2">
            <i class="bi bi-star-fill text-warning"></i> Tin nổi bật
        </h2>
        <div class="row">
            @foreach($featuredPosts as $featured)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        @if($featured->thumbnail)
                            <img src="{{ Storage::url($featured->thumbnail) }}" 
                                class="card-img-top" alt="{{ $featured->title }}">
                        @endif
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('posts.show', $featured->slug) }}">
                                    {{ Str::limit($featured->title, 50) }}
                                </a>
                            </h6>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
```

### 2. Hiển thị video trong bài viết

**View**: `resources/views/posts/show.blade.php`

```blade
@if($post->post_type === 'video' && $post->video_url)
    <div class="ratio ratio-16x9 mb-4">
        @if(str_contains($post->video_url, 'youtube.com') || str_contains($post->video_url, 'youtu.be'))
            @php
                preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $post->video_url, $matches);
                $videoId = $matches[1] ?? '';
            @endphp
            @if($videoId)
                <iframe src="https://www.youtube.com/embed/{{ $videoId }}" 
                    allowfullscreen></iframe>
            @endif
        @else
            <video controls class="w-100">
                <source src="{{ $post->video_url }}" type="video/mp4">
                Trình duyệt của bạn không hỗ trợ video.
            </video>
        @endif
    </div>
@endif
```

## Query Examples

### Lấy tất cả tin nổi bật

```php
$featured = Post::featured()->published()->get();
```

### Lấy tin video

```php
$videoPosts = Post::where('post_type', 'video')
    ->published()
    ->get();
```

### Lấy tin nổi bật theo loại

```php
$featuredVideos = Post::featured()
    ->where('post_type', 'video')
    ->published()
    ->limit(5)
    ->get();
```

### Đếm số tin theo loại

```php
$stats = [
    'text' => Post::where('post_type', 'text')->count(),
    'image' => Post::where('post_type', 'image')->count(),
    'video' => Post::where('post_type', 'video')->count(),
];
```

## Best Practices

### 1. Video URL
- Luôn validate URL format
- Hỗ trợ cả YouTube và video trực tiếp
- Hiển thị placeholder khi không có video

### 2. Tin nổi bật
- Giới hạn số lượng (3-5 bài)
- Hiển thị bài mới nhất trước
- Có badge/icon phân biệt

### 3. Performance
- Eager load relationships: `with(['user', 'category'])`
- Cache featured posts nếu cần
- Pagination cho danh sách

### 4. UI/UX
- Icon rõ ràng cho mỗi loại tin
- Video responsive (ratio 16:9)
- Featured posts nổi bật trên trang chủ

## Mở rộng

### Thêm loại tin mới

1. Cập nhật enum trong migration:
```php
$table->enum('post_type', ['text', 'image', 'video', 'audio', 'gallery'])
```

2. Cập nhật validation:
```php
'post_type' => 'nullable|in:text,image,video,audio,gallery',
```

3. Cập nhật form dropdown

4. Thêm logic hiển thị tương ứng

## Troubleshooting

### Video không hiển thị
- Kiểm tra URL hợp lệ
- Kiểm tra regex parse YouTube ID
- Xem console browser có lỗi CORS không

### Featured không hoạt động
- Kiểm tra migration đã chạy chưa
- Kiểm tra scope `featured()` trong Model
- Verify giá trị trong database (0 hoặc 1)

## Tài liệu liên quan

- [Laravel Enums](https://laravel.com/docs/12.x/eloquent-mutators#enum-casting)
- [Bootstrap Ratio](https://getbootstrap.com/docs/5.3/helpers/ratio/)
- [YouTube Embed API](https://developers.google.com/youtube/iframe_api_reference)
