<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Chào mừng bạn đến với DDH Electronics</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; background: #0f172a; padding: 30px; border-radius: 10px 10px 0 0; }
        .header h1 { color: #fbbf24; margin: 0; letter-spacing: 2px; text-transform: uppercase; font-size: 24px; }
        .content { padding: 40px 30px; background: #ffffff; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #999; }
        .btn { display: inline-block; padding: 12px 30px; background: #ef4444; color: #ffffff !important; text-decoration: none; border-radius: 50px; font-weight: bold; margin-top: 20px; }
        .coupon-box { background: #f8fafc; border: 2px dashed #fbbf24; padding: 20px; text-align: center; margin: 30px 0; border-radius: 10px; }
        .coupon-code { font-size: 28px; font-weight: bold; color: #0f172a; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DDH Electronics</h1>
        </div>
        <div class="content">
            <h2 style="color: #0f172a;">Chào mừng bạn mới!</h2>
            <p>Hệ thống DDH Electronics đã nhận được đăng ký của bạn. Từ nay, bạn sẽ là người đầu tiên nhận được những tin tức công nghệ mới nhất và các chương trình khuyến mãi độc quyền của chúng tôi.</p>
            
            <p>Như một lời cảm ơn, chúng tôi gửi tặng bạn mã giảm giá đặc biệt cho đơn hàng đầu tiên:</p>
            
            <div class="coupon-box">
                <p style="margin-top: 0; color: #64748b; font-size: 14px; text-transform: uppercase; letter-spacing: 1px;">Mã giảm giá của bạn:</p>
                <div class="coupon-code">DDHE-WELCOME</div>
                <p style="margin-bottom: 0; color: #ef4444; font-weight: bold;">Giảm ngay 10% tổng đơn hàng</p>
            </div>

            <p>Đừng bỏ lỡ những mẫu Gear cực phẩm đang chờ đón bạn!</p>
            
            <div style="text-align: center;">
                <a href="{{ url('/') }}" class="btn">MUA SẮM NGAY</a>
            </div>
        </div>
        <div class="footer">
            <p>&copy; 2026 DDH Electronics. 235 Hoàng Quốc Việt, Cầu Giấy, Hà Nội.</p>
            <p>Nếu bạn không muốn nhận những email này, bạn có thể <a href="#">hủy đăng ký</a> bất cứ lúc nào.</p>
        </div>
    </div>
</body>
</html>
