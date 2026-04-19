# ĐỀ TÀI: DỰ ÁN HỆ THỐNG THƯƠNG MẠI ĐIỆN TỬ DDH ELECTRONICS

## 1. Mô tả đề tài
Xây dựng một hệ thống thương mại điện tử chuyên nghiệp, tập trung vào trải nghiệm người dùng, tính bảo mật và khả năng mở rộng. Hệ thống cho phép kinh doanh các sản phẩm phụ kiện công nghệ (Tai nghe, Chuột, Bàn phím,...) với quy trình khép kín từ đặt hàng, thanh toán trực tuyến đến quản lý vận chuyển.

## 2. Công nghệ sử dụng (Tech Stack)
*   **Backend:** Laravel Framework (PHP) - Tận dụng Eloquent ORM, Middleware, Service Provider, Notification System.
*   **Frontend:** HTML5, CSS3, Bootstrap 5, Javascript (ES6+), Chart.js (cho Dashboard).
*   **Database:** MySQL Server.
*   **Realtime:** Laravel Reverb hoặc Pusher (hỗ trợ Chat & Thông báo tức thời).
*   **Thanh toán:** Tích hợp API VNPAY / MoMo (Môi trường Sandbox - Thử nghiệm).
*   **Công cụ:** Git, Composer, XAMPP, phpMyAdmin.

## 3. Hệ thống chức năng (Tiêu chuẩn 100% Đồ án)

### 3.1. Chức năng Admin (Quản trị vận hành)
*   **Dashboard Business Intelligence:** 
    *   Biểu đồ thống kê doanh thu theo ngày/tuần/tháng (Sử dụng Chart.js).
    *   Bảng tin tóm tắt: Đơn hàng mới, sản phẩm bán chạy nhất, khách hàng mới.
*   **Quản lý Kho hàng & Sản phẩm (Inventory):** 
    *   Quản lý thuộc tính sản phẩm (Màu sắc, kích thước, Switch...).
    *   Theo dõi số lượng tồn kho, tự động cập nhật trạng thái khi hết hàng.
*   **Quản lý Đơn hàng Chuyên sâu:** 
    *   Quy trình xử lý đơn hàng: Chờ xác nhận -> Đang xử lý -> Đang giao -> Đã hoàn thành/Hủy.
*   **Quản lý Chiến dịch (Marketing):** 
    *   Quản lý Mã giảm giá (Voucher): Giới hạn số lần dùng, ngày hết hạn, giá trị tối thiểu.
    *   Cấu hình Flash Sale: Chỉnh sửa giá sale và thời gian đếm ngược.
*   **Quản lý Phân quyền (RBAC):** Phân chia vai trò (Super Admin, Staff xử lý đơn).

### 3.2. Chức năng User (Trải nghiệm khách hàng)
*   **Xác thực đa kênh:** 
    *   Đăng ký/Đăng nhập (Validation đầy đủ).
    *   Đăng nhập nhanh qua Google/Facebook (Laravel Socialite).
    *   Chức năng "Quên mật khẩu" qua Email (Mailtrap/Gmail SMTP).
*   **Tìm kiếm & Bộ lọc (Smart Search):** 
    *   Tìm kiếm Ajax, lọc theo thương hiệu, khoảng giá, đánh giá sao.
*   **Giỏ hàng thông minh (Cart Logic):** 
    *   Lưu giỏ hàng vào Database (khách quay lại giỏ hàng vẫn còn nguyên).
    *   Tự động tính toán tổng tiền và áp dụng Voucher ngay trong giỏ.
*   **Thanh toán Đa phương thức:** 
    *   Thanh toán COD (Nhận hàng trả tiền).
    *   Thanh toán Online qua VNPAY / MoMo (Demo qua môi trường Sandbox cực kỳ mượt mà).
*   **Theo dõi & Đánh giá:** 
    *   Xem lịch sử và trạng thái đơn hàng thời gian thực.
    *   Đánh giá sản phẩm kèm hình ảnh thực tế sau khi nhận hàng.

## 4. Chức năng nâng cao (Điểm cộng kỹ thuật)
### 4.1. Realtime Communication
*   Hệ thống Chat trực tuyến với Admin (Socket).
*   Thông báo đẩy (Push Notification) khi đơn hàng chuyển trạng thái hoặc có tin nhắn mới.

### 4.2. Hệ thống Flash Sale & Countdown
*   Đồng hồ đếm ngược (Countdown) cập nhật theo giây tại trang chủ.
*   Logic tự động kết thúc giá khuyến mãi khi hết thời gian qui định.

### 4.3. Tối ưu SEO & Performance
*   URL thân thiện (Slugs): `/san-pham/chuot-logitech-mx-master-3s`.
*   Tối ưu hóa hình ảnh khi upload và sử dụng Lazy Loading cho website.

## 5. Bảo mật & Quy chuẩn code
*   **Authentication & Authorization:** Middleware chặn truy cập trái phép vào trang Admin.
*   **Security:** Chặn SQL Injection, CSRF protection (mặc định Laravel), XSS filtering.
*   **Mã hóa:** Toàn bộ mật khẩu và dữ liệu nhạy cảm được mã hóa (Bcrypt).

---
*Dự án thực hiện bởi nhóm sinh viên Đại học Điện lực (EPU): Dương - Đạt - Hiếu.*
*Bản đề cương chuyên nghiệp dành cho Hệ thống Thương mại điện tử DDH Electronics.*
