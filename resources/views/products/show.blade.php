@extends('layouts.app')

@section('title', $product->name . ' - Chi tiết sản phẩm')

@section('content')
<div class="container py-5">
    <!-- BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-transparent p-0 mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Trang chủ</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('categories.show', $product->category->slug) }}" class="text-decoration-none text-muted">
                    {{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-4 g-lg-5">
        <!-- ===== CỘT ẢNH SẢN PHẨM ===== -->
        <div class="col-md-6">
            <div class="pdp-img-card bg-white rounded-4 shadow-sm p-4 text-center border-0 position-relative overflow-hidden">
                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                <div class="position-absolute top-0 start-0 m-3 z-3">
                    <span class="pdp-sale-badge">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                </div>
                @endif

                <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/600x500/f8f9fa/666666?text=' . urlencode($product->name) }}" 
                     class="img-fluid pdp-main-img d-block mx-auto" 
                     id="mainImage"
                     alt="{{ $product->name }}"
                     style="max-height: 450px; object-fit: contain;">
            </div>
            
            <!-- ===== THUMBNAILS GALLERY ===== -->
            <div class="d-flex gap-2 mt-3 justify-content-center flex-wrap">
                <!-- Ảnh chính luôn là thumb đầu tiên -->
                <div class="pdp-thumb active" onclick="changeImage('{{ asset($product->image) }}', this)">
                    <img src="{{ asset($product->image) }}" class="img-fluid rounded-3" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                
                <!-- Hiển thị toàn bộ ảnh bổ sung -->
                @foreach($product->images as $img)
                    <div class="pdp-thumb" onclick="changeImage('{{ asset($img->image) }}', this)">
                        <img src="{{ asset($img->image) }}" class="img-fluid rounded-3" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ===== CỘT THÔNG TIN SẢN PHẨM ===== -->
        <div class="col-md-6">
            <div class="ps-md-3">
                <!-- Badge + Brand -->
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="pdp-badge-brand">{{ $product->brand ?? 'Elite Gear' }}</span>
                    <span class="pdp-badge-auth"><i class="fas fa-check-circle me-1"></i> Chính hãng</span>
                </div>

                <!-- Tên SP -->
                <h1 class="fw-bold mb-3" style="font-size: 28px; line-height: 1.3;">{{ $product->name }}</h1>
                
                <!-- Giá -->
                <div class="pdp-price-box mb-4 p-3 rounded-4">
                    @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                        <div class="d-flex align-items-end gap-3">
                            <span class="pdp-price-sale">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                            <span class="pdp-price-old">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                        </div>
                        <div class="pdp-savings mt-2">
                            <i class="fas fa-fire me-1"></i> Tiết kiệm {{ number_format($product->price - $product->sale_price, 0, ',', '.') }} VNĐ
                        </div>
                    @else
                        <span class="pdp-price-sale">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                    @endif
                </div>

                <!-- Mô tả -->
                <div class="pdp-desc-card rounded-4 mb-4 p-4">
                    <h6 class="fw-bold mb-2 text-dark"><i class="fas fa-star text-warning me-2"></i>Đặc điểm nổi bật</h6>
                    <p class="text-muted mb-0" style="line-height: 1.8;">{{ $product->description }}</p>
                </div>

                <!-- Trạng thái -->
                <div class="mb-4 d-flex align-items-center gap-2">
                    @if($product->stock > 0)
                        <span class="pdp-stock-dot bg-success"></span>
                        <span class="fw-bold text-dark small">Còn hàng <span class="text-success">({{ $product->stock }} sản phẩm)</span></span>
                    @else
                        <span class="pdp-stock-dot bg-danger"></span>
                        <span class="fw-bold text-danger small">Hết hàng</span>
                    @endif
                </div>

                <!-- Nút hành động -->
                <div class="d-flex gap-3 mt-4 mb-4">
                    <a href="javascript:void(0)" onclick="addToCartPDP(event, '{{ route('cart.add', $product->id) }}', true)" class="btn pdp-btn-buy flex-grow-1 d-flex align-items-center justify-content-center">
                        <i class="fas fa-shopping-bag me-2"></i> MUA NGAY
                    </a>
                    <a href="javascript:void(0)" onclick="addToCartPDP(event, '{{ route('cart.add', $product->id) }}')" class="btn pdp-btn-cart">
                        <i class="fas fa-cart-plus"></i>
                    </a>
                    <button class="btn pdp-btn-wish {{ Auth::check() && Auth::user()->wishlists()->where('product_id', $product->id)->exists() ? 'active' : '' }}" 
                            id="btnWishlist" 
                            onclick="toggleWishlist(event, '{{ $product->id }}', '{{ route('wishlist.toggle', $product->id) }}')">
                        <i class="fas fa-heart"></i>
                    </button>
                </div>

                <!-- Chính sách -->
                <div class="pdp-policy-box rounded-4 p-4 mt-4">
                    <div class="row text-center g-3">
                        <div class="col-4">
                            <div class="pdp-policy-icon mx-auto mb-2"><i class="fas fa-truck"></i></div>
                            <p class="small fw-bold text-dark mb-0">Giao hàng nhanh</p>
                            <span class="text-muted" style="font-size: 10px;">Nội thành 2h</span>
                        </div>
                        <div class="col-4">
                            <div class="pdp-policy-icon mx-auto mb-2"><i class="fas fa-shield-alt"></i></div>
                            <p class="small fw-bold text-dark mb-0">Bảo hành 12T</p>
                            <span class="text-muted" style="font-size: 10px;">Chính hãng</span>
                        </div>
                        <div class="col-4">
                            <div class="pdp-policy-icon mx-auto mb-2"><i class="fas fa-undo"></i></div>
                            <p class="small fw-bold text-dark mb-0">Đổi trả 7 ngày</p>
                            <span class="text-muted" style="font-size: 10px;">Lỗi là đổi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== THÔNG SỐ KỸ THUẬT & FAQ ===== -->
    <div class="row mt-5 pt-lg-4 g-lg-4 align-items-stretch">
        <!-- Thông số kỹ thuật -->
        <div class="col-lg-7">
            <div class="d-flex flex-column h-100">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-3">
                    <span class="pdp-section-accent"></span> Thông số kỹ thuật
                </h5>
                <div class="bg-white rounded-4 shadow-sm overflow-hidden border flex-grow-1">
                    <table class="table table-hover mb-0 pdp-spec-table h-100">
                        <tbody>
                            @if($product->specifications && count($product->specifications) > 0)
                                @foreach($product->specifications as $key => $value)
                                    <tr>
                                        <td class="bg-light fw-bold text-dark py-3 ps-4" style="width: 35%;">{{ $key }}</td>
                                        <td class="py-3 ps-4 text-muted small">{{ $value }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="py-5 text-center text-muted small" colspan="2">Thông số kỹ thuật đang được cập nhật...</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- FAQ Accordion -->
        <div class="col-lg-5 mt-5 mt-lg-0">
            <div class="d-flex flex-column h-100">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-3">
                    <span class="pdp-section-accent"></span> Câu hỏi thường gặp
                </h5>
                <div class="bg-white rounded-4 shadow-sm border flex-grow-1 overflow-hidden">
                    <div class="accordion accordion-flush pdp-faq-accordion" id="pdpFaq">
                        @if($product->faqs && count($product->faqs) > 0)
                            @php $i = 0; @endphp
                            @foreach($product->faqs as $question => $answer)
                                <div class="accordion-item {{ $loop->last ? 'border-0' : 'border-bottom' }}">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button {{ $i==0 ? '' : 'collapsed' }} fw-bold py-3-5 px-4" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $i }}">
                                            {{ $question }}
                                        </button>
                                    </h2>
                                    <div id="faq-{{ $i }}" class="accordion-collapse collapse {{ $i==0 ? 'show' : '' }}" data-bs-parent="#pdpFaq">
                                        <div class="accordion-body text-muted small py-3 px-4" style="line-height: 1.6;">
                                            {{ $answer }}
                                        </div>
                                    </div>
                                </div>
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <div class="p-5 text-center text-muted small">Câu hỏi thường gặp đang được cập nhật...</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== BÌNH LUẬN & ĐÁNH GIÁ ===== -->
    <div class="mt-5 pt-lg-4">
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-3">
                        <span class="pdp-section-accent"></span> Bình luận & Đánh giá ({{ $product->reviews->count() }})
                    </h5>
                </div>

                <div class="bg-white rounded-4 shadow-sm border p-4 p-md-5">
                    <!-- Form gửi bình luận / đánh giá -->
                    @auth
                        <div class="mb-5 pb-5 border-bottom">
                            <h6 class="fw-bold mb-4 text-dark">
                                <i class="fas fa-pen-nib me-2 text-primary"></i>
                                {{ $canReview ? 'Viết đánh giá của bạn' : 'Hỏi đáp về sản phẩm' }}
                            </h6>
                            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                                @csrf
                                @if($canReview)
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-dark">Chất lượng sản phẩm</label>
                                        <div class="rating-input d-flex gap-2">
                                            @for($i=1; $i<=5; $i++)
                                                <input type="radio" name="rating" id="star{{ $i }}" value="{{ $i }}" class="d-none" {{ $i==5 ? 'checked' : '' }}>
                                                <label for="star{{ $i }}" class="star-label cursor-pointer" onclick="updateStars({{ $i }})">
                                                    <i class="fas fa-star fs-4 {{ $i<=5 ? 'text-warning' : 'text-lighter' }}" id="star-icon-{{ $i }}"></i>
                                                </label>
                                            @endfor
                                        </div>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <textarea name="message" class="form-control bg-light border-0 rounded-4 p-3 @error('message') is-invalid @enderror" rows="3" placeholder="{{ $canReview ? 'Chia sẻ cảm nhận của bạn về sản phẩm này...' : 'Nhập câu hỏi hoặc bình luận của bạn...' }}" required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback px-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">
                                        {{ $canReview ? 'Gửi đánh giá' : 'Gửi bình luận' }} <i class="fas fa-paper-plane ms-1"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-light rounded-4 p-4 text-center mb-5 border border-info border-opacity-10">
                            <p class="text-muted small mb-3">Vui lòng đăng nhập để đặt câu hỏi hoặc gửi đánh giá.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary rounded-pill px-5 btn-sm fw-bold shadow-sm">Đăng nhập ngay</a>
                        </div>
                    @endauth

                    <!-- Tab Headers -->
                    <ul class="nav nav-tabs border-0 mb-4 gap-2" id="reviewTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active rounded-pill px-4 fw-bold small border-0" id="ratings-tab" data-bs-toggle="tab" data-bs-target="#ratings-pane" type="button" role="tab">
                                Đánh giá ({{ $product->reviews->whereNotNull('rating')->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill px-4 fw-bold small border-0" id="comments-tab" data-bs-toggle="tab" data-bs-target="#comments-pane" type="button" role="tab">
                                Hỏi đáp ({{ $product->reviews->whereNull('rating')->count() }})
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="reviewTabsContent">
                        <!-- Ratings Pane -->
                        <div class="tab-pane fade show active" id="ratings-pane" role="tabpanel" tabindex="0">
                            <div class="review-list">
                                @php $ratings = $product->reviews->whereNotNull('rating'); @endphp
                                @if($ratings->count() > 0)
                                    @foreach($ratings as $review)
                                        <div class="review-item {{ !$loop->last ? 'mb-5 pb-4 border-bottom' : '' }}">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="avatar-circle shadow-sm" style="width: 48px; height: 48px; min-width: 48px; background: #f8fafc; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 2px solid white;">
                                                    @if($review->user->avatar)
                                                        <img src="{{ asset($review->user->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @elseif($review->user->social_avatar)
                                                        <img src="{{ $review->user->social_avatar }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary text-white w-100 h-100 d-flex align-items-center justify-content-center fw-bold">{{ mb_substr($review->user->name, 0, 1) }}</div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <div>
                                                            <span class="fw-bold text-dark small me-2">{{ str_replace('+', ' ', $review->user->name) }}</span>
                                                        </div>
                                                        <span class="text-muted review-time fw-medium text-nowrap ms-2">{{ $review->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    
                                                    <div class="text-warning mb-2" style="font-size: 10px;">
                                                        @for($i=1; $i<=5; $i++)
                                                            <i class="fas fa-star {{ $i <= $review->rating ? '' : 'opacity-25' }}"></i>
                                                        @endfor
                                                    </div>
                                                    
                                                    <p class="text-dark mb-2 small lh-lg" style="white-space: pre-line;">{{ $review->message }}</p>
                                                    
                                                    @auth
                                                        @if(auth()->user()->is_admin)
                                                            <button class="btn btn-link p-0 text-primary text-decoration-none xx-small fw-bold" onclick="toggleReplyForm({{ $review->id }})">
                                                                <i class="fas fa-reply me-1"></i> Trả lời
                                                            </button>
                                                            <div id="reply-form-{{ $review->id }}" class="mt-3 d-none animate__animated animate__fadeIn">
                                                                <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="input-group">
                                                                        <input type="text" name="message" class="form-control form-control-sm border-0 bg-light rounded-start-pill px-3" placeholder="Nhập phản hồi của bạn..." required>
                                                                        <button class="btn btn-primary btn-sm rounded-end-pill px-3 fw-bold" type="submit">Gửi</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>

                                            @if($review->replies->count() > 0)
                                                <div class="replies-container mt-4 ms-5 border-start ps-4">
                                                    @foreach($review->replies as $reply)
                                                        <div class="reply-item mb-3">
                                                            <div class="d-flex align-items-start gap-3">
                                                                <div class="avatar-circle shadow-sm" style="width: 32px; height: 32px; min-width: 32px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                                    @if($reply->user->avatar)
                                                                        <img src="{{ asset($reply->user->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    @elseif($reply->user->social_avatar)
                                                                        <img src="{{ $reply->user->social_avatar }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    @else
                                                                        <div class="bg-secondary text-white w-100 h-100 d-flex align-items-center justify-content-center xx-small fw-bold">{{ mb_substr($reply->user->name, 0, 1) }}</div>
                                                                    @endif
                                                                </div>
                                                                <div class="bg-light p-3 rounded-4 flex-grow-1 border">
                                                                    <div class="d-flex justify-content-between mb-1 gap-2">
                                                                        <span class="fw-bold text-dark x-small">{{ str_replace('+', ' ', $reply->user->name) }} @if($reply->user->is_admin) <i class="fas fa-check-circle text-primary ms-1"></i> @endif</span>
                                                                        <span class="text-muted review-time text-nowrap">{{ $reply->created_at->diffForHumans() }}</span>
                                                                    </div>
                                                                    <p class="text-muted mb-0 small lh-sm">{{ $reply->message }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-5">
                                        <i class="far fa-star text-light fs-1 mb-3"></i>
                                        <p class="text-muted small">Sản phẩm này chưa có đánh giá sao nào.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Comments Pane -->
                        <div class="tab-pane fade" id="comments-pane" role="tabpanel" tabindex="0">
                            <div class="review-list">
                                @php $comments = $product->reviews->whereNull('rating'); @endphp
                                @if($comments->count() > 0)
                                    @foreach($comments as $review)
                                        <div class="review-item {{ !$loop->last ? 'mb-5 pb-4 border-bottom' : '' }}">
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="avatar-circle shadow-sm" style="width: 48px; height: 48px; min-width: 48px; background: #f8fafc; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 2px solid white;">
                                                    @if($review->user->avatar)
                                                        <img src="{{ asset($review->user->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @elseif($review->user->social_avatar)
                                                        <img src="{{ $review->user->social_avatar }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                    @else
                                                        <div class="bg-primary text-white w-100 h-100 d-flex align-items-center justify-content-center fw-bold">{{ mb_substr($review->user->name, 0, 1) }}</div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                        <div>
                                                            <span class="fw-bold text-dark small me-2">{{ str_replace('+', ' ', $review->user->name) }}</span>
                                                        </div>
                                                        <span class="text-muted review-time fw-medium text-nowrap ms-2">{{ $review->created_at->diffForHumans() }}</span>
                                                    </div>
                                                    
                                                    <p class="text-dark mb-2 small lh-lg" style="white-space: pre-line;">{{ $review->message }}</p>
                                                    
                                                    @auth
                                                        @if(auth()->user()->is_admin)
                                                            <button class="btn btn-link p-0 text-primary text-decoration-none xx-small fw-bold" onclick="toggleReplyForm({{ $review->id }})">
                                                                <i class="fas fa-reply me-1"></i> Trả lời
                                                            </button>
                                                            <div id="reply-form-{{ $review->id }}" class="mt-3 d-none animate__animated animate__fadeIn">
                                                                <form action="{{ route('reviews.reply', $review->id) }}" method="POST">
                                                                    @csrf
                                                                    <div class="input-group">
                                                                        <input type="text" name="message" class="form-control form-control-sm border-0 bg-light rounded-start-pill px-3" placeholder="Nhập phản hồi của bạn..." required>
                                                                        <button class="btn btn-primary btn-sm rounded-end-pill px-3 fw-bold" type="submit">Gửi</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @endauth
                                                </div>
                                            </div>

                                            @if($review->replies->count() > 0)
                                                <div class="replies-container mt-4 ms-5 border-start ps-4">
                                                    @foreach($review->replies as $reply)
                                                        <div class="reply-item mb-3">
                                                            <div class="d-flex align-items-start gap-3">
                                                                <div class="avatar-circle shadow-sm" style="width: 32px; height: 32px; min-width: 32px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                                                                    @if($reply->user->avatar)
                                                                        <img src="{{ asset($reply->user->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    @elseif($reply->user->social_avatar)
                                                                        <img src="{{ $reply->user->social_avatar }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                                    @else
                                                                        <div class="bg-secondary text-white w-100 h-100 d-flex align-items-center justify-content-center xx-small fw-bold">{{ mb_substr($reply->user->name, 0, 1) }}</div>
                                                                    @endif
                                                                </div>
                                                                <div class="bg-light p-3 rounded-4 flex-grow-1 border">
                                                                    <div class="d-flex justify-content-between mb-1 gap-2">
                                                                        <span class="fw-bold text-dark x-small">{{ str_replace('+', ' ', $reply->user->name) }} @if($reply->user->is_admin) <i class="fas fa-check-circle text-primary ms-1"></i> @endif</span>
                                                                        <span class="text-muted review-time text-nowrap">{{ $reply->created_at->diffForHumans() }}</span>
                                                                    </div>
                                                                    <p class="text-muted mb-0 small lh-sm">{{ $reply->message }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="text-center py-5">
                                        <i class="far fa-comments text-light fs-1 mb-3"></i>
                                        <p class="text-muted small">Sản phẩm này chưa có bình luận hỏi đáp nào.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Widget bổ sung (tùy chọn) -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden border">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-4">Đánh giá trung bình</h6>
                        <div class="text-center py-3">
                            <div class="display-4 fw-bold text-dark mb-2">
                                {{ $product->reviews->whereNotNull('rating')->count() > 0 ? number_format($product->reviews->whereNotNull('rating')->avg('rating'), 1) : '5.0' }}
                            </div>
                            <div class="text-warning fs-5 mb-2">
                                @php $avg = $product->reviews->whereNotNull('rating')->avg('rating') ?: 5; @endphp
                                @for($i=1; $i<=5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($avg) ? '' : 'opacity-25' }}"></i>
                                @endfor
                            </div>
                            <p class="text-muted small mb-0">Dựa trên {{ $product->reviews->whereNotNull('rating')->count() }} lượt đánh giá thực tế</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CÓ THỂ BẠN CŨNG THÍCH ===== -->
    <div class="mt-5 pt-lg-5">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="fw-bold mb-0 d-flex align-items-center gap-3">
                <span class="pdp-section-accent"></span> Có thể bạn cũng thích
            </h4>
        </div>

        <div class="row g-3 g-md-4">
            @foreach($relatedProducts as $rel)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white pdp-rel-card overflow-hidden">
                    <a href="{{ route('products.show', $rel->slug) }}" class="p-3 d-block text-center position-relative">
                        <img src="{{ $rel->image ? asset($rel->image) : 'https://via.placeholder.com/300x300' }}" class="img-fluid rounded-3 d-block mx-auto" alt="{{ $rel->name }}" style="height: 180px; object-fit: contain;">
                        @if($rel->price > $rel->sale_price && $rel->sale_price > 0)
                            <span class="position-absolute top-0 start-0 m-2 badge bg-danger rounded-pill small">-{{ round((($rel->price - $rel->sale_price) / $rel->price) * 100) }}%</span>
                        @endif
                    </a>
                    <div class="card-body p-3 pt-0 d-flex flex-column">
                        <h6 class="fw-bold text-dark mb-2 text-truncate-2 small" style="min-height: 40px; line-height: 1.5;">{{ $rel->name }}</h6>
                        <div class="mt-auto">
                            <div class="d-flex align-items-end gap-2 mb-3">
                                @if($rel->is_flash_sale && (float)$rel->sale_price > 0 && $rel->sale_price < $rel->price)
                                    <span class="fw-bold text-orange-gradient" style="font-size: 16px;">{{ number_format($rel->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through" style="font-size: 12px; opacity: 0.6;">{{ number_format($rel->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="fw-bold text-orange-gradient" style="font-size: 16px;">{{ number_format($rel->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex gap-2">
                                <a href="javascript:void(0)" onclick="addToCartPDP(event, '{{ route('cart.add', $rel->id) }}', true)" class="btn btn-warning rounded-pill py-2 px-3 small fw-bold flex-grow-1" style="font-size: 11px;">MUA NGAY</a>
                                <a href="javascript:void(0)" onclick="addToCartPDP(event, '{{ route('cart.add', $rel->id) }}')" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;"><i class="fas fa-cart-plus" style="font-size: 12px;"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- ===== SCOPED CSS ===== -->
<style>
    .pdp-rel-card {
        transition: all 0.3s ease;
        border: 1px solid transparent !important;
    }
    .pdp-rel-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
        border-color: #fff7ed !important;
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .pdp-section-accent {
        width: 8px;
        height: 22px;
        background: #f97316;
        border-radius: 50px;
        display: inline-block;
    }
    .pdp-spec-table tr td {
        border-bottom: 1px solid #f1f5f9;
    }
    .pdp-spec-table tr:last-child td {
        border-bottom: none;
    }

    .pdp-faq-accordion .accordion-button {
        background: white;
        color: #0f172a;
        box-shadow: none;
        font-size: 13px;
    }
    .pdp-faq-accordion .accordion-button:not(.collapsed) {
        background: #fff7ed;
        color: #f97316;
        border-bottom: 1px solid #fed7aa;
    }
    .pdp-faq-accordion .accordion-button::after {
        background-size: 15px;
        opacity: 0.5;
    }
    .pdp-faq-accordion .accordion-button:not(.collapsed)::after {
        filter: invert(53%) sepia(93%) saturate(1476%) hue-rotate(345deg) brightness(101%) contrast(105%);
    }

    /* IMAGE CARD */
    .pdp-img-card {
        transition: box-shadow 0.4s ease;
    }
    .pdp-img-card:hover {
        box-shadow: 0 15px 40px rgba(0,0,0,0.08) !important;
    }
    .pdp-main-img {
        transition: transform 0.5s ease;
    }
    .pdp-img-card:hover .pdp-main-img {
        transform: scale(1.03);
    }

    /* SALE BADGE */
    .pdp-sale-badge {
        background: #ef4444;
        color: white;
        font-weight: 900;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 13px;
        box-shadow: 0 5px 15px rgba(239, 68, 68, 0.25);
    }

    /* THUMBNAILS */
    .pdp-thumb {
        width: 70px;
        height: 70px;
        padding: 8px;
        border: 2px solid #f1f5f9;
        border-radius: 14px;
        background: white;
        cursor: pointer;
        opacity: 0.6;
        transition: all 0.3s ease;
    }
    .pdp-thumb:hover, .pdp-thumb.active {
        opacity: 1;
        border-color: #f97316;
        box-shadow: 0 5px 15px rgba(249, 115, 22, 0.1);
    }

    /* BADGES */
    .pdp-badge-brand {
        background: #0f172a;
        color: white;
        font-weight: 800;
        text-transform: uppercase;
        font-size: 10px;
        padding: 4px 12px;
        border-radius: 50px;
        letter-spacing: 1px;
    }
    .pdp-badge-auth {
        background: #ecfdf5;
        color: #059669;
        font-weight: 700;
        font-size: 11px;
        padding: 4px 10px;
        border-radius: 50px;
    }

    /* PRICE */
    .pdp-price-box {
        background: linear-gradient(135deg, #fff7ed, #fff1f2);
        border: 1px solid #fed7aa;
    }
    .pdp-price-sale {
        font-size: 32px;
        font-weight: 900;
        color: #ea580c;
    }
    .pdp-price-old {
        font-size: 18px;
        color: #94a3b8;
        text-decoration: line-through;
    }
    .pdp-savings {
        background: #ecfdf5;
        color: #059669;
        font-weight: 800;
        font-size: 11px;
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-block;
        border: 1px solid #d1fae5;
    }

    /* DESCRIPTION */
    .pdp-desc-card {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
    }

    /* STOCK DOT */
    .pdp-stock-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        display: inline-block;
        position: relative;
    }
    .pdp-stock-dot::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: inherit;
        border-radius: 50%;
        animation: pdpPulse 2s infinite;
    }
    @keyframes pdpPulse {
        0% { transform: scale(1); opacity: 0.7; }
        100% { transform: scale(2.5); opacity: 0; }
    }

    /* BUTTONS */
    .pdp-btn-buy {
        background: linear-gradient(135deg, #f97316, #ef4444);
        color: white !important;
        border: none;
        border-radius: 16px;
        padding: 16px 30px;
        font-weight: 900;
        font-size: 15px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.2);
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pdp-btn-buy:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(239, 68, 68, 0.3);
        filter: brightness(1.05);
    }
    .pdp-btn-cart {
        background: #0f172a;
        color: white !important;
        border: none;
        border-radius: 16px;
        padding: 16px 20px;
        font-size: 18px;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .pdp-btn-cart:hover {
        background: #000;
        transform: scale(1.05);
    }
    .pdp-btn-wish {
        background: white;
        color: #94a3b8 !important;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        padding: 16px 20px;
        font-size: 18px;
        transition: all 0.3s ease;
    }
    .pdp-btn-wish:hover {
        color: #ef4444 !important;
        border-color: #fecaca;
        background: #fff5f5;
    }
    .pdp-btn-wish.active {
        background: #fff5f5;
        color: #ef4444 !important;
        border-color: #fecaca;
        animation: heartPulseElite 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    @keyframes heartPulseElite {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }

    /* POLICY */
    .pdp-policy-box {
        background: white;
        border: 1px solid #f1f5f9;
        box-shadow: 0 5px 20px rgba(0,0,0,0.02);
    }
    .pdp-policy-icon {
        width: 42px;
        height: 42px;
        background: #fff7ed;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #f97316;
        font-size: 18px;
    }

    /* TOAST */
    .pdp-toast {
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #0f172a;
        color: white;
        padding: 15px 25px;
        border-radius: 15px;
        box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        z-index: 9999;
        transition: opacity 0.5s ease;
        border-left: 5px solid #f97316;
        animation: pdpSlideUp 0.3s ease-out;
    }
    @keyframes pdpSlideUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* RESPONSIVE OPTIMIZATIONS */
    @media (max-width: 991px) {
        .pdp-main-img { max-height: 350px !important; }
        .pdp-price-sale { font-size: 28px; }
        .pdp-btn-buy { padding: 14px 20px; font-size: 14px; }
    }

    @media (max-width: 767px) {
        .container { padding-left: 20px; padding-right: 20px; }
        .pdp-img-card { padding: 20px !important; }
        .pdp-main-img { max-height: 280px !important; }
        h1 { font-size: 22px !important; margin-top: 15px; }
        .pdp-price-sale { font-size: 24px; }
        .pdp-price-old { font-size: 15px; }
        .pdp-desc-card { padding: 15px !important; }
        .pdp-btn-buy { font-size: 13px; border-radius: 12px; }
        .pdp-btn-cart, .pdp-btn-wish { border-radius: 12px; padding: 12px 15px; }
        .pdp-thumb { width: 60px; height: 60px; border-radius: 10px; }
        .pdp-spec-table td:first-child { width: 45% !important; font-size: 12px !important; }
        .pdp-spec-table td:last-child { font-size: 11px !important; }
        
        /* Review Responsive Hooks */
        .review-time { font-size: 8px !important; opacity: 0.8; }
        .replies-container {
            margin-left: 1rem !important; 
            padding-left: 0.75rem !important;
        }
    }

    @media (max-width: 576px) {
        .pdp-main-img { max-height: 220px !important; }
        .pdp-policy-box { padding: 15px !important; }
        .pdp-policy-icon { width: 35px; height: 35px; font-size: 15px; }
        .pdp-policy-box p { font-size: 9px !important; }
        .breadcrumb { font-size: 11px; }
        .pdp-badge-brand, .pdp-badge-auth { font-size: 9px; padding: 3px 10px; }
        .pdp-toast { right: 15px; bottom: 85px; left: 15px; text-align: center; } /* Floating above bottom nav */
    }

    /* REVIEW UTILS */
    .review-time { font-size: 0.85rem; }
    .text-lighter { color: #e2e8f0; }
    .cursor-pointer { cursor: pointer; }
    .star-label:hover i { transform: scale(1.2); transition: transform 0.2s ease; }
    .rating-input label:hover ~ label i { color: #e2e8f0 !important; }

    /* ELITE TABS */
    #reviewTabs .nav-link {
        color: #64748b;
        background: #f1f5f9;
        transition: all 0.3s ease;
    }
    #reviewTabs .nav-link:hover {
        background: #e2e8f0;
        color: #0f172a;
    }
    #reviewTabs .nav-link.active {
        background: #f97316 !important;
        color: white !important;
        box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
    }
</style>


<script>
    function changeImage(src, element) {
        document.getElementById('mainImage').src = src;
        document.querySelectorAll('.pdp-thumb').forEach(t => t.classList.remove('active'));
        element.classList.add('active');
    }

    function addToCartPDP(event, url, redirect = false) {
        event.preventDefault();
        fetch(url, {
            method: 'GET',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                if (redirect) {
                    window.location.href = '/checkout';
                    return;
                }
                const badge = document.getElementById('cartBadgeCount');
                if (badge) {
                    badge.innerText = data.cart_count;
                    badge.style.transform = 'scale(1.5)';
                    setTimeout(() => badge.style.transform = 'scale(1)', 300);
                }
                const cartIcon = document.getElementById('headerCartIcon');
                if (cartIcon) {
                    cartIcon.classList.remove('cart-bounce-elite');
                    void cartIcon.offsetWidth;
                    cartIcon.classList.add('cart-bounce-elite');
                    setTimeout(() => cartIcon.classList.remove('cart-bounce-elite'), 1000);
                }
                let toast = document.createElement('div');
                toast.className = 'pdp-toast';
                toast.innerHTML = '<div class="d-flex align-items-center gap-3"><i class="fas fa-check-circle text-warning fs-5"></i><span class="fw-bold small">' + data.message + '</span></div>';
                document.body.appendChild(toast);
                setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 500); }, 3000);
            }
        });
    }

    function toggleWishlist(event, productId, url) {
        event.preventDefault();
        const btn = document.getElementById('btnWishlist');
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = '{{ route("login") }}';
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data && data.success) {
                const isActive = data.added;
                if (isActive) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }

                let toast = document.createElement('div');
                toast.className = 'pdp-toast';
                toast.innerHTML = `<div class="d-flex align-items-center gap-3">
                    <i class="fas fa-heart ${isActive ? 'text-danger' : 'text-muted'} fs-5"></i>
                    <span class="fw-bold small">${data.message}</span>
                </div>`;
                
                document.body.appendChild(toast);
                setTimeout(() => { 
                    toast.style.opacity = '0'; 
                    setTimeout(() => toast.remove(), 500); 
                }, 3000);
            }
        })
        .catch(error => console.error('Error toggling wishlist:', error));
    }

    function toggleReplyForm(reviewId) {
        const form = document.getElementById(`reply-form-${reviewId}`);
        if(form) {
            form.classList.toggle('d-none');
        }
    }

    function updateStars(rating) {
        for (let i = 1; i <= 5; i++) {
            const icon = document.getElementById('star-icon-' + i);
            if (i <= rating) {
                icon.classList.remove('text-lighter');
                icon.classList.add('text-warning');
            } else {
                icon.classList.remove('text-warning');
                icon.classList.add('text-lighter');
            }
        }
    }
</script>
@endsection
