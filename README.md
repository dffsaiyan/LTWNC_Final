# 🛒 DDH Electronics - Hệ thống Thương mại Điện tử Linh kiện & Thiết bị Số Cao cấp

> **Đồ án / Bài tập lớn Lập trình Web nâng cao**  
> Một nền tảng E-commerce toàn diện xây dựng trên nền tảng Laravel 11, tích hợp Trí tuệ nhân tạo (AI), Thanh toán trực tuyến VNPay/MoMo và Hệ thống quản trị thông minh.

---

## 👥 1. Thành viên nhóm dự án

| STT | Họ và tên        | MSSV        | Vai trò        | Nhiệm vụ chính                                      |
| --- | ---------------- | ----------- | -------------- | --------------------------------------------------- |
| 1   | Nguyễn Đức Dương | 23810310091 | **Nhóm trưởng**| Quản lý dự án, Phát triển Backend, Tích hợp AI      |
| 2   | Nguyễn Văn Đạt   | 23810310093 | Thành viên     | Thiết kế Database, Tích hợp thanh toán VNPay/MoMo   |
| 3   | Nguyễn Văn Hiếu  | 23810310112 | Thành viên     | Phát triển Frontend, Xây dựng Dashboard Admin        |

---

## 📋 2. Tài liệu Đặc tả Yêu cầu Phần mềm (Full SRS)

Dưới đây là bảng phân rã chi tiết các yêu cầu chức năng của hệ thống:

### 2.1 Module Xác thực & Phân quyền (Authentication & Authorization)
| Mã | Chức năng | Mô tả chi tiết | Trạng thái |
| --- | --- | --- | --- |
| **AUTH-01** | Đăng ký tài khoản | Khách hàng đăng ký bằng Email, xác thực qua mã OTP gửi về Mail. | ✅ Done |
| **AUTH-02** | Đăng nhập truyền thống | Đăng nhập bằng Email và mật khẩu đã mã hóa Bcrypt. | ✅ Done |
| **AUTH-03** | Đăng nhập Google | Tích hợp Laravel Socialite để đăng nhập qua Google OAuth 2.0. | ✅ Done |
| **AUTH-04** | Đăng nhập Zalo | Tích hợp đăng nhập qua hệ sinh thái Zalo (Zalo Social Login). | ✅ Done |
| **AUTH-05** | Quên mật khẩu | Gửi link reset mật khẩu có thời hạn (Tokenized URL). | ✅ Done |
| **AUTH-06** | Cập nhật hồ sơ | Thay đổi thông tin cá nhân, cập nhật Avatar qua thư viện Intervention Image. | ✅ Done |
| **AUTH-07** | Đổi mật khẩu | Cơ chế kiểm tra mật khẩu cũ trước khi thay đổi mật khẩu mới. | ✅ Done |
| **AUTH-08** | Middleware Admin | Chặn truy cập trái phép vào khu vực quản trị viên. | ✅ Done |
| **AUTH-09** | Remember Me | Sử dụng Token-based để ghi nhớ đăng nhập trong 30 ngày. | ✅ Done |

### 2.2 Module Quản lý Sản phẩm & Danh mục (Product Catalog)
| Mã | Chức năng | Mô tả chi tiết | Trạng thái |
| --- | --- | --- | --- |
| **PROD-01** | Quản lý danh mục | Cấu trúc Parent-Child (Danh mục cha - con) không giới hạn cấp. | ✅ Done |
| **PROD-02** | Quản lý thương hiệu | Phân loại sản phẩm theo hãng sản xuất (Apple, Samsung, ASUS...). | ✅ Done |
| **PROD-03** | Quản lý sản phẩm | Thêm mới sản phẩm kèm bộ ảnh Gallery, thông số kỹ thuật. | ✅ Done |
| **PROD-04** | Tìm kiếm Full-text | Tìm kiếm nhanh theo tên sản phẩm bằng AJAX. | ✅ Done |
| **PROD-05** | Bộ lọc nâng cao | Lọc theo khoảng giá, thương hiệu, đánh giá sao, trạng thái hàng. | ✅ Done |
| **PROD-06** | Sản phẩm nổi bật | Đánh dấu các sản phẩm hot để hiển thị ngoài trang chủ. | ✅ Done |
| **PROD-07** | Quản lý tồn kho | Tự động trừ kho khi đơn hàng hoàn thành, cảnh báo khi sắp hết. | ✅ Done |
| **PROD-08** | Review & Rating | Khách hàng đánh giá sản phẩm (1-5 sao) kèm hình ảnh thực tế. | ✅ Done |
| **PROD-09** | Sản phẩm liên quan | Hiển thị các sản phẩm cùng danh mục hoặc cùng mức giá. | ✅ Done |
| **PROD-10** | Quản lý biến thể | Quản lý màu sắc, dung lượng RAM/ROM cho từng sản phẩm. | ✅ Done |

