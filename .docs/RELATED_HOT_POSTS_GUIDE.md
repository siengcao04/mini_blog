# Hướng dẫn Tin liên quan & Tin hot

## Tổng quan

Hệ thống hiển thị các bài viết liên quan (cùng danh mục) và tin hot (nhiều lượt xem) trên trang chi tiết bài viết để tăng tương tác người dùng.

## Tính năng

### 1. Tin liên quan (Related Posts)
- Hiển thị các bài viết cùng danh mục
- Loại trừ bài viết hiện tại
- Sắp xếp theo ngày xuất bản mới nhất
- Giới hạn 5 bài

### 2. Tin hot (Hot Posts)
- Hiển thị bài viết có lượt xem cao nhất
- Sắp xếp theo số lượt xem giảm dần
- Giới hạn 5 bài
- Hiển thị số lượt xem

## Implementation

### Controller

**File**: `app/Http/Controllers/PostController.php`

```php
public function show($slug)
{
    $post = Post::with(['user', 'category', 'tags', 'comments.user'])
        ->where('slug', $slug)
        ->published()
        ->firstOrFail();

    // Tăng lượt xem
    $post->incrementViews();

    // Lấy bài viết liên quan (cùng danh mục, khác bài hiện tại)
    $relatedPosts = Post::where('category_id', $post->category_id)
        ->where('id', '!=', $post->id)
        ->published()
        ->latest('published_at')
        ->limit(5)
        ->get();

    // Lấy bài viết hot (nhiều lượt xem nhất)
    $hotPosts = Post::published()
        ->orderBy('views', 'desc')
        ->limit(5)
        ->get();

    return view('posts.show', compact('post', 'relatedPosts', 'hotPosts'));
}
```

### View - Bài viết liên quan

**File**: `resources/views/posts/show.blade.php`

```blade
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
                                    <img src="{{ Storage::url($related->thumbnail) }}" 
                                        class="img-fluid h-100" 
                                        style="object-fit: cover;" 
                                        alt="{{ $related->title }}">
                                </div>
                            @endif
                            <div class="col-{{ $related->thumbnail ? '8' : '12' }}">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1">
                                        <a href="{{ route('posts.show', $related->slug) }}" 
                                            class="text-decoration-none text-dark">
                                            {{ Str::limit($related->title, 60) }}
                                        </a>
                                    </h6>
                                    <p class="card-text small text-muted mb-0">
                                        <i class="bi bi-calendar"></i> 
                                        {{ $related->published_at->format('d/m/Y') }}
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
```

### View - Tin hot

```blade
<!-- Tin hot -->
@if($hotPosts->count() > 0)
    <section class="hot-posts mb-4">
        <h3 class="mb-3 border-bottom pb-2">
            <i class="bi bi-fire text-danger"></i> Tin hot (Xem nhiều nhất)
        </h3>
        <div class="list-group">
            @foreach($hotPosts as $hot)
                <a href="{{ route('posts.show', $hot->slug) }}" 
                    class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">{{ Str::limit($hot->title, 70) }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-eye"></i> {{ $hot->views }} lượt xem
                            </small>
                        </div>
                        @if($hot->thumbnail)
                            <img src="{{ Storage::url($hot->thumbnail) }}" 
                                alt="{{ $hot->title }}" 
                                style="width: 60px; height: 60px; object-fit: cover;" 
                                class="rounded">
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </section>
@endif
```

## Logic Query

### Tin liên quan

```php
// Cùng danh mục với bài hiện tại
->where('category_id', $post->category_id)

// Loại trừ bài hiện tại
->where('id', '!=', $post->id)

// Chỉ bài đã xuất bản
->published()

// Sắp xếp mới nhất trước
->latest('published_at')

// Giới hạn 5 bài
->limit(5)
```

### Tin hot

```php
// Chỉ bài đã xuất bản
Post::published()

// Sắp xếp theo lượt xem giảm dần
->orderBy('views', 'desc')

// Giới hạn 5 bài
->limit(5)
```

## Tối ưu Performance

### 1. Eager Loading

```php
$relatedPosts = Post::with(['user', 'category'])
    ->where('category_id', $post->category_id)
    ->where('id', '!=', $post->id)
    ->published()
    ->latest('published_at')
    ->limit(5)
    ->get();
```

### 2. Cache (Tùy chọn)

```php
use Illuminate\Support\Facades\Cache;

$hotPosts = Cache::remember('hot_posts', 3600, function () {
    return Post::published()
        ->orderBy('views', 'desc')
        ->limit(5)
        ->get();
});
```

Clear cache khi có bài viết mới:

```php
// Trong PostController@store hoặc update
Cache::forget('hot_posts');
```

### 3. Index Database

Thêm index cho cột `views` để tăng tốc query:

```php
Schema::table('posts', function (Blueprint $table) {
    $table->index('views');
    $table->index(['category_id', 'status', 'published_at']);
});
```

## Tùy chỉnh

### Thay đổi số lượng hiển thị

```php
// Hiển thị 10 bài liên quan
->limit(10)

// Hiển thị 3 tin hot
->limit(3)
```

### Thêm điều kiện lọc

```php
// Tin liên quan cùng tag
$relatedPosts = Post::whereHas('tags', function($query) use ($post) {
        $tagIds = $post->tags->pluck('id');
        $query->whereIn('tags.id', $tagIds);
    })
    ->where('id', '!=', $post->id)
    ->published()
    ->latest('published_at')
    ->limit(5)
    ->get();
```

