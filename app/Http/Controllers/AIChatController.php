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

        // Reset lịch sử chat nếu người dùng yêu cầu
        $resetKeywords = ['reset', 'bắt đầu lại', 'xóa lịch sử', 'clear chat'];
        $shouldReset = false;
        foreach ($resetKeywords as $rk) {
            if (mb_strtolower(trim($userMessage)) === $rk) {
                $shouldReset = true;
                break;
            }
        }
        if ($shouldReset) {
            session()->forget('ai_chat_history');
            return response()->json(['reply' => 'Tôi đã làm mới cuộc hội thoại. Tôi có thể giúp gì cho bạn?']);
        }

        try {
            // 0. KIỂM TRA XEM TIN NHẮN CÓ CHỨA LINK SẢN PHẨM KHÔNG
            $urlProduct = null;
            if (preg_match('/product\/([a-zA-Z0-9\-_]+)/', $userMessage, $matches)) {
                $slug = $matches[1];
                $urlProduct = \App\Models\Product::where('slug', $slug)
                    ->where('is_active', true)
                    ->first();
            }

            // 1. TÌM KIẾM SẢN PHẨM TRONG DATABASE DỰA TRÊN TIN NHẮN
            // Loại bỏ các từ vô nghĩa để tìm kiếm chính xác hơn
            $stopWords = ['có', 'loại', 'nào', 'giá', 'bao', 'nhiêu', 'của', 'với', 'cho', 'mẫu', 'ấy', 'này', 'đó'];
            $cleanMessage = str_replace(['?', '!', '.', ','], '', $userMessage);
            $rawWords = explode(' ', $cleanMessage);
            
            // Giảm độ dài tối thiểu từ > 2 xuống >= 2 để hỗ trợ các hãng như HP, LG
            $keywords = array_filter($rawWords, function($word) use ($stopWords) {
                return mb_strlen($word) >= 2 && !in_array(mb_strtolower($word), $stopWords);
            });

            $relatedProducts = collect();

            if (empty($keywords) && !$urlProduct) {
                // Nếu không có từ khóa và không có link, lấy mặc định 8 sản phẩm
                $relatedProducts = \App\Models\Product::where('is_active', true)
                    ->limit(8)
                    ->get(['id', 'name', 'price', 'sale_price', 'slug', 'stock']);
            } else {
                $query = \App\Models\Product::where('is_active', true);
                
                if (!empty($keywords)) {
                    $query->where(function($q) use ($keywords) {
                        foreach ($keywords as $word) {
                            $q->orWhere('name', 'like', "%{$word}%")
                              ->orWhere('description', 'like', "%{$word}%");
                        }
                    });
                }
                
                // Lấy ra tối đa 40 sản phẩm để tính điểm độ tương quan ở PHP
                $potentialProducts = $query->limit(40)->get(['id', 'name', 'price', 'sale_price', 'slug', 'stock', 'description']);
                
                $commonGearWords = [
                    'bàn', 'phím', 'chuột', 'màn', 'hình', 'tai', 'nghe', 'lót', 'ghế', 
                    'tay', 'cơ', 'gaming', 'gear', 'led', 'không', 'dây', 'cáp', 'sạc'
                ];
                
                $scoredProducts = [];
                foreach ($potentialProducts as $p) {
                    if ($urlProduct && $urlProduct->id === $p->id) {
                        $score = 1000;
                    } else {
                        $score = 0;
                        $nameLower = mb_strtolower($p->name);
                        $descLower = mb_strtolower($p->description ?? '');
                        
                        foreach ($keywords as $word) {
                            $wordLower = mb_strtolower($word);
                            $isCommon = in_array($wordLower, $commonGearWords);
                            
                            // Tìm kiếm trong tên
                            if (strpos($nameLower, $wordLower) !== false) {
                                $score += $isCommon ? 5 : 30;
                            }
                            // Tìm kiếm trong mô tả
                            if (strpos($descLower, $wordLower) !== false) {
                                $score += $isCommon ? 1 : 5;
                            }
                        }
                    }
                    
                    $p->search_score = $score;
                    $scoredProducts[] = $p;
                }
                
                // Nếu sản phẩm từ URL chưa có trong danh sách thì tự thêm vào
                if ($urlProduct && !collect($scoredProducts)->contains('id', $urlProduct->id)) {
                    $urlProduct->search_score = 1000;
                    $scoredProducts[] = $urlProduct;
                }
                
                // Sắp xếp giảm dần theo điểm độ tương quan
                usort($scoredProducts, function($a, $b) {
                    return $b->search_score <=> $a->search_score;
                });
                
                // Chỉ giữ lại các sản phẩm có điểm tương quan lớn hơn 0 (hoặc nếu là urlProduct) và lấy tối đa 8 cái
                $relatedProducts = collect($scoredProducts)->filter(function($p) {
                    return $p->search_score > 0;
                })->take(8);
            }

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

            // Lấy lịch sử chat từ Session (tối đa 5 lượt chat = 10 tin nhắn gần nhất)
            $history = session()->get('ai_chat_history', []);
            
            // Xây dựng danh sách tin nhắn gửi lên API
            $messages = [];
            $messages[] = ['role' => 'system', 'content' => $systemPrompt];
            
            foreach ($history as $msg) {
                $messages[] = [
                    'role' => $msg['role'],
                    'content' => $msg['content']
                ];
            }
            
            $messages[] = ['role' => 'user', 'content' => $userMessage];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->post("https://api.groq.com/openai/v1/chat/completions", [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.6, // Giảm temperature để AI bớt "sáng tạo" linh tinh
                'max_tokens' => 800,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? "Xin lỗi, tôi gặp chút trục trặc khi suy nghĩ. Hãy thử lại sau nhé!";
                
                // Lưu lượt chat hiện tại vào Session history
                $history[] = ['role' => 'user', 'content' => $userMessage];
                $history[] = ['role' => 'assistant', 'content' => $reply];
                
                if (count($history) > 10) {
                    $history = array_slice($history, -10);
                }
                session()->put('ai_chat_history', $history);

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