### 2.3 Module Giao dịch & Thanh toán (Transaction & Payment)
| Mã | Chức năng | Mô tả chi tiết | Trạng thái |
| --- | --- | --- | --- |
| **CART-01** | Giỏ hàng Real-time | Thêm/Xóa sản phẩm, cập nhật số lượng tự động qua AJAX. | ✅ Done |
| **PAY-01** | Thanh toán VNPay | Tích hợp cổng VNPay (QR Code, ATM, International Card). | ✅ Done |
| **PAY-02** | Thanh toán MoMo | Tích hợp ví điện tử MoMo qua API thanh toán trực tiếp. | ✅ Done |
| **PAY-03** | Thanh toán COD | Phương thức thanh toán khi nhận hàng truyền thống. | ✅ Done |
| **ORDER-01** | Quy trình Checkout | Quy trình 3 bước: Thông tin nhận hàng -> Thanh toán -> Hoàn tất. | ✅ Done |
| **ORDER-02** | Quản lý đơn hàng | Theo dõi trạng thái đơn hàng (Pending, Processing, Delivered...). | ✅ Done |
| **ORDER-03** | Lịch sử mua hàng | Khách hàng xem lại các đơn hàng đã đặt và hóa đơn điện tử. | ✅ Done |
| **ORDER-04** | Hủy đơn hàng | Khách hàng có thể hủy đơn khi trạng thái là Pending. | ✅ Done |
| **ORDER-05** | Mã giảm giá | Áp dụng Coupon (phần trăm hoặc số tiền cố định) vào tổng đơn. | ✅ Done |

### 2.4 Module AI & Hỗ trợ (AI & Support)
| Mã | Chức năng | Mô tả chi tiết | Trạng thái |
| --- | --- | --- | --- |
| **AI-01** | Trợ lý tư vấn Groq | Sử dụng mô hình Llama 3.3 để tư vấn linh kiện phù hợp. | ✅ Done |
| **AI-02** | Chatbot 24/7 | Hỗ trợ giải đáp chính sách bảo hành, đổi trả tự động. | ✅ Done |
| **AI-03** | Gợi ý sản phẩm | AI phân tích câu hỏi để đưa ra link sản phẩm thực tế trong shop. | ✅ Done |
| **AI-04** | Lưu lịch sử Chat | Lưu lại cuộc hội thoại để phân tích nhu cầu khách hàng. | ✅ Done |

---

## 🗂️ 3. Cấu trúc Thư mục Chi tiết (Detailed Folder Map)

### 📂 app/Http/Controllers
- **AuthController.php:** Chịu trách nhiệm quản lý toàn bộ luồng xác thực, bao gồm đăng ký, đăng nhập và xử lý Token Socialite.
- **ProductController.php:** Xử lý hiển thị danh sách sản phẩm, chi tiết sản phẩm và các logic lọc nâng cao.
- **CartController.php:** Quản lý giỏ hàng trong Session và Database, xử lý tính toán tổng tiền.
- **PaymentController.php:** Tích hợp logic băm mã hóa (Hash) cho VNPay và MoMo.
- **ChatBotController.php:** Kết nối với API Groq, xử lý Prompt Engineering để AI trả lời đúng ngữ cảnh.
- **HomeController.php:** Quản lý giao diện trang chủ, load banner và sản phẩm nổi bật.
- **ReviewController.php:** Xử lý logic đánh giá và bình luận sản phẩm.
- **Admin/DashboardController.php:** Tổng hợp dữ liệu từ database để vẽ biểu đồ thống kê Chart.js.
- **Admin/OrderController.php:** Quản lý luồng xử lý đơn hàng của quản trị viên.
- **Admin/UserController.php:** Quản lý danh sách người dùng, khóa/mở khóa tài khoản.

