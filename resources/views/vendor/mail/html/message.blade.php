<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{!! $slot !!}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{!! $subcopy !!}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
<div style="margin-bottom: 25px; border-top: 1px solid #e2e8f0; padding-top: 25px;">
    <p style="color: #0d2137; font-weight: 800; font-size: 14px; margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px;">HỆ THỐNG CỬA HÀNG DDH ELECTRONICS</p>
    <p style="margin: 0; font-size: 13px; line-height: 1.8; color: #4b5563;">
        📍 <strong>Trụ sở:</strong> 235 Hoàng Quốc Việt, Cầu Giấy, Hà Nội<br>
        📞 <strong>Hotline hỗ trợ:</strong> 0337 654 252 (8:00 - 22:00)<br>
        📧 <strong>Email hỗ trợ:</strong> duongnguyen0602ls@gmail.com
    </p>
</div>
<div style="font-size: 11px; color: #94a3b8; line-height: 1.6;">
    © {{ date('Y') }} DDH Electronics. Toàn bộ bản quyền thuộc về team: Dương - Đạt - Hiếu.<br>
    Đây là email tự động từ hệ thống, vui lòng không phản hồi trực tiếp vào email này.
</div>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
