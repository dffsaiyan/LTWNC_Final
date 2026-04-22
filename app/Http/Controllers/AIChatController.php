<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIChatController extends Controller
{
    public function chat(Request $request)
    {
        $userMessage = $request->input('message');
        $apiKey = env('GROQ_API_KEY');
        $model = env('GROQ_MODEL', 'llama-3.3-70b-versatile');

        if (!$apiKey) {
            return response()->json(['reply' => 'Lỗi: Chưa cấu hình API Key cho Groq.']);
        }

        try {
            // 1. TÌM KIẾM SẢN PHẨM TRONG DATABASE DỰA TRÊN TIN NHẮN
            // Loại bỏ các từ vô nghĩa để tìm kiếm chính xác hơn
            $stopWords = ['có', 'loại', 'nào', 'giá', 'bao', 'nhiêu', 'của', 'với', 'cho', 'mẫu'];
            $cleanMessage = str_replace(['?', '!', '.', ','], '', $userMessage);
            $rawWords = explode(' ', $cleanMessage);
            $keywords = array_filter($rawWords, function($word) use ($stopWords) {
                return mb_strlen($word) > 2 && !in_array(mb_strtolower($word), $stopWords);
            });

            $query = \App\Models\Product::where('is_active', true);
            
            if (!empty($keywords)) {
                $query->where(function($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $q->orWhere('name', 'like', "%{$word}%")
                          ->orWhere('description', 'like', "%{$word}%");
                    }
                });
            }
            
            $relatedProducts = $query->limit(10)->get(['name', 'price', 'sale_price', 'slug', 'stock']);
            
            $productContext = "";
            if ($relatedProducts->count() > 0) {
                $productContext = "\n\nTHÔNG TIN SẢN PHẨM THỰC TẾ TRONG KHO (ƯU TIÊN DÙNG DỮ LIỆU NÀY):\n";
                foreach ($relatedProducts as $p) {
                    $origPrice = number_format($p->price, 0, ',', '.') . 'đ';
                    $salePrice = ($p->sale_price > 0) ? number_format($p->sale_price, 0, ',', '.') . 'đ' : null;
                    $displayPrice = $salePrice ? "{$salePrice} (Giá gốc: {$origPrice})" : $origPrice;
                    $productContext .= "- {$p->name}: {$displayPrice}. Link: /product/{$p->slug}\n";
                }
                $productContext .= "\nCHỈ DẪN: Nếu khách hỏi giá, hãy đọc GIÁ THỰC TẾ ở trên. KHÔNG trả lời chung chung. Hãy cung cấp link cụ thể cho từng sản phẩm.";
            } else {
                $productContext = "\n\n(Không tìm thấy sản phẩm cụ thể. Hãy tư vấn dựa trên kiến thức chung về gaming gear và mời khách xem trang chủ /).";
            }

            // Log để debug
            Log::info('Chat Context for: ' . $userMessage . ' | Found: ' . $relatedProducts->count() . ' products.');

            // 2. CHUẨN BỊ SYSTEM PROMPT
            $systemPrompt = "Bạn là trợ lý ảo chuyên nghiệp của DDH Electronics (địa chỉ 235 Hoàng Quốc Việt, Cầu Giấy, Hà Nội). 
            Nhiệm vụ của bạn là tư vấn cho khách hàng về linh kiện máy tính, bàn phím cơ, chuột gaming, màn hình. 
            Hãy trả lời lịch sự, ngắn gọn (dưới 150 từ), sử dụng tiếng Việt tự nhiên. 
            Sử dụng dữ liệu sản phẩm dưới đây ĐỂ TRẢ LỜI CỤ THỂ về giá và mẫu mã:" . $productContext;

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->post("https://api.groq.com/openai/v1/chat/completions", [
                'model' => $model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage]
                ],
                'temperature' => 0.6, // Giảm temperature để AI bớt "sáng tạo" linh tinh
                'max_tokens' => 800,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? "Xin lỗi, tôi gặp chút trục trặc khi suy nghĩ. Hãy thử lại sau nhé!";
                return response()->json(['reply' => $reply]);
            }

            $error = $response->json();
            $errorMsg = $error['error']['message'] ?? 'Unknown Groq Error';
            Log::error('Groq API Error: ' . $errorMsg);
            
            return response()->json(['reply' => 'Tôi đang bận một chút, bạn thử lại sau giây lát nhé!']);

        } catch (\Exception $e) {
            Log::error('Groq Chat Exception: ' . $e->getMessage());
            return response()->json(['reply' => 'Có lỗi xảy ra khi kết nối với hệ thống AI: ' . $e->getMessage()]);
        }
    }
}