### 📂 app/Models
- **User.php:** Định nghĩa các quyền, quan hệ với Orders và Reviews.
- **Product.php:** Quan hệ với Category, Brand và Gallery Images.
- **Order.php:** Quản lý trạng thái đơn hàng và thông tin khách hàng.
- **OrderItem.php:** Lưu trữ giá tại thời điểm mua và số lượng sản phẩm.
- **Category.php:** Quản lý cấu trúc cây danh mục sản phẩm.
- **Brand.php:** Quản lý thông tin thương hiệu.
- **Review.php:** Quản lý các đánh giá của khách hàng.
- **Coupon.php:** Quản lý các mã giảm giá.
- **AiChatLog.php:** Model tương tác với bảng nhật ký AI.

### 📂 database/migrations
- **2014_10_12_000000_create_users_table.php:** Khởi tạo bảng người dùng.
- **2014_10_12_100000_create_password_resets_table.php:** Bảng reset mật khẩu.
- **2019_08_19_000000_create_failed_jobs_table.php:** Bảng log lỗi queue.
- **2019_12_14_000001_create_personal_access_tokens_table.php:** Bảng token API.
- **2026_04_01_create_categories_table.php:** Bảng danh mục.
- **2026_04_02_create_brands_table.php:** Bảng thương hiệu.
- **2026_04_03_create_products_table.php:** Bảng sản phẩm điện tử.
- **2026_04_04_create_orders_table.php:** Bảng quản lý giao dịch.
- **[Và 20 migrations khác...]**

---

## 💾 4. Đặc tả Cơ sở dữ liệu Toàn phần (Full SQL Schema)

Hệ thống được thiết kế với tính chuẩn hóa cao (3NF), đảm bảo tính nhất quán dữ liệu. Dưới đây là toàn bộ cấu trúc Schema cho 20+ bảng của hệ thống:

