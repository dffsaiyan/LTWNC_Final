<?php
 
namespace App\Http\Controllers;
 
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'message' => 'required|string|min:5|max:1000',
            'parent_id' => 'nullable|exists:reviews,id',
        ]);
 
        $product = Product::findOrFail($productId);
 
        // If it's a review (has rating), check if user has bought it
        if ($request->rating) {
            $hasBought = Order::where('user_id', Auth::id())
                ->where('status', 'completed')
                ->whereHas('items', function($q) use ($productId) {
                    $q->where('product_id', $productId);
                })->exists();
 
            if (!$hasBought) {
                return redirect()->back()->with('error', 'Bạn chỉ có thể đánh giá (chấm sao) sản phẩm sau khi đã nhận hàng thành công!');
            }

            // Check if already rated
            $alreadyRated = Review::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->whereNotNull('rating')
                ->exists();
            
            if ($alreadyRated) {
                return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi. Bạn chỉ có thể gửi thêm bình luận hỏi đáp.');
            }
        }
 
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $request->rating,
            'message' => $request->message,
            'parent_id' => $request->parent_id,
        ]);
 
        $msg = $request->rating ? 'Cảm ơn bạn đã gửi đánh giá!' : 'Cảm ơn bạn đã gửi bình luận/câu hỏi!';
        return redirect()->back()->with('success', $msg);
    }
 
    public function reply(Request $request, $reviewId)
    {
        $request->validate([
            'message' => 'required|string|min:2|max:1000',
        ]);
 
        $parentReview = Review::findOrFail($reviewId);

        if (!Auth::user()->is_admin) {
            return redirect()->back()->with('error', 'Chỉ quản trị viên mới có quyền phản hồi đánh giá.');
        }
 
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $parentReview->product_id,
            'message' => $request->message,
            'parent_id' => $reviewId,
        ]);
 
        return redirect()->back()->with('success', 'Đã gửi phản hồi thành công!');
    }
}