### Kết hợp nhiều tiêu chí

```php
// Tin hot trong 30 ngày gần đây
$hotPosts = Post::published()
    ->where('published_at', '>=', now()->subDays(30))
    ->orderBy('views', 'desc')
    ->limit(5)
    ->get();
```

### Sắp xếp ngẫu nhiên

```php
// Random bài liên quan
$relatedPosts = Post::where('category_id', $post->category_id)
    ->where('id', '!=', $post->id)
    ->published()
    ->inRandomOrder()
    ->limit(5)
    ->get();
```

## Hiển thị nâng cao

### 1. Slider cho tin liên quan

Sử dụng Swiper.js hoặc Bootstrap Carousel:

```html
<div id="relatedCarousel" class="carousel slide">
    <div class="carousel-inner">
        @foreach($relatedPosts as $index => $related)
            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                <img src="{{ Storage::url($related->thumbnail) }}" class="d-block w-100">
                <div class="carousel-caption">
                    <h5>{{ $related->title }}</h5>
                </div>
            </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#relatedCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#relatedCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>
```

### 2. Grid layout responsive

```blade
<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
    @foreach($relatedPosts as $related)
        <div class="col">
            <div class="card h-100">
                <!-- Card content -->
            </div>
        </div>
    @endforeach
</div>
```

### 3. Badge cho tin hot

```blade
@foreach($hotPosts as $index => $hot)
    <a href="{{ route('posts.show', $hot->slug) }}" class="list-group-item">
        @if($index === 0)
            <span class="badge bg-danger">🔥 #1</span>
        @elseif($index === 1)
            <span class="badge bg-warning">⭐ #2</span>
        @elseif($index === 2)
            <span class="badge bg-info">💎 #3</span>
        @endif
        <h6>{{ $hot->title }}</h6>
        <small>{{ $hot->views }} lượt xem</small>
    </a>
@endforeach
```

## Testing

### Test tin liên quan

```php
// Tạo bài viết cùng danh mục
$category = Category::factory()->create();
$post1 = Post::factory()->create(['category_id' => $category->id]);
$post2 = Post::factory()->create(['category_id' => $category->id]);

// Kiểm tra
$relatedPosts = Post::where('category_id', $post1->category_id)
    ->where('id', '!=', $post1->id)
    ->get();

$this->assertTrue($relatedPosts->contains($post2));
$this->assertFalse($relatedPosts->contains($post1));
```

### Test tin hot

```php
$post1 = Post::factory()->create(['views' => 100]);
$post2 = Post::factory()->create(['views' => 200]);
$post3 = Post::factory()->create(['views' => 50]);

$hotPosts = Post::orderBy('views', 'desc')->limit(5)->get();

$this->assertEquals($post2->id, $hotPosts->first()->id);
```

## Best Practices

### 1. Hiển thị điều kiện
- Chỉ hiển thị khi có dữ liệu (`@if($relatedPosts->count() > 0)`)
- Hiển thị placeholder khi không có kết quả

### 2. Performance
- Cache tin hot (ít thay đổi)
- Eager load relationships
- Limit số lượng phù hợp

### 3. UI/UX
- Icon rõ ràng (newspaper, fire)
- Thumbnail size nhất quán
- Responsive trên mobile

### 4. SEO
- Internal linking tốt cho SEO
- Giữ người dùng ở lại site lâu hơn
- Tăng page views

## Mở rộng tính năng

### 1. Tin liên quan theo tag

```php
$relatedByTags = Post::whereHas('tags', function($q) use ($post) {
        $q->whereIn('tags.id', $post->tags->pluck('id'));
    })
    ->where('id', '!=', $post->id)
    ->published()
    ->limit(3)
    ->get();
```

### 2. Tin cùng tác giả

```php
$sameAuthor = Post::where('user_id', $post->user_id)
    ->where('id', '!=', $post->id)
    ->published()
    ->latest()
    ->limit(5)
    ->get();
```

### 3. Trending (hot + mới)

```php
// Kết hợp views và ngày xuất bản
$trending = Post::published()
    ->where('published_at', '>=', now()->subDays(7))
    ->orderByRaw('views * 0.7 + DATEDIFF(NOW(), published_at) * 0.3 DESC')
    ->limit(5)
    ->get();
```

### 4. Đọc tiếp (Continue reading)

Lưu history đọc bài vào session:

```php
// Trong PostController@show
$readHistory = session('read_history', []);
$readHistory[] = $post->id;
session(['read_history' => array_slice($readHistory, -10)]);

// Hiển thị bài đã đọc
$continueReading = Post::whereIn('id', session('read_history', []))
    ->latest()
    ->limit(5)
    ->get();
```

## Troubleshooting

### Không hiển thị tin liên quan
- Kiểm tra có bài cùng category không
- Verify published status
- Check limit và count()

### Tin hot không chính xác
- Kiểm tra cột `views` có giá trị đúng không
- Verify scope `published()`
- Clear cache nếu có

### Performance chậm
- Thêm index cho `category_id`, `views`
- Sử dụng cache
- Eager load relationships

## Tài liệu tham khảo

- [Laravel Query Builder](https://laravel.com/docs/12.x/queries)
- [Eloquent Relationships](https://laravel.com/docs/12.x/eloquent-relationships)
- [Laravel Caching](https://laravel.com/docs/12.x/cache)
- [Bootstrap Cards](https://getbootstrap.com/docs/5.3/components/card/)