```sql
-- --------------------------------------------------------
-- 1. Bảng Users (Quản lý định danh)
-- --------------------------------------------------------
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer','staff') DEFAULT 'customer',
  `avatar` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `provider` varchar(50) DEFAULT NULL,
  `provider_id` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 2. Bảng Categories (Cấu trúc danh mục)
-- --------------------------------------------------------
CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 3. Bảng Brands (Thương hiệu)
-- --------------------------------------------------------
CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `brands_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 4. Bảng Products (Kho sản phẩm)
-- --------------------------------------------------------
CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `description` text,
  `content` longtext,
  `price` decimal(15,2) NOT NULL,
  `sale_price` decimal(15,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT '0',
  `is_featured` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  UNIQUE KEY `products_sku_unique` (`sku`),
  FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 5. Bảng Product_Images (Thư viện ảnh)
-- --------------------------------------------------------
CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `order` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 6. Bảng Orders (Giao dịch khách hàng)
-- --------------------------------------------------------
CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_code` varchar(20) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `discount` decimal(15,2) DEFAULT '0.00',
  `shipping_fee` decimal(15,2) DEFAULT '0.00',
  `total_amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'cod',
  `payment_status` varchar(20) DEFAULT 'unpaid',
  `status` varchar(20) DEFAULT 'pending',
  `shipping_name` varchar(255) NOT NULL,
  `shipping_phone` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_code_unique` (`order_code`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 7. Bảng Order_Items (Chi tiết đơn hàng)
-- --------------------------------------------------------
CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 8. Bảng Reviews (Đánh giá & Phản hồi)
-- --------------------------------------------------------
CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL DEFAULT '5',
  `comment` text,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 9. Bảng Coupons (Chương trình khuyến mãi)
-- --------------------------------------------------------
CREATE TABLE `coupons` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `type` enum('fixed','percent') NOT NULL,
  `value` decimal(15,2) NOT NULL,
  `min_order_value` decimal(15,2) DEFAULT '0.00',
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT '0',
  `start_date` date DEFAULT NULL,
  `expiry_date` date NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `coupons_code_unique` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 10. Bảng Wishlists (Sản phẩm yêu thích)
-- --------------------------------------------------------
CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 11. Bảng AI_Chat_Logs (Nhật ký Chatbot)
-- --------------------------------------------------------
CREATE TABLE `ai_chat_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `question` text NOT NULL,
  `answer` longtext NOT NULL,
  `tokens` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 12. Bảng Payments (Lịch sử thanh toán cổng ngoài)
-- --------------------------------------------------------
CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `response_code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 13. Bảng Banners (Quản lý Slide)
-- --------------------------------------------------------
CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `order` int(11) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- 14. Laravel System Tables (Bảng hệ thống)
-- --------------------------------------------------------
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

---

## ⚙️ 5. Hướng dẫn Cài đặt & Vận hành Chi tiết (Full Guide)

### 5.1 Yêu cầu cấu hình tối thiểu
Để dự án hoạt động ổn định nhất, hệ thống cần:
- **Server:** Nginx hoặc Apache (Khuyên dùng Laragon trên Windows).
- **PHP:** Phiên bản 8.2 trở lên (Bắt buộc, bao gồm ctype, curl, dom, fileinfo, filter, hash, mbstring, openssl, pcre, pdo, session, tokenizer, xml).
- **Database:** MySQL 8.0 trở lên.
- **Node.js:** v18.x trở lên để build Vite assets.
- **Composer:** Phiên bản 2.x.
- **SMTP:** Tài khoản Gmail đã bật xác thực 2 lớp (2FA).

### 5.2 Quy trình cài đặt từng bước
1. **Clone mã nguồn từ GitHub:**
   ```bash
   git clone https://github.com/dffsaiyan/LTWNC_DDH-Electronics.git
   cd LTWNC_DDH-Electronics
   ```
2. **Cài đặt thư viện phía Backend (Laravel):**
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
3. **Cài đặt thư viện phía Frontend (Vite/Tailwind):**
   ```bash
   npm install
   ```
4. **Cấu hình biến môi trường (.env):**
   - Sao chép tệp mẫu: `cp .env.example .env`
   - Chỉnh sửa Database:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=ddh_electronics
     DB_USERNAME=root
     DB_PASSWORD=your_password
     ```
   - Cấu hình API Groq AI:
     ```env
     GROQ_API_KEY=gsk_your_key_here
     ```
   - Cấu hình VNPay:
     ```env
     VNP_TMN_CODE=your_vnpay_tmn_code
     VNP_HASH_SECRET=your_vnpay_hash_secret
     VNP_URL=https://sandbox.vnpayment.vn/paymentv2/vpcpay.html
     VNP_RETURN_URL=http://localhost:8000/payment/vnpay/return
     ```
   - Cấu hình SMTP Email:
     ```env
     MAIL_MAILER=smtp
     MAIL_HOST=smtp.gmail.com
     MAIL_PORT=587
     MAIL_USERNAME=your_email@gmail.com
     MAIL_PASSWORD=your_app_password
     MAIL_ENCRYPTION=tls
     MAIL_FROM_ADDRESS="no-reply@ddhelectronics.com"
     MAIL_FROM_NAME="${APP_NAME}"
     ```
5. **Khởi tạo dữ liệu hệ thống:**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   php artisan storage:link
   ```
6. **Biên dịch giao diện:**
   ```bash
   npm run build
   ```
7. **Khởi chạy ứng dụng:**
   ```bash
   php artisan serve
   ```

---

## 📡 6. Tài liệu Đặc tả API (Comprehensive API Reference)

### 6.1 Authentication Endpoints
- **POST `/api/auth/register`**
  - **Payload:** `{ "name": "John Doe", "email": "john@example.com", "password": "password123", "password_confirmation": "password123" }`
  - **Response (201):** `{ "message": "User registered successfully", "token": "1|abc..." }`
- **POST `/api/auth/login`**
  - **Payload:** `{ "email": "john@example.com", "password": "password123" }`
  - **Response (200):** `{ "token": "2|def...", "user": { "id": 1, "name": "John Doe", "role": "customer" } }`
- **POST `/api/auth/logout`**
  - **Header:** `Authorization: Bearer {token}`
  - **Response (200):** `{ "message": "Logged out successfully" }`

### 6.2 Product Endpoints
- **GET `/api/products`**
  - **Query Params:** `?category=1&min_price=1000000&max_price=5000000&sort=price_asc`
  - **Response (200):** `{ "data": [ { "id": 1, "name": "Product A", "price": "2000000.00" } ], "links": {...} }`
- **GET `/api/products/{id}`**
  - **Response (200):** Trả về chi tiết sản phẩm kèm mảng hình ảnh gallery và reviews.

### 6.3 Cart & Checkout Endpoints
- **POST `/api/cart/add`**
  - **Payload:** `{ "product_id": 5, "quantity": 2 }`
  - **Response (200):** `{ "message": "Added to cart", "cart_count": 3, "total": "4000000.00" }`
- **POST `/api/checkout/process`**
  - **Header:** `Authorization: Bearer {token}`
  - **Payload:** `{ "address": "123 Main St", "phone": "0987654321", "payment_method": "vnpay" }`
  - **Response (200):** `{ "redirect_url": "https://sandbox.vnpayment.vn/..." }`

### 6.4 AI Assistant Endpoints
- **POST `/api/v1/ai/chat`**
  - **Payload:** `{ "message": "Nội dung câu hỏi về sản phẩm" }`
  - **Response (200):** `{ "reply": "Nội dung markdown từ Groq", "tokens_used": 150 }`

---

## 🧪 7. Kịch bản Kiểm thử Hệ thống (Extensive Test Cases)

### 7.1 Kịch bản 1: Mua hàng và Thanh toán VNPay (Happy Path)
1. **Mục tiêu:** Khách hàng hoàn tất luồng mua hàng trơn tru.
2. **Bước 1:** Khách hàng (User) đăng nhập thành công.
3. **Bước 2:** Tìm kiếm "Laptop ASUS ROG Strix" qua thanh search AJAX.
4. **Bước 3:** Nhấn "Thêm vào giỏ hàng". Popup Toast thông báo thành công.
5. **Bước 4:** Vào giỏ hàng, xác nhận tổng tiền (VD: 35,000,000 VND).
6. **Bước 5:** Bấm "Thanh toán", điền form địa chỉ nhận hàng (Bắt buộc các trường Name, Phone, Address).
7. **Bước 6:** Chọn phương thức "Thanh toán qua VNPay" và bấm Submit.
8. **Bước 7:** Hệ thống redirect sang VNPay Sandbox.
9. **Bước 8:** Nhập số thẻ test: `9704198524651468855`, Tên: `NGUYEN VAN A`, Ngày phát hành: `07/15`, OTP: `123456`.
10. **Bước 9:** Bấm thanh toán. VNPay redirect về lại trang `/payment/vnpay/return`.
11. **Kết quả mong đợi:** 
    - Trang web hiển thị "Thanh toán thành công".
    - Database bảng `orders` chuyển trạng thái `payment_status` thành `paid`.
    - Giỏ hàng bị làm trống.
    - Một email biên lai được gửi tới khách hàng.

### 7.2 Kịch bản 2: Hủy thanh toán VNPay (Edge Case)
1. **Mục tiêu:** Xử lý khi khách hàng đổi ý không thanh toán.
2. **Bước 1-7:** Giống Kịch bản 1.
3. **Bước 8:** Tại trang VNPay Sandbox, khách hàng bấm "Hủy giao dịch".
4. **Kết quả mong đợi:**
    - VNPay redirect về `/payment/vnpay/return` với mã lỗi.
    - Trang web hiển thị "Giao dịch đã bị hủy".
    - Database bảng `orders` cập nhật trạng thái `payment_status` thành `unpaid` hoặc `cancelled`.
    - Giỏ hàng vẫn giữ nguyên sản phẩm để khách thanh toán lại sau.

### 7.3 Kịch bản 3: Quản trị viên cập nhật tồn kho (Admin Flow)
1. **Mục tiêu:** Đảm bảo logic cảnh báo hết hàng hoạt động.
2. **Bước 1:** Admin đăng nhập vào trang `/admin/login`.
3. **Bước 2:** Điều hướng tới menu "Sản phẩm" -> Chọn "iPhone 15 Pro".
4. **Bước 3:** Chỉnh sửa thuộc tính `stock` từ 10 xuống 0. Lưu thay đổi.
5. **Bước 4:** Mở trình duyệt ẩn danh, vào xem chi tiết "iPhone 15 Pro".
6. **Kết quả mong đợi:** Nút "Thêm vào giỏ" bị vô hiệu hóa (disabled), text đổi thành "Hết hàng".

### 7.4 Kịch bản 4: Tương tác với Trợ lý AI (AI Flow)
1. **Mục tiêu:** AI nhận diện đúng intent và cung cấp thông tin hữu ích.
2. **Bước 1:** Click biểu tượng Chatbot.
3. **Bước 2:** Gõ: "Tư vấn cho tôi PC chơi game tầm giá 20 triệu".
4. **Kết quả mong đợi:** 
    - Spinner loading xuất hiện (dưới 1 giây).
    - AI trả lời bằng tiếng Việt, liệt kê cấu hình máy tính hoặc gợi ý các sản phẩm có giá quanh mức 20,000,000 VND.
    - Bảng `ai_chat_logs` ghi nhận câu hỏi và câu trả lời.

---

## 📝 8. Nhật ký Phát triển & Cập nhật (Detailed Changelog)

### v1.0.0 - Foundation (01/04/2026)
- Khởi tạo cấu trúc dự án Laravel 11.
- Cài đặt thư viện: `bacon/bacon-qr-code`, `guzzlehttp/guzzle`, `intervention/image`, `laravel/sanctum`, `laravel/socialite`.
- Thiết lập cấu trúc cơ sở dữ liệu ban đầu.

### v1.1.0 - Core Features (05/04/2026)
- Hoàn thiện 25 bảng Migration và Models.
- Xây dựng giao diện User Interface với Tailwind CSS và Blade.
- Phát triển luồng xác thực (Register, Login, Password Reset).

### v1.2.0 - E-commerce Engine (10/04/2026)
- Xây dựng module Giỏ hàng Real-time sử dụng AJAX.
- Phát triển module quản lý Đơn hàng và tính toán giá (Coupon, Shipping).
- Thiết kế hệ thống lọc sản phẩm nhiều tiêu chí.

### v1.3.0 - Payment Gateways (12/04/2026)
- Tích hợp cổng thanh toán VNPay (Tạo URL, IPN, Return).
- Tích hợp ví MoMo (Create Request, IPN).
- Viết Unit Tests cho các logic tạo Hash chữ ký.

### v1.4.0 - AI Integration (15/04/2026)
- Triển khai module AI Chatbot.
- Kết nối Groq API sử dụng model `llama3-70b-8192`.
- Tối ưu hóa System Prompt để AI đóng vai trò nhân viên tư vấn.

### v1.5.0 - Admin Dashboard (18/04/2026)
- Xây dựng giao diện Quản trị viên (AdminLTE/Custom).
- Tạo biểu đồ thống kê doanh thu (Chart.js).
- Hoàn thiện chức năng CRUD cho Danh mục, Sản phẩm, Đơn hàng, Người dùng.

### v1.6.0 - Security & Performance (21/04/2026)
- Sửa lỗi N+1 Query Problem bằng Eager Loading (`with()`).
- Kích hoạt Route Caching và Config Caching.
- Áp dụng các biện pháp bảo mật XSS, CSRF, SQL Injection.

### v1.7.0 - Final Release (22/04/2026)
- Đóng gói dự án.
- Viết tài liệu README hoàn chỉnh (800+ lines).

---

## 🛡️ 9. Chính sách Bảo mật & Tối ưu hóa (Security & Audit)

### 9.1 Cơ chế Bảo mật Kỹ thuật sâu
1. **SQL Injection Prevention:** Toàn bộ truy vấn cơ sở dữ liệu thực hiện thông qua Eloquent ORM và Query Builder, tự động áp dụng PDO Parameter Binding. Không sử dụng các truy vấn raw string nối trực tiếp.
2. **Cross-Site Request Forgery (CSRF):** Middleware `VerifyCsrfToken` được kích hoạt toàn cục cho các route WEB. Mọi form POST/PUT/DELETE đều yêu cầu thẻ `@csrf`.
3. **Cross-Site Scripting (XSS):** Sử dụng hàm `e()` hoặc cú pháp `{{ $variable }}` của Blade engine để escape toàn bộ dữ liệu hiển thị ra views.
4. **Mass Assignment Vulnerabilities:** Khai báo rõ ràng mảng `$fillable` hoặc `$guarded` trong các Models để ngăn chặn hacker chèn thêm trường dữ liệu không mong muốn qua request payload.
5. **Rate Limiting:** Áp dụng giới hạn request (Throttle) cho các route đăng nhập (VD: 5 lần/phút) để chống tấn công Brute Force.
6. **Data Encryption:** Mật khẩu lưu trữ bằng thuật toán Bcrypt. Các thông tin nhạy cảm khác (như API Keys) được quản lý qua tệp `.env` và mã hóa qua `config:cache`.

### 9.2 Cơ chế Tối ưu hóa Hiệu năng (Performance)
1. **N+1 Query Optimization:** Sử dụng Eager Loading (`Product::with('category', 'brand')->get()`) thay vì Lazy Loading trong vòng lặp.
2. **Database Indexing:** Tạo Index cho các cột thường xuyên được truy vấn (WHERE, ORDER BY) như `category_id`, `price`, `status`, `slug`.
3. **Caching Strategy:**
   - Caching kết quả truy vấn danh mục sản phẩm (hiếm khi thay đổi).
   - Sử dụng `php artisan route:cache` và `php artisan config:cache` trên môi trường Production.
4. **Asset Minification:** Sử dụng Vite (Rollup) để bundle và minify toàn bộ tệp CSS, JS, loại bỏ các dead-code trước khi deploy.

---

## 📖 10. Cẩm nang Hướng dẫn Sử dụng (User Manual)

### 10.1 Dành cho Khách hàng (End-User)
1. **Khám phá sản phẩm:** Truy cập trang chủ `http://localhost:8000`. Sử dụng menu điều hướng trên cùng để duyệt theo Danh mục (VD: Laptop, PC, Phụ kiện).
2. **Đăng ký / Đăng nhập:** Góc trên cùng bên phải có nút Đăng nhập. Bạn có thể sử dụng Google/Zalo để tạo tài khoản nhanh chóng mà không cần nhớ mật khẩu.
3. **Sử dụng AI Tư vấn:** Nhấn vào biểu tượng Chatbot trôi nổi ở góc dưới bên phải màn hình. Nhập yêu cầu, ví dụ: "Máy tính nào thiết kế đồ họa tốt?".
4. **Mua hàng:** Bấm nút "Thêm vào giỏ" ở trang chi tiết sản phẩm.
5. **Thanh toán:** Vào Giỏ hàng -> Chọn "Thanh toán". Điền thông tin giao hàng. Lựa chọn Thanh toán khi nhận hàng (COD) hoặc Thanh toán trực tuyến (VNPay/MoMo) để được ưu tiên xử lý.
6. **Theo dõi đơn:** Sau khi đặt, vào mục "Hồ sơ của tôi" -> "Đơn hàng" để theo dõi lịch trình vận chuyển.

### 10.2 Dành cho Quản trị viên (Administrator)
1. **Đăng nhập quản trị:** Truy cập `http://localhost:8000/admin/login`. Đăng nhập bằng tài khoản Admin cấp cao.
2. **Dashboard:** Màn hình đầu tiên là biểu đồ doanh thu. Phía trên có các thẻ thống kê tổng số đơn hàng mới, tổng người dùng, tổng doanh thu trong tháng.
3. **Quản lý Sản phẩm:**
   - Điều hướng tới `Sản phẩm` -> `Danh sách`.
   - Bấm `Thêm mới`: Điền tên, giá, số lượng kho, chọn danh mục. Upload ảnh đại diện và nhiều ảnh chi tiết. Hỗ trợ trình soạn thảo WYSIWYG cho phần mô tả.
4. **Xử lý Đơn hàng:**
   - Điều hướng tới `Đơn hàng`.
   - Các đơn mới sẽ có nhãn `Pending`. Bấm vào biểu tượng mắt để xem chi tiết thông tin người nhận.
   - Khi đã đóng gói xong, chuyển trạng thái sang `Đang giao`. Hệ thống sẽ tự động gửi email cho khách.
5. **Quản lý Khuyến mãi:** Tạo mã giảm giá (Coupon), cấu hình thời hạn, số lượng sử dụng và mức giảm (VNĐ hoặc %).

---

## ⚠️ 11. Bảng Khắc phục sự cố (Troubleshooting Matrix)

| Lỗi / Hiện tượng | Nguyên nhân phổ biến | Cách giải quyết triệt để |
| --- | --- | --- |
| **Trắng trang (Error 500)** | Quyền thư mục sai hoặc thiếu Vendor. | Chạy `composer install` và `chmod -R 775 storage bootstrap/cache`. Đảm bảo file `.env` tồn tại. |
| **SQLSTATE[HY000] [1049]** | Khai báo sai tên Database trong .env. | Kiểm tra `DB_DATABASE`, tạo lại DB rỗng trong MySQL và chạy `php artisan migrate`. |
| **Không hiển thị ảnh tải lên** | Symlink chưa được tạo. | Mở terminal chạy `php artisan storage:link`. Cập nhật `APP_URL` trong `.env` khớp với domain thực tế. |
| **Lỗi Gửi Email (Timeout)** | Thông tin SMTP sai hoặc bị chặn Port. | Kiểm tra `MAIL_PASSWORD` (Phải là App Password của Gmail, không phải mật khẩu gốc). Tắt tường lửa chặn port 587. |
| **Lỗi Hash VNPay** | Sai Secret Key. | Đối chiếu `VNP_HASH_SECRET` trong `.env` với mã trên Merchant Portal. Tuyệt đối không để dư dấu cách. |
| **Groq AI báo Rate Limit** | Gửi quá nhiều request liên tục. | Đợi 1 phút để API reset limit. Hoặc đổi sang một `GROQ_API_KEY` khác cấp cao hơn. |
| **CSRF Token Mismatch** | Session hết hạn hoặc cấu hình domain sai. | Nhấn F5 tải lại trang. Chạy `php artisan cache:clear`. Xóa cookie trình duyệt. |

---

## 📸 12. Hình ảnh Minh họa Hệ thống (System Gallery)

1. **Trang chủ (Homepage):**
   ![Homepage](1.jpg)
2. **Trang chi tiết sản phẩm (Product Detail):**
   ![Product Detail](2.jpg)
3. **Giao diện Giỏ hàng & Checkout (Cart & Payment):**
   ![Checkout](3.jpg)
4. **Màn hình Quản trị viên (Admin Dashboard):**
   ![Admin Dashboard](4.jpg)
5. **Giao diện Chatbot AI (AI Assistant):**
   ![AI Chat](5.jpg)

---

## 🌐 13. Định hướng Phát triển Tương lai (Future Roadmap)

Mặc dù dự án đã hoàn thiện tốt nghiệp khóa học, chúng tôi có kế hoạch mở rộng hệ thống trong tương lai:
1. **Phát triển Mobile App:** Sử dụng **Flutter** để build ứng dụng iOS/Android, giao tiếp qua bộ RESTful API đã xây dựng sẵn trong dự án này.
2. **Hệ thống Recommendation Engine:** Áp dụng Machine Learning (Collaborative Filtering) để gợi ý sản phẩm dựa trên hành vi mua sắm của các người dùng khác.
3. **Mở rộng Gateway Thanh toán:** Tích hợp thêm PayPal và Stripe để phục vụ thị trường quốc tế.
4. **Hệ thống Loyalty (Tích điểm):** Tích điểm cho mỗi lần mua hàng thành công để quy đổi thành Voucher.

---

## 📞 14. Liên hệ & Bản quyền (Contact & License)

- **Đại diện Nhóm phát triển:** Nguyễn Đức Dương (Trưởng nhóm)
- **Email Hỗ trợ kỹ thuật:** `duongnguyen0602ls@gmail.com`
- **Số điện thoại/Zalo:** 0337-654-252
- **Đơn vị đào tạo:** D18CNPM2 - Khoa Công nghệ Thông tin - Đại học Điện lực (EPU).

**Giấy phép (License):**
Dự án được mã nguồn mở theo giấy phép MIT. Các thành viên có thể sử dụng mã nguồn này làm tài liệu tham khảo cho các dự án cá nhân, nhưng việc sao chép nguyên trạng để nộp đồ án khác bị nghiêm cấm.

---
*Dự án thực hiện phục vụ mục đích học tập môn Lập trình Web nâng cao - Hà Nội, tháng 04 năm 2026.*

