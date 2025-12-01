Dưới đây là **danh sách đầy đủ và rõ ràng nhất** cho đề tài
✅ **"Hệ thống Blog nhỏ (có phân quyền Admin / User)"**
Được chia theo **2 nhóm: Chức năng cho User – Chức năng cho Admin**, kèm các **phân hệ mở rộng** nếu muốn nâng cấp đồ án.

---

# ⭐ **1. CHỨC NĂNG NGƯỜI DÙNG (USER – khách hoặc thành viên)**

## **1.1. Chức năng khách (không cần đăng nhập)**

* Xem danh sách bài viết
* Xem bài viết chi tiết
* Xem bài viết theo danh mục
* Tìm kiếm bài viết theo từ khóa
* Lọc bài theo tag
* Xem số lượt xem bài viết
* Đăng ký tài khoản (nếu cho phép)

---

## **1.2. Chức năng User đã đăng nhập**

* Bình luận bài viết
  (Thêm bình luận, sửa bình luận của chính mình, xóa bình luận)
* Like / Unlike bài viết (tùy chọn)
* Theo dõi tác giả (tùy chọn)
* Chỉnh sửa thông tin cá nhân (avatar, tên, email…)
* Thay đổi mật khẩu
* Đăng xuất

---

# ⭐ **2. CHỨC NĂNG TÁC GIẢ (USER ĐƯỢC ADMIN CẤP QUYỀN POST BÀI)**

(Nếu bạn chia thành 3 nhóm: User – Author – Admin)

* Tạo bài viết mới (đưa vào trạng thái Chờ duyệt)
* Sửa bài viết của chính mình
* Xóa bài viết của chính mình
* Upload ảnh (thumbnail)
* Thêm tags cho bài viết
* Gắn bài viết vào danh mục

---

# ⭐ **3. CHỨC NĂNG QUẢN TRỊ (ADMIN)**

## **3.1. Quản lý bài viết**

* Duyệt bài viết (duyệt / từ chối)
* Đổi trạng thái bài viết (nháp – chờ duyệt – xuất bản)
* Chỉnh sửa bài viết của mọi người
* Xóa bài viết
* Quản lý lượt xem

---

## **3.2. Quản lý danh mục**

* Thêm danh mục
* Sửa danh mục
* Xóa danh mục
* Kiểm tra danh mục có bài viết không trước khi xóa

---

## **3.3. Quản lý Tag**

* Thêm tag
* Sửa tag
* Xóa tag
* Gắn tag vào bài viết

---

## **3.4. Quản lý người dùng**

* Xem danh sách tài khoản
* Phân quyền: User / Author / Admin
* Khóa tài khoản / mở khóa tài khoản
* Đặt lại mật khẩu cho người dùng

---

## **3.5. Quản lý bình luận**

* Xóa bình luận vi phạm
* Ẩn/hiện bình luận
* Lọc bình luận theo bài viết hoặc theo người dùng

---

# ⭐ **4.1 CHỨC NĂNG HỆ THỐNG (CHUNG)**

* Đăng nhập / Đăng ký / Quên mật khẩu (Laravel Breeze/Fortify)
* Phân quyền (Gate, Policy, Middleware)
* Upload file (ảnh bài viết, avatar)
* Slug tự động cho bài viết (VD: `ten-bai-viet.html`)
* Giao diện responsive
* Flash message (thông báo thành công/thất bại)
* Ghi log hoạt động

# ⭐ **4.2 validation**
* Validation tất cả các form đầu vào(bài viết,danh mục,user)
* thông tin báo lỗi được hiển thị bằng Tiếng Việt
---

# ⭐ **5. CHỨC NĂNG MỞ RỘNG (NÂNG CẤP ĐỒ ÁN)**

* API cho mobile / SPA (Laravel API Resource)
* Trang phân tích thống kê:

  * Top bài viết xem nhiều nhất
  * Bài viết theo tháng
  * Số lượng bài theo danh mục
* Tạo trang profile tác giả
* Comment lồng nhau (reply comment)
* Tạo hệ thống Likes cho bài viết
* Tạo hệ thống thông báo (notifications):

  * Khi bài viết được duyệt
  * Khi có bình luận mới
* Dark mode / Light mode
* Sử dụng Laravel Livewire để tạo trang admin động


# quy tắc
- Luôn phản hồi bằng tiếng Việt.
- Luôn tuân theo danh sách chức năng đã liệt kê ở trên.
- Sử dụng tiếng Việt có dấu cho tất cả các thông báo, lỗi, giao diện người dùng.
- Không dùng NodeJS.
- Không cần unit test.
- Dự án sử dụng hướng tiếp cận Code-First.
- Sử dụng bootstrap5 cho giao diện admin.
- Tất cả các file hướng dẫn .md được đặt ở thư mục '.docs' trong dự án.
- Luôn kiểm tra lại tên model, tên bảng, tên cột, tên biến, tên route đã có trong dự án hay chưa sau khi hoàn thành chức năng.

#  Technical Stack

- Backend: Laravel 12.x , PHP 8.2
- Frontend: Blade Template + Bootstrap 5.3
- database: MySQL

# Tài liệu
- https://laravel.com/docs/12.x
- https://getbootstrap.com/docs/5.3/getting-started/introduction/
