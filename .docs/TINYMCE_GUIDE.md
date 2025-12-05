# Hướng dẫn sử dụng TinyMCE Editor

## Giới thiệu

TinyMCE là trình soạn thảo văn bản WYSIWYG (What You See Is What You Get) được tích hợp vào hệ thống Blog để giúp người dùng tạo nội dung bài viết với định dạng phong phú.

## Cài đặt

TinyMCE được tích hợp qua CDN, không cần cài đặt package:

```html
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>
```

## Cấu hình

### File: `resources/views/admin/posts/create.blade.php` và `edit.blade.php`

```javascript
tinymce.init({
    selector: '#content',
    language: 'vi',
    height: 500,
    menubar: true,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
        'preview', 'anchor', 'searchreplace', 'visualblocks', 'code',
        'fullscreen', 'insertdatetime', 'media', 'table', 'help', 'wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic underline strikethrough | ' +
        'alignleft aligncenter alignright alignjustify | ' +
        'bullist numlist outdent indent | removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
});
```

## Tính năng

### 1. Định dạng văn bản
- **In đậm** (Bold): Ctrl+B
- *In nghiêng* (Italic): Ctrl+I
- <u>Gạch chân</u> (Underline): Ctrl+U
- ~~Gạch ngang~~ (Strikethrough)

### 2. Tiêu đề
- Heading 1, 2, 3, 4, 5, 6
- Paragraph
- Preformatted

### 3. Danh sách
- Danh sách có dấu chấm (Bullet list)
- Danh sách có số thứ tự (Numbered list)
- Tăng/giảm indent

### 4. Căn lề
- Căn trái
- Căn giữa
- Căn phải
- Căn đều

### 5. Chèn nội dung
- Link (Ctrl+K)
- Hình ảnh
- Bảng (Table)
- Media (Video/Audio)

### 6. Công cụ khác
- Tìm và thay thế
- Preview
- Fullscreen mode
- Source code view
- Undo/Redo

## Lưu ý khi sử dụng

### 1. Xử lý nội dung HTML

Khi hiển thị nội dung từ TinyMCE, sử dụng `{!! !!}` thay vì `{{ }}`:

```blade
<!-- ✅ Đúng - Hiển thị HTML -->
<div class="content">
    {!! $post->content !!}
</div>

<!-- ❌ Sai - Escape HTML -->
<div class="content">
    {{ $post->content }}
</div>
```

### 2. Validation

Không cần escape HTML trong validation vì TinyMCE đã sanitize:

```php
$validated = $request->validate([
    'content' => 'required|string',
]);
```

### 3. Dung lượng

Nội dung HTML có thể chiếm nhiều dung lượng hơn text thuần. Đảm bảo cột `content` trong database là `TEXT` hoặc `LONGTEXT`.

## Tùy chỉnh nâng cao

### Thêm plugin

Thêm plugin vào mảng `plugins`:

```javascript
plugins: [
    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap',
    'preview', 'anchor', 'searchreplace', 'visualblocks', 'code',
    'fullscreen', 'insertdatetime', 'media', 'table', 'help', 'wordcount',
    'emoticons', 'codesample' // Thêm emoji và code highlighting
],
```

### Thay đổi toolbar

Tùy chỉnh các button hiển thị:

```javascript
toolbar: 'undo redo | blocks fontsize | ' +
    'bold italic forecolor backcolor | ' +
    'alignleft aligncenter alignright alignjustify | ' +
    'bullist numlist outdent indent | ' +
    'link image media table | ' +
    'removeformat code fullscreen help',
```

### Upload hình ảnh

Để upload hình ảnh lên server:

```javascript
images_upload_url: '/admin/posts/upload-image',
automatic_uploads: true,
images_upload_handler: function (blobInfo, success, failure) {
    var xhr, formData;
    xhr = new XMLHttpRequest();
    xhr.withCredentials = false;
    xhr.open('POST', '/admin/posts/upload-image');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    
    xhr.onload = function() {
        if (xhr.status != 200) {
            failure('HTTP Error: ' + xhr.status);
            return;
        }
        var json = JSON.parse(xhr.responseText);
        success(json.location);
    };
    
    formData = new FormData();
    formData.append('file', blobInfo.blob(), blobInfo.filename());
    xhr.send(formData);
}
```

## Xử lý sự cố

### 1. TinyMCE không load

- Kiểm tra kết nối internet (CDN)
- Kiểm tra console browser có lỗi không
- Đảm bảo selector `#content` khớp với textarea

### 2. Nội dung không lưu

- Kiểm tra form có submit đúng không
- Kiểm tra validation server-side
- Thêm `required` attribute vào textarea

### 3. Ngôn ngữ không đổi

TinyMCE CDN miễn phí không hỗ trợ ngôn ngữ. Để có tiếng Việt, cần:
- Download language pack từ tinymce.com
- Lưu vào `public/js/tinymce/langs/vi.js`
- Cấu hình: `language: 'vi', language_url: '/js/tinymce/langs/vi.js'`

## Tài liệu tham khảo

- [TinyMCE Documentation](https://www.tiny.cloud/docs/)
- [TinyMCE Plugins](https://www.tiny.cloud/docs/plugins/)
- [TinyMCE API Reference](https://www.tiny.cloud/docs/api/)
