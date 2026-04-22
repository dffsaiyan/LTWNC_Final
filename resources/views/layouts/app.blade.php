<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="zalo-platform-site-verification" content="VF-O1ep8C1zHrvWZqlTEUZ7RtcJThGixEJ8r" />
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DDH Electronics - Siêu thị máy tính & Gear cao cấp</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/favicon.jpg') }}?v={{ time() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;800&display=swap"
        rel="stylesheet">

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @livewireStyles

    <style>
        :root {
            --primary-blue: #0f172a;
            --accent-orange: #f97316;
            --soft-bg: #f8fafc;
        }

        /* CORE RESET */
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: auto;
            position: relative;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--soft-bg);
            color: var(--primary-blue);
            margin: 0;
            padding: 0;
        }

        /* TOP MARQUEE STABLE */
        .top-marquee-elite {
            background: var(--primary-blue);
            color: white;
            padding: 8px 0;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--accent-orange);
            overflow: hidden;
        }
        .top-marquee-elite .container {
            overflow: hidden;
            position: relative;
        }
        .marquee-content-elite {
            display: flex;
            white-space: nowrap;
            animation: marqueeElite 25s linear infinite;
        }
        .marquee-item-elite {
            padding: 0 50px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        @keyframes marqueeElite {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        /* RESPONSIVE MARQUEE */
        @media (max-width: 991px) {
            .top-marquee-elite { padding: 6px 0; font-size: 11px; letter-spacing: 0.5px; }
            .marquee-item-elite { padding: 0 30px; gap: 8px; }
        }
        @media (max-width: 576px) {
            .top-marquee-elite { padding: 5px 0; font-size: 10px; letter-spacing: 0px; }
            .marquee-item-elite { padding: 0 20px; gap: 6px; }
            .top-marquee-elite .container { border: none !important; }
            .navbar-brand img { height: 45px !important; }
        }

        /* PREMIUM NAVBAR ELITE STYLES */
        .navbar-elite {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            padding: 3px 0; /* Reduced from 10px to make it slim */
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link-elite {
            color: var(--primary-blue) !important;
            font-weight: 700;
            font-size: 13.5px;
            padding: 8px 0 !important;
            width: 140px; /* SLIGHTLY WIDER */
            justify-content: center;
            border: 1px solid transparent;
            border-radius: 12px;
            margin: 0 4px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link-elite i {
            transition: all 0.4s ease;
            font-size: 15px;
        }

        .nav-link-elite:hover {
            color: var(--accent-orange) !important;
            background: rgba(15, 23, 42, 0.03);
            border-color: rgba(15, 23, 42, 0.1);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.06);
        }

        .nav-link-elite:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        /* SEARCH BAR PREMIUM */
        .search-wrapper-elite {
            background: rgba(241, 245, 249, 0.8);
            border: 1px solid rgba(203, 213, 225, 0.5);
            border-radius: 12px;
            padding: 6px 16px;
            transition: all 0.4s ease;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
            display: flex; /* ENSURE FLEX */
            align-items: center;
        }

        /* BOTTOM NAVIGATION BAR (Mobile/Tablet) */
        .bottom-nav-elite {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            display: flex;
            justify-content: space-around;
            align-items: center;
            border-top: 1px solid rgba(0,0,0,0.08);
            z-index: 9995;
            box-shadow: 0 -10px 30px rgba(0,0,0,0.08);
            padding-bottom: env(safe-area-inset-bottom);
        }
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none !important;
            color: #64748b;
            gap: 5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex: 1;
            position: relative;
        }
        .bottom-nav-item i {
            font-size: 20px;
            transition: transform 0.3s ease;
        }
        .bottom-nav-item span {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .bottom-nav-item.active, .bottom-nav-item:hover {
            color: var(--accent-orange);
        }
        .bottom-nav-item:hover i {
            transform: translateY(-5px);
        }

        /* --- PREMIUM DROPDOWN OVERHAUL --- */
        .dropdown-menu-elite {
            border: none !important;
            box-shadow: 0 15px 50px rgba(0,0,0,0.12) !important;
            padding: 12px !important;
            border-radius: 20px !important;
            margin-top: 15px !important;
            animation: dropdownFadeIn 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .dropdown-item-elite {
            border-radius: 12px !important;
            padding: 10px 15px !important;
            font-size: 0.88rem !important;
            font-weight: 600 !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            margin-bottom: 2px !important;
            color: #475569 !important;
            border: 1px solid transparent !important;
        }
        .dropdown-item-elite:hover {
            background: #f1f5f9 !important;
            color: var(--accent-orange) !important;
            transform: translateX(5px);
            border-color: rgba(249, 115, 22, 0.1) !important;
        }
        .dropdown-item-elite i {
            font-size: 1rem;
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        .dropdown-item-elite:hover i {
            opacity: 1;
            transform: scale(1.1) rotate(5deg);
        }

        /* Special buttons in dropdown */
        .btn-dropdown-admin-elite {
            background: #0f172a !important;
            color: rgba(255,255,255,0.95) !important;
            font-size: 11px !important;
            letter-spacing: 1px !important;
            text-transform: uppercase !important;
            border: none !important;
        }
        .btn-dropdown-admin-elite:hover {
            background: #1e293b !important;
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.25) !important;
            transform: translateY(-2px) translateX(0) !important;
            color: #fff !important;
        }
        .btn-dropdown-admin-elite i { color: #fbbf24 !important; opacity: 1 !important; }

        .btn-dropdown-write-elite {
            background: var(--accent-orange) !important;
            color: white !important;
            font-size: 11px !important;
            letter-spacing: 1px !important;
            text-transform: uppercase !important;
            box-shadow: 0 4px 10px rgba(247, 148, 30, 0.2) !important;
            border: none !important;
        }
        .btn-dropdown-write-elite:hover {
            background: #e8850a !important;
            box-shadow: 0 8px 20px rgba(247, 148, 30, 0.35) !important;
            transform: translateY(-2px) translateX(0) !important;
            color: #fff !important;
        }
        .btn-dropdown-write-elite i { opacity: 1 !important; }

        .btn-dropdown-logout-elite {
            color: #ef4444 !important;
        }
        .btn-dropdown-logout-elite:hover {
            background: #fef2f2 !important;
            border-color: rgba(239, 68, 68, 0.1) !important;
        }

        .btn-dropdown-logout-elite:hover {
            background: #fef2f2 !important;
            border-color: rgba(239, 68, 68, 0.1) !important;
        }

        .avatar-bottom-nav {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid white;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        @media (max-width: 991px) {
            .zalo-float { 
                bottom: 85px !important; 
                left: 15px !important; 
                width: 50px !important; 
                height: 50px !important; 
            }
            .ai-chat-float { 
                bottom: 145px !important; 
                left: 15px !important; 
                width: 50px !important; 
                height: 50px !important; 
                font-size: 20px !important;
            }
            .ai-chat-window { 
                bottom: 210px !important; 
                left: 15px !important;
                width: calc(100% - 30px) !important;
                height: 480px !important;
                max-height: 60vh !important;
            }
            .ai-chat-header { padding: 12px 15px !important; }
            .ai-chat-header .rounded-circle { width: 35px !important; height: 35px !important; }
            .ai-chat-body { padding: 15px !important; gap: 10px !important; }
            .ai-msg { font-size: 13px !important; padding: 8px 14px !important; }
            .ai-chat-footer { padding: 12px !important; }
            .ai-chat-footer input { font-size: 13px !important; }
            
            .zalo-pulse, .ai-pulse { transform: scale(0.8); }
            @unless(Route::is('login', 'register', 'password.*'))
            body { padding-bottom: 70px; } /* Space for bottom nav */
            @endunless
        }

        @media (max-width: 768px) {
            .search-wrapper-elite {
                padding: 5px 10px !important;
                margin: 0 5px !important;
                border-radius: 10px !important;
            }
            .search-input-elite {
                font-size: 11px !important;
            }
            .btn-cart-elite {
                padding: 6px 12px !important;
                font-size: 11px !important;
                gap: 5px !important;
                border-radius: 10px !important;
            }
            .btn-cart-elite i {
                font-size: 14px !important;
            }
            .cart-badge-elite {
                font-size: 8px !important;
                padding: 2px 4px !important;
                top: -8px !important;
                right: -6px !important;
            }
            .navbar-logo-elite {
                height: 38px !important;
            }
        }

        .search-wrapper-elite:focus-within {
            background: #fff;
            border-color: var(--accent-orange);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.15);
            max-width: 550px !important;
            transform: scale(1.01);
        }

        .search-input-elite {
            border: none;
            background: transparent;
            outline: none;
            font-size: 13.5px;
            font-weight: 500;
            width: 100%;
            color: var(--primary-blue);
        }

        /* LIVE SEARCH DROPDOWN */
        .search-results-elite {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 16px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.15);
            margin-top: 10px;
            z-index: 10000;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.05);
            display: none;
            max-height: 450px;
            overflow-y: auto;
        }

        .search-result-item-elite {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            gap: 15px;
            text-decoration: none !important;
            color: var(--primary-blue);
            transition: all 0.2s ease;
            border-bottom: 1px solid rgba(0,0,0,0.03);
        }

        .search-result-item-elite:last-child { border-bottom: none; }

        .search-result-item-elite:hover {
            background: #f1f5f9;
            transform: translateX(5px);
        }

        .search-result-img {
            width: 50px;
            height: 50px;
            object-fit: contain;
            background: #fff;
            border-radius: 8px;
            padding: 5px;
            border: 1px solid #f1f5f9;
        }

        .search-result-info {
            flex: 1;
        }

        .search-result-name {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 2px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .search-result-price {
            font-size: 12px;
            font-weight: 800;
            color: var(--accent-orange);
        }

        .search-loading-elite {
            padding: 20px;
            text-align: center;
            color: var(--accent-orange);
            font-size: 13px;
            font-weight: 700;
        }

        .search-empty-elite {
            padding: 30px 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }


        /* LOGIN BUTTON ENHANCED */
        .btn-login-elite {
            background: linear-gradient(135deg, var(--primary-blue), #1e293b);
            color: white !important;
            border: none;
            border-radius: 12px;
            padding: 10px 22px;
            font-weight: 800;
            font-size: 13px;
            letter-spacing: 0.5px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
            text-decoration: none !important;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-login-elite:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.3);
            background: var(--accent-orange);
            color: white !important;
        }

        .btn-login-elite i {
            font-size: 16px;
        }

        /* CART BUTTON ENHANCED */
        .btn-cart-elite {
            background: #fff;
            color: var(--primary-blue) !important;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 12px;
            padding: 9px 18px;
            font-weight: 700;
            font-size: 13.5px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .btn-cart-elite:hover {
            border-color: var(--accent-orange);
            color: var(--accent-orange) !important;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(249, 115, 22, 0.15);
        }

        .btn-cart-elite:hover i {
            animation: cartShake 0.5s ease;
        }

        @keyframes cartShake {
            0% { transform: rotate(0); }
            25% { transform: rotate(-15deg); }
            50% { transform: rotate(15deg); }
            75% { transform: rotate(-15deg); }
            100% { transform: rotate(0); }
        }

        .cart-badge-elite {
            font-size: 9px;
            padding: 3px 5px;
            top: -6px !important;
            right: -8px !important;
            border: 1.5px solid #fff;
        }

        /* CART BOUNCE ANIMATION */
        @keyframes cartBounce {
            0%, 100% { transform: scale(1); }
            20% { transform: scale(1.4) rotate(-10deg); }
            40% { transform: scale(1.2) rotate(10deg); }
            60% { transform: scale(1.3) rotate(-5deg); }
            80% { transform: scale(1.1) rotate(5deg); }
        }
        .cart-bounce-elite {
            animation: cartBounce 0.8s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
            backface-visibility: hidden;
            perspective: 1000px;
        }

        /* SPOTLIGHT SHADOW & OVERLAY */
        #sidebarOverlayElite {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 2001; /* ABOVE FIXED HEADER */
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
        }

        #sidebarOverlayElite.active {
            opacity: 1;
            visibility: visible;
        }

        /* HIGHLIGHT FOR SIDEBAR (HOME PAGE) */
        .sidebar-elite-container.spotlight-active {
            position: relative;
            z-index: 2002 !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4) !important;
            transform: scale(1.03) !important;
            border-color: var(--accent-orange) !important;
        }

        .sidebar-elite-container {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* GLOBAL SPOTLIGHT MENU (1:1 SIDEBAR REPLICA) */
        .spotlight-global-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 2005;
            visibility: hidden;
            pointer-events: none;
            display: flex;
            align-items: flex-start; /* ALIGN TO TOP */
            justify-content: center;
        }

        .spotlight-global-container.active {
            visibility: visible;
            pointer-events: auto;
        }

        .spotlight-card-wrapper {
            position: fixed;
            top: 135px; /* STAY AT SIDEBAR LEVEL */
            left: 50%;
            transform: translateX(-625px); /* OFFSET TO ALIGN WITH CONTAINER LEFT (1250px / 2) */
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            z-index: 2006;
        }

        .spotlight-global-container.active .spotlight-card-wrapper {
            opacity: 1;
            transform: translateX(-625px) translateY(10px);
        }

        /* Responsive cho màn hình nhỏ hơn container */
        @media (max-width: 1300px) {
            .spotlight-card-wrapper {
                left: 20px;
                transform: none;
            }
            .spotlight-global-container.active .spotlight-card-wrapper {
                transform: translateY(10px);
            }
        }

        .spotlight-card-elite {
            width: 260px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            border: 1px solid rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .bg-dark-elite { background: #0f172a !important; }

        .category-item-elite {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px;
            color: #1e293b;
            text-decoration: none !important;
            font-weight: 600;
            font-size: 13.5px;
            transition: all 0.2s ease;
            flex: 1; /* flex-fill behavior */
        }

        .category-item-elite:hover {
            background: #f8fafc;
            color: var(--accent-orange);
            padding-left: 22px;
        }

        .category-item-elite img {
            width: 22px;
            height: 22px;
            object-fit: contain;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }

        .xx-small { font-size: 10px; }
        .fw-black { font-weight: 900; }
        .sale-highlight { background: rgba(239, 68, 68, 0.02); }
        .sale-highlight:hover { background: rgba(239, 68, 68, 0.05); }

        /* ELITE PRODUCT CARD DESIGN */
        .card-product-elite {
            border-radius: 20px !important;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 1px solid rgba(0,0,0,0.03) !important;
            overflow: hidden;
            background: #fff;
        }

        .card-product-elite:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important;
            border-color: var(--primary-blue) !important;
        }

        .product-img-wrapper {
            position: relative;
            overflow: hidden;
            background: #f8fafc;
        }

        .product-img-wrapper img {
            transition: all 0.5s ease;
        }

        .card-product-elite:hover .product-img-wrapper img {
            transform: scale(1.1);
        }

        .product-badge-elite {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--accent-orange);
            color: #fff;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 800;
            z-index: 5;
        }

        .btn-elite-buy {
            background: linear-gradient(135deg, var(--primary-blue), #1e293b);
            color: #fff;
            border: none;
            padding: 10px 0;
            font-weight: 700;
            border-radius: 12px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
        }

        .btn-elite-buy:hover {
            background: var(--accent-orange);
            color: #fff;
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(255, 107, 0, 0.2);
        }

        .btn-elite-secondary {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 8px;
            border-radius: 10px;
            transition: all 0.3s ease;
            flex: 1;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            text-decoration: none !important;
        }

        .btn-elite-secondary:hover {
            background: var(--primary-blue);
            color: #fff;
            text-decoration: none !important;
        }

        .product-price-elite {
            color: var(--accent-orange);
            font-weight: 900;
            font-size: 1.2rem;
            letter-spacing: -0.5px;
        }

        .hover-orange:hover { color: var(--accent-orange) !important; transition: 0.3s; }
        .hover-bg-light:hover { background: #f1f5f9; }

        .btn-orange {
            background: var(--accent-orange);
            color: white !important;
            border: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-orange:hover {
            background: #ea580c;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
            color: white !important;
        }

        /* --- FLASH SALE ELITE CARD --- */
        .card-product-flash {
            border: 2px solid transparent !important;
            position: relative;
            animation: flash-border-pulse 3s infinite;
            overflow: visible !important; /* Allow badge to pop */
        }
        
        @keyframes flash-border-pulse {
            0% { border-color: rgba(249, 115, 22, 0.2); box-shadow: 0 0 10px rgba(249, 115, 22, 0.1); }
            50% { border-color: rgba(249, 115, 22, 0.8); box-shadow: 0 0 25px rgba(249, 115, 22, 0.3); }
            100% { border-color: rgba(249, 115, 22, 0.2); box-shadow: 0 0 10px rgba(249, 115, 22, 0.1); }
        }

        .badge-flash-elite {
            background: linear-gradient(135deg, #f97316, #ef4444);
            color: white;
            font-weight: 900;
            font-size: 11px;
            padding: 5px 12px;
            border-radius: 50px;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
            display: flex;
            align-items: center;
            gap: 6px;
            position: absolute;
            top: -12px;
            left: 15px;
            z-index: 100;
            letter-spacing: 0.5px;
            border: 2px solid #fff;
        }

        .badge-flash-elite i {
            animation: flash-bolt 0.8s infinite alternate;
        }

        @keyframes flash-bolt {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0.7; transform: scale(1.2); }
        }

        .flash-stock-info {
            margin-top: 15px;
        }
        
        .stock-progress-container {
            height: 12px;
            background: #f1f5f9;
            border-radius: 50px;
            overflow: hidden;
            position: relative;
            border: 1px solid #e2e8f0;
        }
        
        .stock-progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #f97316, #ef4444);
            border-radius: 50px;
            position: relative;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stock-progress-bar::after {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            animation: shine-progress 2s infinite;
        }

        @keyframes shine-progress {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .stock-text-elite {
            font-size: 10px;
            font-weight: 800;
            color: #475569;
            text-transform: uppercase;
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            padding: 0 2px;
        }

        .flash-price-row {
            display: flex;
            align-items: baseline;
            gap: 8px;
            flex-wrap: wrap;
        }

        .flash-price-strike {
            font-size: 13px;
            color: #94a3b8;
            text-decoration: line-through;
            font-weight: 600;
        }

        /* BTN BUY FLASH - HIGH URGENCY */
        .btn-flash-buy {
            background: linear-gradient(135deg, #ef4444, #f97316);
            color: #fff;
            border: none;
            padding: 11px 0;
            font-weight: 800;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 13px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3);
            text-decoration: none !important;
            display: block;
            text-align: center;
        }
        .btn-flash-buy:hover {
            transform: scale(1.03) translateY(-2px);
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.5);
            color: #fff;
            background: linear-gradient(135deg, #f97316, #ef4444);
        }

        .btn-flash-buy:active {
            transform: scale(0.98);
        }

        /* ZALO FLOATING BUTTON */
        .zalo-float {
            position: fixed;
            bottom: 30px;
            left: 30px;
            z-index: 9999;
            width: 60px;
            height: 60px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .zalo-float:hover {
            transform: scale(1.1) rotate(5deg);
        }
        .zalo-float img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        .zalo-pulse {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #0088ff;
            opacity: 0.6;
            z-index: -1;
            animation: zaloPulse 2s infinite;
        }
        @keyframes zaloPulse {
            0% { transform: scale(1); opacity: 0.6; }
            100% { transform: scale(1.8); opacity: 0; }
        }

        /* AI CHAT BUTTON */
        .ai-chat-float {
            position: fixed;
            bottom: 105px;
            left: 30px;
            z-index: 9999;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #0f172a, #334155);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fbbf24;
            font-size: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            text-decoration: none !important;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .ai-chat-float:hover {
            transform: scale(1.1) rotate(-10deg);
            color: #fff;
        }
        .ai-pulse {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #fbbf24;
            opacity: 0.4;
            z-index: -1;
            animation: aiPulse 2.5s infinite;
        }
        @keyframes aiPulse {
            0% { transform: scale(1); opacity: 0.4; }
            100% { transform: scale(2); opacity: 0; }
        }

        /* AI CHAT WINDOW */
        .ai-chat-window {
            position: fixed;
            bottom: 180px;
            left: 30px;
            width: 350px;
            height: 480px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
            z-index: 9998;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.5);
            transform: translateY(20px) scale(0.9);
            opacity: 0;
            pointer-events: none;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .ai-chat-window.active {
            transform: translateY(0) scale(1);
            opacity: 1;
            pointer-events: all;
        }
        .ai-chat-header {
            background: #0f172a;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .ai-chat-body {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 12px;
            background: #f8fafc;
        }
        .ai-msg {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 13.5px;
            line-height: 1.6;
            white-space: pre-wrap; /* Quan trọng: Giúp hiển thị dấu xuống dòng từ AI */
            word-wrap: break-word;
        }
        .ai-msg-bot {
            align-self: flex-start;
            background: white;
            color: #1e293b;
            border-bottom-left-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .ai-msg-user {
            align-self: flex-end;
            background: #0f172a;
            color: white;
            border-bottom-right-radius: 4px;
        }
        .ai-chat-footer {
            padding: 15px;
            background: white;
            border-top: 1px solid #e2e8f0;
            display: flex;
            gap: 10px;
        }
        .ai-chat-footer input {
            flex: 1;
            border: none;
            background: #f1f5f9;
            padding: 10px 15px;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
        }
        .ai-chat-footer button {
            background: #0f172a;
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            transition: 0.2s;
        }
        .ai-chat-footer button:hover {
            background: #334155;
            transform: scale(1.05);
        }
        .typing-indicator {
            font-style: italic;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 5px;
        }

        .btn-flash-buy::before {
            content: '';
            position: absolute;
            top: 0; left: -100%; width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: 0.5s;
        }

        .btn-flash-buy:hover::before {
            left: 100%;
        }

        .btn-flash-buy i {
            margin-right: 6px;
        }

        
        /* TOP WRAPPER FIXED (GUARANTEED TO FOLLOW) */
        .fixed-top-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 2000;
            background: white;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        body.has-fixed-header {
            padding-top: 105px; /* Adjusted for thinner navbar */
        }
        @media (max-width: 991px) {
            body.has-fixed-header { padding-top: 90px; }
        }
        @media (max-width: 576px) {
            body.has-fixed-header { padding-top: 82px; }
        }

        /* FOOTER DECOR */
        /* --- FLYING CART EFFECT --- */
        .flying-cart-icon {
            position: fixed;
            z-index: 9999;
            pointer-events: none;
            transition: all 1s cubic-bezier(0.19, 1, 0.22, 1);
            width: 40px;
            height: 40px;
            object-fit: contain;
            border-radius: 50%;
            background: #fff;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @keyframes cart-shake {
            0% { transform: scale(1); }
            25% { transform: scale(1.2) rotate(-10deg); }
            50% { transform: scale(1.2) rotate(10deg); }
            75% { transform: scale(1.2) rotate(-10deg); }
            100% { transform: scale(1); }
        }

        .cart-shake-anim {
            animation: cart-shake 0.5s ease-in-out;
        }

        /* --- ELITE TOAST --- */
        .elite-toast-container {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .elite-toast {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(10px);
            color: white;
            padding: 15px 25px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            border-left: 4px solid #f97316;
            transform: translateX(120%);
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .elite-toast.active {
            transform: translateX(0);
        }

        .elite-toast-icon {
            width: 40px;
            height: 40px;
            background: rgba(249, 115, 22, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f97316;
            font-size: 18px;
        }
        .map-container-elite {
            filter: grayscale(0.2) contrast(1.1);
            transition: all 0.5s ease;
        }
        .map-container-elite:hover { filter: grayscale(0); }

        .footer {
            position: relative;
            overflow: hidden;
            background-color: #fff;
            z-index: 1;
        }

        .footer::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/footer_background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Standard Parallax Effect */
            image-rendering: -webkit-optimize-contrast;
            z-index: -1;
            filter: none;
        }

        /* PREMIUM FOOTER HOVERS */
        .footer-link-elite {
            transition: all 0.3s ease;
            position: relative;
            padding: 2px 0;
            color: #1e293b;
        }

        .footer-link-elite:hover {
            color: var(--accent-orange) !important;
            transform: translateX(8px);
        }

        .footer-link-elite i {
            transition: all 0.3s ease;
            font-size: 10px;
        }

        .footer-link-elite:hover i {
            transform: scale(1.5);
            color: var(--accent-orange);
        }

        .hotline-link-elite {
            transition: all 0.3s ease;
            padding: 2px 0; /* MINIMAL SPACING */
            display: flex;
            align-items: center;
        }

        .hotline-link-elite:hover {
            color: var(--accent-orange) !important;
            transform: translateX(8px);
        }

        .hotline-link-elite:hover .rounded-circle {
            transform: scale(1.15) rotate(10deg);
            /* NO COLOR CHANGE AS REQUESTED */
        }

        .hotline-link-elite .rounded-circle {
            transition: all 0.3s ease;
        }

        /* SOCIAL BUTTONS PREMIUM HOVER */
        .social-btn {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-block;
        }

        .social-btn:hover {
            transform: translateY(-8px) scale(1.15);
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.15));
        }

        .social-btn img {
            transition: all 0.3s ease;
        }

        .social-btn:hover img {
            filter: brightness(1.1);
        }    /* ELITE CATEGORY STYLES */
    .btn-elite-filter {
        background: #f8fafc;
        border: 2px solid #f1f5f9;
        color: #475569;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 18px;
        border-radius: 50px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-elite-filter:hover {
        background: #fff;
        border-color: #fbbf24;
        color: #1e293b;
        box-shadow: 0 10px 20px rgba(251, 191, 36, 0.1);
        transform: translateY(-2px);
    }
    .btn-elite-filter.active {
        background: #fff;
        border-color: #fbbf24;
        color: #1e293b;
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.2);
    }
    .btn-elite-filter::after {
        content: "\f107";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        border: 0;
        margin-left: 5px;
        opacity: 0.5;
        transition: transform 0.3s ease;
    }
    .btn-elite-filter[aria-expanded="true"]::after {
        transform: rotate(180deg);
    }

    .custom-elite-check {
        padding-left: 2rem;
        margin-bottom: 0.75rem;
    }
    .custom-elite-check .form-check-input {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid #e2e8f0;
        cursor: pointer;
        margin-left: -2rem;
        transition: all 0.2s ease;
    }
    .custom-elite-check .form-check-input:checked {
        background-color: #fbbf24;
        border-color: #fbbf24;
        box-shadow: 0 0 10px rgba(251, 191, 36, 0.4);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%231e293b' stroke-linecap='round' stroke-linejoin='round' stroke-width='4' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
    }
    .custom-elite-check .form-check-label {
        color: #334155;
        transition: color 0.2s ease;
        cursor: pointer;
    }
    .custom-elite-check:hover .form-check-input {
        border-color: #fbbf24;
    }

    /* SORT SELECT ELITE */
    .elite-sort-wrapper {
        position: relative;
    }
    .elite-sort-wrapper::before {
        content: "\f884";
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: #fbbf24;
        font-size: 14px;
        pointer-events: none;
        z-index: 5;
    }
    .elite-sort-select {
        padding-left: 45px !important;
        border: 2px solid #f1f5f9 !important;
        height: 44px !important;
        font-weight: 800 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #1e293b !important;
        transition: all 0.3s ease !important;
        background-color: #f8fafc !important;
    }
    .elite-sort-select:focus {
        border-color: #fbbf24 !important;
        background-color: #fff !important;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05) !important;
    }

    }

    .animate-fade-in-down { animation: fadeInDown 0.6s ease-out forwards; }
    .animate-slide-in-left { animation: slideInLeft 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) forwards; }
    .animate-slide-in-up { animation: slideInUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) forwards; }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-40px); }
        to { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .hover-scale-110:hover { transform: scale(1.1); }
    .max-w-xl { max-width: 36rem; }
    .fs-tiny { font-size: 11px; }
    @keyframes float {
        0% { transform: perspective(1000px) rotateY(-10deg) translateY(0); }
        50% { transform: perspective(1000px) rotateY(-8deg) translateY(-20px); }
        100% { transform: perspective(1000px) rotateY(-10deg) translateY(0); }
    }
    .animate-float {
        animation: float 5s ease-in-out infinite;
    }
    /* CINEMA ELITE STYLES */
    .text-gradient-gold-elite {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #fbbf24 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-size: 200% auto;
        animation: shine 3s linear infinite;
    }
    @keyframes shine {
        to { background-position: 200% center; }
    }

    .elite-status-dot {
        width: 10px;
        height: 10px;
        background: #fbbf24;
        border-radius: 50%;
        position: relative;
        box-shadow: 0 0 10px #fbbf24;
    }
    .elite-status-dot::after {
        content: '';
        position: absolute;
        top: -2px; left: -2px; right: -2px; bottom: -2px;
        border: 2px solid #fbbf24;
        border-radius: 50%;
        animation: pulse-dot 1.5s ease-out infinite;
    }
    @keyframes pulse-dot {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(3); opacity: 0; }
    }

    .glass-tag-elite {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    .glass-tag-elite:hover {
        background: rgba(255,255,255,0.12) !important;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }

    /* ELITE CHIPS (ACTIVE FILTERS) */
    .elite-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: #fff;
        border: 2px solid #f1f5f9;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 800;
        color: #1e293b;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        animation: slideInUp 0.4s ease-out forwards;
    }
    .elite-chip:hover {
        border-color: #fbbf24;
        background: #fff;
        box-shadow: 0 5px 15px rgba(251, 191, 36, 0.15);
        transform: translateY(-2px);
    }
    .elite-chip i {
        color: #fbbf24;
    }
    .elite-chip .btn-close-chip {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 10px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .elite-chip:hover .btn-close-chip {
        background: #ef4444;
        color: #fff;
    }

    /* CUSTOM ELITE SELECT DROPDOWN */
    .btn-elite-sort {
        background: #f8fafc !important;
        border: 2px solid #f1f5f9 !important;
        padding: 10px 24px !important;
        border-radius: 50px !important;
        font-weight: 700 !important;
        font-size: 12px !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        color: #1e293b !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-width: 220px;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1) !important;
    }
    .btn-elite-sort:hover, .btn-elite-sort[aria-expanded="true"] {
        background: #fff !important;
        border-color: #fbbf24 !important;
        box-shadow: 0 10px 30px rgba(251, 191, 36, 0.15) !important;
        transform: translateY(-2px);
    }
    .elite-sort-menu {
        border: 0 !important;
        box-shadow: 0 20px 50px rgba(0,0,0,0.12) !important;
        border-radius: 20px !important;
        padding: 10px !important;
        min-width: 220px !important;
        margin-top: 15px !important;
        border: 1px solid #f1f5f9 !important;
    }
    .elite-sort-item {
        padding: 12px 18px !important;
        border-radius: 12px !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        color: #475569 !important;
        transition: all 0.2s ease !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2px;
    }
    .elite-sort-item:hover {
        background: #f8fafc !important;
        color: #1e293b !important;
        transform: translateX(5px);
    }
    .elite-sort-item.active {
        background: rgba(251, 191, 36, 0.1) !important;
        color: #f59e0b !important;
    }
    .elite-sort-item .check-icon {
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .elite-sort-item.active .check-icon {
        opacity: 1;
    }

    /* ELITE PAGINATION */
    .pagination-elite-wrapper .pagination {
        gap: 10px;
        margin-bottom: 0;
    }
    .pagination-elite-wrapper .page-item .page-link {
        border: 2px solid #f1f5f9;
        border-radius: 14px !important;
        min-width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #475569;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        background: #fff;
        font-size: 14px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .pagination-elite-wrapper .page-item.active .page-link {
        background: #fbbf24 !important;
        border-color: #fbbf24 !important;
        color: #1e293b !important;
        box-shadow: 0 8px 20px rgba(251, 191, 36, 0.35);
        transform: translateY(-3px) scale(1.05);
    }
    .pagination-elite-wrapper .page-item .page-link:hover:not(.active) {
        background: #fff;
        border-color: #fbbf24;
        color: #fbbf24;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .pagination-elite-wrapper .page-item.disabled .page-link {
        opacity: 0.4;
        background: #f8fafc;
        border-color: #f1f5f9;
    }
    .pagination-elite-info {
        font-weight: 700;
        color: #94a3b8;
        font-size: 13px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .pagination-elite-info span {
        color: #1e293b;
        font-weight: 700;
        padding: 0 2px;
    }

    /* ELITE LOADING OVERLAY */
    #elite-loading-overlay {
        position: fixed;
        top: 0; left: 0; 
        width: 100%; height: 100%;
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(8px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 999999;
        transition: opacity 0.3s ease;
    }
    .elite-loader-content {
        display: flex;
        flex-column;
        align-items: center;
        gap: 15px;
    }
    .elite-spinner {
        width: 50px;
        height: 50px;
        border: 4px solid rgba(251, 191, 36, 0.1);
        border-top: 4px solid #fbbf24;
        border-radius: 50%;
        animation: elite-spin 0.8s linear infinite;
    }
    @keyframes elite-spin { to { transform: rotate(360deg); } }

    /* MOBILE OFF-CANVAS TOP LAYER */
    .offcanvas {
        z-index: 9999 !important;
    }
    .offcanvas-backdrop {
        z-index: 9998 !important;
    }
    .loader-text-elite {
        font-weight: 800;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #1e293b;
    }

    /* NEWSLETTER PLACEHOLDER LIGHT */
    #globalNewsletterForm input::placeholder {
        color: rgba(255, 255, 255, 0.7) !important;
    }

    .footer-copyright-elite {
        font-size: 13px;
        letter-spacing: 0.2px;
        transition: all 0.3s ease;
    }
    @media (max-width: 576px) {
        .footer-copyright-elite {
            font-size: 10px;
            letter-spacing: -0.3px;
        }
    }

    /* ELITE SCROLLBAR - V3 FINAL HARD OVERRIDE */

    html {
        overflow-y: scroll !important; /* Forces scrollbar track to ALWAYS show */
        overflow-x: hidden !important;
        scrollbar-width: auto !important; /* Standard property for thickness */
        scrollbar-color: #f97316 #f1f5f9 !important; /* Standard property for colors */
    }

    /* Target all elements for webkit engines */
    ::-webkit-scrollbar {
        width: 16px !important;
        height: 16px !important;
        display: block !important;
        background: #f1f5f9 !important;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
        border-left: 1px solid #e2e8f0 !important;
    }
    ::-webkit-scrollbar-thumb {
        background-color: #f97316 !important; /* Solid Orange */
        background-image: none !important;
        border: 3px solid #f1f5f9 !important; /* Pill effect */
        border-radius: 10px !important;
        min-height: 80px !important;
        box-shadow: none !important;
    }
    ::-webkit-scrollbar-thumb:hover {
        background-color: #0f172a !important; /* Dark on hover */
    }
    /* Firmly kill the arrow buttons */
    ::-webkit-scrollbar-button {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
        visibility: hidden !important;
    }
    ::-webkit-scrollbar-corner {
        background: transparent !important;
    }




    </style>
    @stack('styles')
</head>

<body class="@unless(Route::is('login', 'register', 'password.*')) has-fixed-header @endunless">
    @unless(Route::is('login', 'register', 'password.*'))
    <div class="fixed-top-wrapper">
        <!-- TOP MARQUEE INSIDE CONTAINER BOUNDARY -->
        <div class="top-marquee-elite">
            <div class="container border-start border-end border-white border-opacity-10">
                <div class="marquee-content-elite">
                    <div class="marquee-item-elite">
                        <i class="fas fa-crown text-warning"></i> CHÀO MỪNG ĐẾN VỚI DDH ELECTRONICS - GEAR CHÍNH HÃNG 100%
                    </div>
                    <div class="marquee-item-elite">
                        <i class="fas fa-shield-halved text-success"></i> HỖ TRỢ TRẢ GÓP 0% - BẢO HÀNH 24 THÁNG 1 ĐỔI 1
                    </div>
                    <div class="marquee-item-elite">
                        <i class="fas fa-truck-fast text-info"></i> GIAO HÀNG HỎA TỐC 2H TRONG NỘI THÀNH HÀ NỘI
                    </div>
                    <!-- Duplicate for infinite effect -->
                    <div class="marquee-item-elite">
                        <i class="fas fa-crown text-warning"></i> CHÀO MỪNG ĐẾN VỚI DDH ELECTRONICS - GEAR CHÍNH HÃNG 100%
                    </div>
                    <div class="marquee-item-elite">
                        <i class="fas fa-shield-halved text-success"></i> HỖ TRỢ TRẢ GÓP 0% - BẢO HÀNH 24 THÁNG 1 ĐỔI 1
                    </div>
                    <div class="marquee-item-elite">
                        <i class="fas fa-truck-fast text-info"></i> GIAO HÀNG HỎA TỐC 2H TRONG NỘI THÀNH HÀ NỘI
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-elite border-0 px-0">
            <div class="container d-flex align-items-center justify-content-between flex-nowrap">
                <!-- LEFT: LOGO -->
                <a class="navbar-brand d-flex align-items-center me-0" href="{{ url('/') }}" wire:navigate>
                    <img src="{{ asset('images/logo-removebg-preview.png') }}" alt="Logo" style="height: 50px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05));" class="navbar-logo-elite">
                </a>
                
                <!-- CENTER: MENU LINKS (Desktop only) -->
                <div class="collapse d-none d-lg-flex navbar-collapse justify-content-center" id="navbarSupportedContent">
                    <ul class="navbar-nav mb-2 mb-lg-0 gap-lg-1">
                        <li class="nav-item">
                            <a class="nav-link nav-link-elite" href="javascript:void(0)" onclick="openGlobalSpotlight()">
                                <i class="fas fa-layer-group text-primary"></i> <span>Danh mục</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-elite" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalChiNhanh">
                                <i class="fas fa-store text-success"></i> <span>Chi nhánh</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-elite" href="{{ route('posts.index') }}" wire:navigate>
                                <i class="fas fa-newspaper text-info"></i> <span>Tin tức</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- CENTER/FLEX SEARCH: (Persistent) -->
                <div class="search-wrapper-elite d-flex align-items-center mx-2 mx-lg-4 flex-grow-1" style="min-width: 120px; max-width: 450px;">
                    <i class="fas fa-magnifying-glass text-muted me-2 small"></i>
                    <input type="text" class="search-input-elite" placeholder="Tìm gear...">
                </div>

                <!-- RIGHT: ACTIONS -->
                <div class="d-flex align-items-center gap-2 gap-sm-3">
                    <a href="{{ route('cart.index') }}" class="btn-cart-elite text-decoration-none" wire:navigate>
                        <div class="position-relative d-flex align-items-center">
                            <i class="fas fa-bag-shopping fs-5"></i>
                            <span class="badge rounded-pill bg-danger position-absolute cart-badge-elite" id="cartBadgeCount">
                                {{ array_sum(array_column(session()->get('cart', []), 'quantity')) }}
                            </span>
                        </div>
                        <span class="ms-1">Giỏ hàng</span>
                    </a>

                    <!-- Notification Bell -->
                    @auth
                    <div class="dropdown me-1">
                        <a href="javascript:void(0)" class="nav-link text-dark position-relative p-2 rounded-circle hover-bg-light" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-bell fs-5"></i>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger p-1" style="margin-left: -5px; margin-top: 5px;">
                                    <span class="visually-hidden">thông báo mới</span>
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 p-2 rounded-4 mt-2 dropdown-menu-elite" style="min-width: 320px; max-height: 400px; overflow-y: auto;">
                            <div class="px-3 py-2 border-bottom d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-bold text-dark">Thông báo</span>
                                @if(auth()->user()->unreadNotifications->count() > 0)
                                    <a href="{{ route('notifications.markAllRead') }}" class="small text-primary text-decoration-none fw-bold">Đánh dấu đã đọc</a>
                                @endif
                            </div>
                            @if(auth()->user()->notifications->count() > 0)
                                @foreach(auth()->user()->notifications->take(10) as $notif)
                                    <a href="{{ route('notifications.read', $notif->id) }}" class="dropdown-item rounded-3 p-3 mb-1 {{ !$notif->is_read ? 'bg-light border-start border-4 border-warning' : '' }} transition-all">
                                        <div class="fw-bold text-dark small mb-1">{{ $notif->title }}</div>
                                        <div class="text-muted xx-small lh-sm">{{ $notif->message }}</div>
                                        <div class="text-primary xx-small mt-2 fw-bold opacity-50">{{ $notif->created_at->diffForHumans() }}</div>
                                    </a>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-bell-slash text-light fs-1 mb-2"></i>
                                    <p class="text-muted small mb-0">Chưa có thông báo nào!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endauth

                    <!-- User Dropdown (Tablets & Desktops) -->
                    <div class="d-none d-lg-block">
                        @guest
                            <a class="btn-login-elite d-flex align-items-center px-3" href="{{ route('login') }}">
                                <i class="fas fa-circle-user"></i>
                                <span>Đăng nhập</span>
                            </a>
                        @else
                            <a class="nav-link fw-bold d-flex align-items-center gap-2 p-0" href="{{ route('account.profile') }}" wire:navigate>
                                @php $user = Auth::user(); @endphp
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center shadow-sm overflow-hidden" style="width: 38px; height: 38px; border: 2px solid white; font-family: 'Outfit', sans-serif; background: {{ ($user->avatar || $user->social_avatar) ? 'transparent' : '#0f172a' }};">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @elseif($user->social_avatar)
                                        <img src="{{ $user->social_avatar }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        {{ mb_strtoupper(mb_substr($user->name, 0, 1, 'UTF-8')) }}
                                    @endif
                                </div>
                                <span class="d-none d-xl-inline-block text-dark small fw-bold">{{ str_replace('+', ' ', Auth::user()->name) }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
</div>
@endunless

    <!-- MOBILE MENU -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <img src="{{ asset('images/logo-removebg-preview.png') }}" style="height: 30px; width: auto; object-fit: contain;" alt="Logo">
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <!-- USER SECTION ON MOBILE -->
            @guest
                <div class="mb-4">
                    <a href="{{ route('login') }}" class="btn-login-elite w-100 justify-content-center py-3 rounded-4">
                        <i class="fas fa-circle-user"></i>
                        <span>Đăng nhập ngay</span>
                    </a>
                </div>
            @else
                <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-4 border border-info border-opacity-10">
                    <div class="rounded-circle overflow-hidden shadow-sm" style="width: 48px; height: 48px; border: 2px solid white;">
                        @php $user = Auth::user(); @endphp
                        @if($user->avatar)
                            <img src="{{ asset($user->avatar) }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @elseif($user->social_avatar)
                            <img src="{{ $user->social_avatar }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="bg-primary text-white d-flex align-items-center justify-content-center h-100 fw-bold">{{ mb_strtoupper(mb_substr($user->name, 0, 1, 'UTF-8')) }}</div>
                        @endif
                    </div>
                    <div>
                        <div class="fw-bold text-dark">{{ Auth::user()->name }}</div>
                        <div class="xx-small text-primary fw-bold text-uppercase">Thành viên Elite</div>
                    </div>
                </div>
            @endguest

            <div class="p-2 bg-light rounded-pill d-flex align-items-center mb-4 px-3">
                <i class="fas fa-search text-muted me-2"></i>
                <input type="text" class="border-0 bg-transparent w-100 py-1" style="outline: none;" placeholder="Tìm sản phẩm...">
            </div>
            <ul class="list-unstyled">
                <li class="mb-3"><a href="javascript:void(0)" onclick="openGlobalSpotlight()" class="text-decoration-none fw-bold text-dark d-flex align-items-center gap-3"><i class="fas fa-th-large text-primary"></i> Danh mục</a></li>
                <li class="mb-3"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalChiNhanh" class="text-decoration-none fw-bold text-dark d-flex align-items-center gap-3"><i class="fas fa-store text-success"></i> Chi nhánh</a></li>
                <li class="mb-3"><a href="{{ route('posts.index') }}" class="text-decoration-none fw-bold text-dark d-flex align-items-center gap-3"><i class="fas fa-newspaper text-info"></i> Tin tức công nghệ</a></li>
                @auth
                    <hr class="opacity-10 my-4">
                    @if(Auth::user()->is_admin)
                        <li class="mb-3"><a href="{{ url('/admin') }}" class="text-decoration-none fw-bold text-dark d-flex align-items-center gap-3"><i class="fas fa-user-shield text-warning"></i> Trang quản trị</a></li>
                    @endif
                    @if(Auth::user()->can_write_posts || Auth::user()->email === 'admin@ddh.com')
                        <li class="mb-3"><a href="{{ route('admin.posts.create') }}" class="text-decoration-none fw-bold text-dark d-flex align-items-center gap-3"><i class="fas fa-pen-nib text-orange"></i> Viết bài mới</a></li>
                    @endif
                    <li class="mb-3"><a href="{{ route('account.orders') }}" class="text-decoration-none fw-bold text-dark d-flex align-items-center gap-3"><i class="fas fa-shopping-bag text-primary"></i> Đơn hàng của tôi</a></li>
                    <li class="mb-3">
                        <a href="{{ route('logout') }}" class="text-decoration-none fw-bold text-danger d-flex align-items-center gap-3 confirm-logout-app">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>

    <!-- MOBILE BOTTOM NAVIGATION -->
    @unless(Route::is('login', 'register', 'password.*'))
    <div class="bottom-nav-elite d-flex d-lg-none">
        <a href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCategory" class="bottom-nav-item">
            <i class="fas fa-layer-group"></i>
            <span>Danh mục</span>
        </a>
        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalChiNhanh" class="bottom-nav-item">
            <i class="fas fa-store"></i>
            <span>Chi nhánh</span>
        </a>
        <a href="{{ route('posts.index') }}" class="bottom-nav-item">
            <i class="fas fa-newspaper"></i>
            <span>Tin tức</span>
        </a>
        @guest
            <a href="{{ route('login') }}" class="bottom-nav-item">
                <i class="fas fa-circle-user"></i>
                <span>Tài khoản</span>
            </a>
        @else
            <a href="{{ route('account.profile') }}" class="bottom-nav-item">
                @php $user = Auth::user(); @endphp
                @if($user->avatar || $user->social_avatar)
                    <img src="{{ asset($user->avatar ?? $user->social_avatar) }}" class="avatar-bottom-nav">
                @else
                    <i class="fas fa-circle-user"></i>
                @endif
                <span>Cá nhân</span>
            </a>
        @endguest
    </div>
    @endunless
    <main class="pt-0">
        @unless(Route::is('login', 'register', 'password.*'))
        <div class="container mt-3">
        </div>
        @endunless
        @yield('content')
    </main>

    <!-- FULL ORIGINAL FOOTER CORE -->
    @unless(Route::is('login', 'register', 'password.*'))
    <footer class="footer pb-4 pt-5 mt-5">
        <div class="container" style="max-width: 1250px;">
            <div class="row text-center text-md-start g-4">

                <!-- Column 1: Brand & Map (RESTORED FULL) -->
                <div class="col-lg-4 mb-4 d-flex flex-column align-items-center align-items-lg-start">
                    <div class="mb-3">
                        <div class="fw-bold fs-4" style="color: var(--primary-blue); letter-spacing: 1.5px;">DDH ELECTRONICS</div>
                    </div>
                    <div class="contact-item mb-4 w-100 d-flex flex-column align-items-center align-items-lg-start">
                        <div class="d-flex align-items-center justify-content-center justify-content-lg-start gap-2 mb-3 w-100">
                            <i class="fas fa-map-marker-alt text-danger fs-5"></i>
                            <span class="small fw-bold text-dark text-center text-lg-start">235 Hoàng Quốc Việt, Cầu Giấy, Hà Nội</span>
                        </div>
                        <div class="map-wrapper-elite overflow-hidden rounded-4 shadow-sm border border-2 border-primary border-opacity-10 w-100">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.660144161726!2d105.787682!3d21.0462744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab30026e955d%3A0x63777d0187425f38!2zMjM1IEhvw6BuZyBRdeG7kWMgVmnhu4d0LCBD4buVIE5odeG6v3QsIELhuq9jIFThu6sgTGnDqm0sIEjDoCBO4buZaSwgVmlldG5hbQ!5e0!3m2!1svi!2s!4v1712271800000!5m2!1svi!2s"
                                width="100%" height="160" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                    <p class="lh-relaxed text-muted small fw-medium text-center text-lg-start">
                        Tiên phong trong lĩnh vực cung cấp các giải pháp phần cứng và linh kiện máy tính cao cấp tại Việt Nam. DDH Electronics cam kết mang lại trải nghiệm gear đỉnh cao.
                    </p>
                </div>

                <!-- Column 2: Policies (RESTORED FULL) -->
                <div class="col-lg-4 mb-4 ps-lg-5 d-flex flex-column align-items-center align-items-lg-start">
                    <h6 class="fw-bold mb-4 pb-2 border-bottom border-warning border-opacity-50 mx-auto mx-lg-0" style="color: var(--primary-blue); width: fit-content;">DỊCH VỤ & CHÍNH SÁCH</h6>
                    <ul class="list-unstyled d-flex flex-column align-items-center align-items-lg-start gap-3 w-100">
                        <li class="w-100"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalHuongDan" class="footer-link-elite text-decoration-none small text-dark d-flex align-items-center justify-content-center justify-content-lg-start gap-2 text-center text-lg-start"><i class="fas fa-chevron-right text-warning"></i> Hướng dẫn mua hàng trực tuyến</a></li>
                        <li class="w-100"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalBaoHanh" class="footer-link-elite text-decoration-none small text-dark d-flex align-items-center justify-content-center justify-content-lg-start gap-2 text-center text-lg-start"><i class="fas fa-chevron-right text-warning"></i> Chính sách bảo hành 24 tháng</a></li>
                        <li class="w-100"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalDoiTra" class="footer-link-elite text-decoration-none small text-dark d-flex align-items-center justify-content-center justify-content-lg-start gap-2 text-center text-lg-start"><i class="fas fa-chevron-right text-warning"></i> Quy trình đổi trả 7 ngày</a></li>
                        <li class="w-100"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalDonHang" class="footer-link-elite text-decoration-none small text-dark d-flex align-items-center justify-content-center justify-content-lg-start gap-2 text-center text-lg-start"><i class="fas fa-chevron-right text-warning"></i> Hệ thống tra cứu đơn hàng</a></li>
                    </ul>
                    <div class="mt-4 text-center text-lg-start">
                        <a href="{{ url('/') }}">
                            <img src="{{ asset('images/logo-removebg-preview.png') }}" alt="Logo" style="height: 60px; opacity: 0.8;">
                        </a>
                    </div>
                </div>

                <!-- Column 3: Hotlines (RESTORED FULL) -->
                <div class="col-lg-4 mb-4 d-flex flex-column align-items-center align-items-lg-start">
                    <h6 class="fw-bold mb-4 pb-2 border-bottom border-primary border-opacity-50 mx-auto mx-lg-0" style="color: var(--primary-blue); width: fit-content;">HOTLINE HỖ TRỢ</h6>
                    <div class="d-flex flex-column align-items-center align-items-lg-start gap-1 mb-4 w-100">
                        <a href="tel:0337654252" class="hotline-link-elite text-decoration-none text-dark small d-flex align-items-center justify-content-center justify-content-lg-start gap-3 w-100">
                            <div class="bg-primary bg-opacity-10 p-2 rounded-circle"><i class="fas fa-user-tie text-primary"></i></div>
                            <span>Tư vấn: 0337.654.252 (Dương)</span>
                        </a>
                        <a href="tel:0969869562" class="hotline-link-elite text-decoration-none text-dark small d-flex align-items-center justify-content-center justify-content-lg-start gap-3 w-100">
                            <div class="bg-success bg-opacity-10 p-2 rounded-circle"><i class="fas fa-screwdriver-wrench text-success"></i></div>
                            <span>Kỹ thuật: 0969.869.562 (Đạt)</span>
                        </a>
                        <a href="tel:0325864908" class="hotline-link-elite text-decoration-none text-dark small d-flex align-items-center justify-content-center justify-content-lg-start gap-3 w-100">
                            <div class="bg-warning bg-opacity-10 p-2 rounded-circle"><i class="fas fa-shield-halved text-warning"></i></div>
                            <span>Bảo hành: 0325.864.908 (Hiếu)</span>
                        </a>
                    </div>
                    <div class="d-flex justify-content-center justify-content-lg-start gap-3 pt-2 mb-4 w-100">
                        <a href="https://www.facebook.com/dffsaiyan" class="social-btn" target="_blank">
                            <img src="{{ asset('images/Facebook_Logo_Primary.png') }}" alt="Facebook" style="height: 35px;">
                        </a>
                        <a href="https://www.youtube.com/@wolffdevilofficial3691" class="social-btn" target="_blank">
                            <img src="{{ asset('images/yt_icon_red_digital.png') }}" alt="YouTube" style="height: 35px;">
                        </a>
                        <a href="https://www.instagram.com/cochiloco024/" class="social-btn" target="_blank">
                            <img src="{{ asset('images/instagram.png') }}" alt="Instagram" style="height: 35px;">
                        </a>
                    </div>

                    <!-- Newsletter Card in Footer -->
                    <div class="card border-0 rounded-4 bg-dark text-white p-4 shadow-lg overflow-hidden position-relative w-100">
                        <div class="position-relative z-1 text-center text-lg-start">
                            <h6 class="fw-bold mb-2">Đăng ký nhận tin</h6>
                            <p class="x-small opacity-75 mb-3">Nhận ưu đãi mới nhất từ DDH Electronics.</p>
                            <form id="globalNewsletterForm" class="d-flex gap-2">
                                @csrf
                                <input type="email" name="email" class="form-control form-control-sm rounded-pill border-0 bg-white bg-opacity-10 text-white px-3" style="font-size: 11px;" placeholder="Email của bạn..." required>
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold" style="font-size: 11px;" id="btnGlobalSubscribe">Gửi</button>
                            </form>
                            <div id="globalNewsletterMsg" class="mt-2 xx-small fw-bold" style="display: none;"></div>
                        </div>
                        <i class="fas fa-paper-plane position-absolute bottom-0 end-0 m-n2 opacity-10 fa-3x text-white"></i>
                    </div>
                </div>
            </div>

            <!-- PAYMENT LOGOS CENTERED BELOW -->
            <div class="mt-4 mb-n2 d-flex justify-content-center align-items-center gap-3 animate-fade-in">
                <img src="{{ asset('images/MOMO-Logo-App.png') }}" class="bg-white rounded p-1 shadow-sm" style="height: 30px; width: 30px; object-fit: contain;" alt="MoMo">
                <img src="{{ asset('images/vnpay-logo.png') }}" class="bg-white rounded p-1 shadow-sm" style="height: 30px; width: auto; object-fit: contain;" alt="VNPay">
            </div>

            <div class="mt-5 pt-4 text-center border-top">
                <p class="mb-0 text-muted fw-bold text-center px-1 text-nowrap footer-copyright-elite">© 2026 DDH Electronics. Design & Core by <span class="text-primary opacity-75">Dương - Đạt - Hiếu</span>.</p>

            </div>
        </div>
    </footer>
    @endunless

    <!-- ALL ORIGINAL MODALS (FULL CONTENT) -->
    <!-- MODAL: HƯỚNG DẪN MUA HÀNG -->
    <div class="modal fade" id="modalHuongDan" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-5 border-0 shadow-lg overflow-hidden">
                <div class="modal-header bg-dark text-white p-4 border-bottom border-warning border-opacity-25">
                    <h5 class="modal-title fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-shopping-cart text-warning me-2"></i> Quy trình mua hàng Elite</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3 p-md-5 bg-white">
                    <div class="row g-3 g-md-4">
                        <div class="col-md-6">
                            <div class="p-3 p-md-4 rounded-4 bg-light shadow-sm border-start border-4 border-warning h-100">
                                <div class="d-flex align-items-center gap-3 mb-2 mb-md-3">
                                    <div class="bg-warning bg-opacity-10 p-2 rounded-3"><i class="fas fa-search text-warning"></i></div>
                                    <div class="fw-bold text-dark text-uppercase small" style="font-size: 11px;">Bước 1: Khám phá</div>
                                </div>
                                <p class="small text-muted mb-0 lh-relaxed" style="font-size: 12px;">Dễ dàng tìm kiếm các siêu phẩm Gear bản giới hạn tại danh mục hoặc thanh Search thông minh.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 p-md-4 rounded-4 bg-light shadow-sm border-start border-4 border-primary h-100">
                                <div class="d-flex align-items-center gap-3 mb-2 mb-md-3">
                                    <div class="bg-primary bg-opacity-10 p-2 rounded-3"><i class="fas fa-headset text-primary"></i></div>
                                    <div class="fw-bold text-dark text-uppercase small" style="font-size: 11px;">Bước 2: Tư vấn Chuyên sâu</div>
                                </div>
                                <p class="small text-muted mb-0 lh-relaxed" style="font-size: 12px;">Đội ngũ Elite sẽ gọi điện tư vấn kỹ thuật để đảm bảo Gear bạn chọn phù hợp 100% với nhu cầu.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 p-md-4 rounded-4 bg-light shadow-sm border-start border-4 border-success h-100">
                                <div class="d-flex align-items-center gap-3 mb-2 mb-md-3">
                                    <div class="bg-success bg-opacity-10 p-2 rounded-3"><i class="fas fa-credit-card text-success"></i></div>
                                    <div class="fw-bold text-dark text-uppercase small" style="font-size: 11px;">Bước 3: Chốt đơn an toàn</div>
                                    </div>
                                <p class="small text-muted mb-0 lh-relaxed" style="font-size: 12px;">Thanh toán bảo mật đa nền tảng: MoMo, VNPAY hoặc hỗ trợ Trả góp 0% linh hoạt.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 p-md-4 rounded-4 bg-light shadow-sm border-start border-4 border-info h-100">
                                <div class="d-flex align-items-center gap-3 mb-2 mb-md-3">
                                    <div class="bg-info bg-opacity-10 p-2 rounded-3"><i class="fas fa-shipping-fast text-info"></i></div>
                                    <div class="fw-bold text-dark text-uppercase small" style="font-size: 11px;">Bước 4: Nhận hàng hỏa tốc</div>
                                </div>
                                <p class="small text-muted mb-0 lh-relaxed" style="font-size: 12px;">Giao ngay trong 2-4h (Nội thành HN) với thùng hàng được đóng gói tiêu chuẩn chống va đập.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: CHÍNH SÁCH BẢO HÀNH -->
    <div class="modal fade" id="modalBaoHanh" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-5 border-0 shadow-lg overflow-hidden">
                <div class="modal-header bg-dark text-white p-4 border-bottom border-primary border-opacity-25">
                    <h5 class="modal-title fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-shield-alt text-primary me-2"></i> Chính sách bảo hành 24 tháng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3 p-md-5 bg-white">
                    <div class="alert alert-primary border-0 rounded-4 p-3 p-md-4 mb-3 mb-md-4">
                        <div class="d-flex gap-3">
                            <i class="fas fa-info-circle fs-4 mt-1"></i>
                            <div>
                                <div class="fw-bold mb-1" style="font-size: 14px;">Cam kết vàng từ DDH Electronics</div>
                                <p class="small mb-0" style="font-size: 12px;">Tất cả sản phẩm bán ra đều được bảo hành chính hãng. Chúng tôi tự hào là đơn vị có quy trình xử lý bảo hành nhanh nhất hiện nay.</p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 g-md-3">
                        <div class="col-12"><div class="p-3 border rounded-3 bg-light small fw-bold text-dark" style="font-size: 12px;"><i class="fas fa-check-circle text-success me-2"></i> Bảo hành 1 Đổi 1 trong 30 ngày đầu nếu có lỗi phần cứng.</div></div>
                        <div class="col-12"><div class="p-3 border rounded-3 bg-light small fw-bold text-dark" style="font-size: 12px;"><i class="fas fa-check-circle text-success me-2"></i> Vệ sinh, tra keo tản nhiệt định kỳ MIỄN PHÍ trọn đời máy.</div></div>
                        <div class="col-12"><div class="p-3 border rounded-3 bg-light small fw-bold text-dark" style="font-size: 12px;"><i class="fas fa-check-circle text-success me-2"></i> Hỗ trợ kỹ thuật từ xa 24/7 qua UltraView hoặc Zalo.</div></div>
                        <div class="col-12"><div class="p-3 border rounded-3 bg-light small fw-bold text-dark" style="font-size: 12px;"><i class="fas fa-check-circle text-success me-2"></i> Cho mượn linh kiện tương đương để dùng trong thời gian chờ bảo hành.</div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: QUY TRÌNH ĐỔI TRẢ -->
    <div class="modal fade" id="modalDoiTra" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content rounded-5 border-0 shadow-lg overflow-hidden">
                <div class="modal-header bg-dark text-white p-4 border-bottom border-danger border-opacity-25">
                    <h5 class="modal-title fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-sync text-danger me-2"></i> Quy trình đổi trả 7 ngày</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-3 p-md-5 bg-white text-center">
                    <div class="mb-4 mb-md-5">
                        <i class="fas fa-box-open fa-3x fa-md-4x text-danger opacity-25 mb-3"></i>
                        <h4 class="fw-black text-dark" style="font-size: 18px;">DÙNG THỬ 7 NGÀY - KHÔNG ƯNG TRẢ LẠI</h4>
                        <p class="text-muted small" style="font-size: 12px;">Chúng tôi hiểu việc chọn Gear cần thời gian trải nghiệm thực tế. DDH Electronics hỗ trợ bạn tối đa.</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <div class="d-flex flex-column gap-2 gap-md-3 text-start">
                                <div class="d-flex align-items-center gap-3 gap-md-4 p-3 bg-light rounded-4">
                                    <div class="fw-bold fs-4 text-danger" style="min-width: 30px;">01</div>
                                    <div class="small fw-bold" style="font-size: 11px;">Sản phẩm còn nguyên Seal hoặc không trầy xước từ bên ngoài.</div>
                                </div>
                                <div class="d-flex align-items-center gap-3 gap-md-4 p-3 bg-light rounded-4">
                                    <div class="fw-bold fs-4 text-danger" style="min-width: 30px;">02</div>
                                    <div class="small fw-bold" style="font-size: 11px;">Đầy đủ vỏ hộp, phụ kiện đi kèm như ban đầu.</div>
                                </div>
                                <div class="d-flex align-items-center gap-3 gap-md-4 p-3 bg-light rounded-4">
                                    <div class="fw-bold fs-4 text-danger" style="min-width: 30px;">03</div>
                                    <div class="small fw-bold" style="font-size: 11px;">Hoàn tiền 100% hoặc đổi sản phẩm khác có giá trị tương đương.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL: HỆ THỐNG TRA CỨU ĐƠN HÀNG -->
    <div class="modal fade" id="modalDonHang" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-5 border-0 shadow-lg overflow-hidden">
                <div class="modal-header bg-dark text-white p-4">
                    <h5 class="modal-title fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-search-location text-warning me-2"></i> Tra cứu đơn hàng</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-5 bg-white text-center">
                    <p class="fw-bold text-dark mb-4">Để kiểm tra trạng thái vận chuyển của đơn hàng, quý khách vui lòng:</p>
                    <div class="d-flex flex-column gap-3 mb-5">
                        <a href="{{ route('account.orders') }}" class="btn btn-dark rounded-pill py-3 fw-bold"><i class="fas fa-user-circle me-2 text-warning"></i> Truy cập Tài khoản cá nhân</a>
                        <a href="https://zalo.me/0337654252" target="_blank" class="btn btn-outline-primary rounded-pill py-3 fw-bold"><i class="fas fa-comment-dots me-2"></i> Chat qua Zalo hỗ trợ</a>
                    </div>
                    <p class="x-small text-muted">Hệ thống sẽ cập nhật mã vận đơn (Tracking ID) vào Email của bạn ngay sau khi hàng được xuất kho.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- modalChiNhanh with Full Icons and List -->
    <div class="modal fade" id="modalChiNhanh" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content rounded-5 border-0 shadow-lg">
                <div class="modal-header bg-dark text-white p-4 border-bottom border-warning border-opacity-25">
                    <h5 class="modal-title fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-store-alt me-2 text-warning"></i> HỆ THỐNG CHI NHÁNH ELITE ELECTRONICS</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-5">
                    <div class="row g-4 text-center">
                        <div class="col-md-4">
                            <div class="p-4 border rounded-4 hover-shadow transition">
                                <i class="fas fa-map-location-dot fs-1 text-primary mb-3"></i>
                                <h6 class="fw-bold">Nghĩa Đô</h6>
                                <p class="small text-muted mb-0">235 Hoàng Quốc Việt, Cầu Giấy, HN</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-4 hover-shadow transition">
                                <i class="fas fa-map-location-dot fs-1 text-success mb-3"></i>
                                <h6 class="fw-bold">Đống Đa</h6>
                                <p class="small text-muted mb-0">45 Thái Hà, Đống Đa, Hà Nội</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-4 border rounded-4 hover-shadow transition">
                                <i class="fas fa-map-location-dot fs-1 text-warning mb-3"></i>
                                <h6 class="fw-bold">Từ Liêm</h6>
                                <p class="small text-muted mb-0">39 Nguyễn Hoàng, Từ Liêm, Hà Nội</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Spotlight Overlay -->
    <div id="sidebarOverlayElite" onclick="closeHeroSidebarHighlight()"></div>

    <!-- Global Spotlight Menu (EXACT 1:1 SIDEBAR REPLICA) -->
    <div id="globalSpotlightMenu" class="spotlight-global-container" onclick="if(event.target === this) closeHeroSidebarHighlight()">
        <div class="container" style="max-width: 1250px; position: relative;">
            <div class="spotlight-card-wrapper shadow-lg">
                <div class="spotlight-card-elite">
                    <div class="p-3 bg-dark-elite text-white fw-bold d-flex align-items-center gap-2 small border-bottom border-warning border-3">
                        <i class="fas fa-bars text-warning"></i> DANH MỤC SẢN PHẨM
                    </div>
                    <div class="d-flex flex-column py-1 flex-grow-1">
                        @php
                            $sideCats = [
                                ['img' => 'vecteezy_ergonomic-mechanical-keyboard-with-custom-keycaps-for_60514914.png', 'text' => 'Bàn phím cơ', 'slug' => 'ban-phim-co'],
                                ['img' => 'gaming-mouse-3d-icon-png-download-9675855.webp', 'text' => 'Chuột Gaming', 'slug' => 'chuot-gaming'],
                                ['img' => 'premium-computer-parts-display-monitor-icon-3d-rendering-isolated-background_150525-4565.png', 'text' => 'Màn hình đồ họa', 'slug' => 'man-hinh-do-hoa'],
                                ['img' => 'laptop-gaming-3d-icon-png-download-11431625.webp', 'text' => 'Laptop Gaming', 'slug' => 'laptop-gaming'],
                                ['img' => 'audio-icon-concept-with-3d-cartoon-style-headphone-and-blue-speaker-3d-illustration-png.png', 'text' => 'Âm thanh & Loa', 'slug' => 'am-thanh-loa'],
                                ['img' => 'ai-gaming-mouse-pad-3d-icon-png-download-jpg-13387054.webp', 'text' => 'Lót chuột Gear', 'slug' => 'lot-chuot-gear'],
                                ['img' => 'keycap-p-3d-icon-png-download-13964981.png', 'text' => 'Keycaps & Switch', 'slug' => 'keycaps-switch'],
                                ['img' => 'gaming-chair-3d-illustration-office-equipment-icon-png.png', 'text' => 'Ghế công thái học', 'slug' => 'ghe-cong-thai-hoc'],
                            ];
                        @endphp
                        @foreach ($sideCats as $cat)
                        <a href="{{ route('categories.show', $cat['slug']) }}" class="category-item-elite px-3">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('images/icon/' . $cat['img']) }}" alt="{{ $cat['text'] }}">
                                <span>{{ $cat['text'] }}</span>
                            </div>
                            <i class="fas fa-chevron-right xx-small opacity-30"></i>
                        </a>
                        @endforeach
                        
                        <div class="mx-3 my-2 border-top border-light opacity-50"></div>
                        
                        <a href="#" class="category-item-elite px-3 text-danger fw-black border-bottom-0 sale-highlight">
                            <div class="d-flex align-items-center justify-content-between w-100">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ asset('images/icon/pngtree-3d-lightning-icon-flash-sale-listrik-petir-png-image_17854619.webp') }}" alt="Sale" class="flash-pulse">
                                    <span>SĂN DEAL HOT</span>
                                </div>
                                <img src="{{ asset('images/icon/fire-3d-icon-png-download-12328451.png') }}" alt="Fire" style="width: 20px; height: 20px; object-fit: contain; opacity: 0.9;">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openGlobalSpotlight() {
            const globalMenu = document.getElementById('globalSpotlightMenu');
            const overlay = document.getElementById('sidebarOverlayElite');
            
            if(overlay) overlay.classList.add('active');
            if(globalMenu) globalMenu.classList.add('active');
        }

        function closeHeroSidebarHighlight() {
            const globalMenu = document.getElementById('globalSpotlightMenu');
            const overlay = document.getElementById('sidebarOverlayElite');
            
            if(globalMenu) globalMenu.classList.remove('active');
            if(overlay) overlay.classList.remove('active');
        }

        // 🛡️ PREMIUM LOGOUT CONFIRMATION
        document.addEventListener('click', function(e) {
            const logoutLink = e.target.closest('.confirm-logout-app');
            if (logoutLink) {
                e.preventDefault();
                Swal.fire({
                    title: 'Đăng xuất?',
                    text: 'Bạn có chắc chắn muốn thoát khỏi phiên làm việc này?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0f172a',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Có, đăng xuất',
                    cancelButtonText: 'Ở lại',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0',
                        confirmButton: 'rounded-pill px-4 fw-bold',
                        cancelButton: 'rounded-pill px-4 fw-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('logout-form').submit();
                    }
                });
            }
        });

        // 🛒 ELITE CLEAR CART CONFIRMATION
        document.addEventListener('click', function(e) {
            const clearLink = e.target.closest('.confirm-clear-cart');
            if (clearLink) {
                e.preventDefault();
                Swal.fire({
                    title: 'Làm trống giỏ hàng?',
                    text: 'Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng không?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Có, làm trống ngay',
                    cancelButtonText: 'Quay lại',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-4 shadow-lg border-0',
                        confirmButton: 'rounded-pill px-4 fw-bold',
                        cancelButton: 'rounded-pill px-4 fw-bold'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = clearLink.href;
                    }
                });
            }
        });
    </script>

    <div class="elite-toast-container" id="eliteToastContainer"></div>

    <script>
        function showEliteToast(message, type = 'success') {
            const container = document.getElementById('eliteToastContainer');
            const toast = document.createElement('div');
            toast.className = 'elite-toast';
            toast.innerHTML = `
                <div class="elite-toast-icon">
                    <i class="fas ${type === 'success' ? 'fa-check' : 'fa-info-circle'}"></i>
                </div>
                <div class="elite-toast-content">
                    <div class="small fw-bold text-white-50">THÔNG BÁO</div>
                    <div class="fw-bold">${message}</div>
                </div>
            `;
            container.appendChild(toast);
            setTimeout(() => toast.classList.add('active'), 100);
            setTimeout(() => {
                toast.classList.remove('active');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // --- SESSION TOAST TRIGGER ---
        function triggerSessionToasts() {
            @if(session('success'))
                showEliteToast("{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                showEliteToast("{{ session('error') }}", 'error');
            @endif
            @if($errors->any())
                @foreach($errors->all() as $error)
                    showEliteToast("{{ $error }}", 'error');
                @endforeach
            @endif
        }
        document.addEventListener('DOMContentLoaded', triggerSessionToasts);

        // Global Newsletter Handler
        document.getElementById('globalNewsletterForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = document.getElementById('btnGlobalSubscribe');
            const msg = document.getElementById('globalNewsletterMsg');
            const emailInput = this.querySelector('input[name="email"]');
            
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            
            fetch('/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: emailInput.value })
            })
            .then(response => response.json())
            .then(data => {
                msg.style.display = 'block';
                msg.textContent = data.message;
                msg.style.color = data.status === 'success' ? '#10b981' : '#f87171';
                
                if (data.status === 'success') {
                    emailInput.value = '';
                    setTimeout(() => {
                        msg.style.display = 'none';
                    }, 5000);
                }
            })
            .catch(error => {
                msg.style.display = 'block';
                msg.textContent = 'Đã có lỗi xảy ra. Vui lòng thử lại.';
                msg.style.color = '#f87171';
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = 'Gửi';
            });
        });

        async function addToCartElite(productId, url, event, imgUrl, redirect = false) {
            console.log('🛒 Adding to cart:', productId, url);
            if (event) event.preventDefault();
            
            const btn = event ? event.currentTarget : null;
            
            // Animation Fly
            if (btn && imgUrl) {
                const cartIcon = document.querySelector('.btn-cart-elite');
                if (cartIcon) {
                    const flyingImg = document.createElement('img');
                    flyingImg.src = imgUrl;
                    flyingImg.className = 'flying-cart-icon';
                    
                    const rect = btn.getBoundingClientRect();
                    flyingImg.style.left = rect.left + 'px';
                    flyingImg.style.top = rect.top + 'px';
                    document.body.appendChild(flyingImg);
                    
                    setTimeout(() => {
                        const cartRect = cartIcon.getBoundingClientRect();
                        flyingImg.style.left = (cartRect.left + 10) + 'px';
                        flyingImg.style.top = (cartRect.top + 10) + 'px';
                        flyingImg.style.transform = 'scale(0.1)';
                        flyingImg.style.opacity = '0';
                    }, 50);
                    
                    setTimeout(() => {
                        flyingImg.remove();
                        cartIcon.classList.add('cart-shake-anim');
                        setTimeout(() => cartIcon.classList.remove('cart-shake-anim'), 500);
                    }, 1000);
                }
            }

            // AJAX call
            try {
                const response = await fetch(url, {
                    method: 'GET',
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                console.log('✅ Cart Response:', data);
                
                if (data.success) {
                    const badge = document.getElementById('cartBadgeCount');
                    if (badge) badge.innerText = data.cart_count;
                    showEliteToast(data.message);
                    if (redirect) {
                        window.location.href = '/checkout';
                    }
                }
            } catch (error) {
                console.error('❌ Error adding to cart:', error);
                showEliteToast('Có lỗi xảy ra, vui lòng thử lại!', 'error');
            }
        }
    </script>
    <!-- Zalo Floating Button -->
    @unless(Route::is('login', 'register', 'password.*'))
    <a href="https://zalo.me/0337654252" target="_blank" class="zalo-float">
        <div class="zalo-pulse"></div>
        <img src="{{ asset('images/zalo_icon.png') }}" alt="Zalo Chat">
    </a>

    <!-- AI Chat Button -->
    <a href="javascript:void(0)" class="ai-chat-float" onclick="toggleAIChat()">
        <div class="ai-pulse"></div>
        <img src="{{ asset('images/ai_robot.png') }}" alt="AI" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
    </a>

    <!-- AI Chat Window -->
    <div class="ai-chat-window" id="aiChatWindow">
        <div class="ai-chat-header">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle overflow-hidden border border-2 border-warning border-opacity-50 shadow-sm" style="width: 45px; height: 45px;">
                    <img src="{{ asset('images/ai_robot.png') }}" alt="AI" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div>
                    <div class="fw-bold small">Elite Assistant</div>
                    <div class="xx-small opacity-75">AI trợ giúp 24/7</div>
                </div>
            </div>
            <button onclick="toggleAIChat()" class="btn-close btn-close-white small border-0 shadow-none"></button>
        </div>
        <div class="ai-chat-body" id="aiChatBody">
            <div class="ai-msg ai-msg-bot shadow-sm animate__animated animate__fadeInUp">
                Xin chào! Tôi là trợ lý AI của <b>DDH Electronics</b>. Tôi có thể giúp bạn tìm kiếm sản phẩm hoặc tư vấn kỹ thuật. Bạn cần giúp gì ạ?
            </div>
        </div>
        <div class="ai-chat-footer shadow-lg">
            <input type="text" id="aiInput" placeholder="Nhập tin nhắn..." onkeypress="if(event.key === 'Enter') sendAIMessage()">
            <button onclick="sendAIMessage()" class="shadow-sm">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
    @endunless

    <script>
        function toggleAIChat() {
            const window = document.getElementById('aiChatWindow');
            window.classList.toggle('active');
            if(window.classList.contains('active')) {
                document.getElementById('aiInput').focus();
            }
        }

        async function sendAIMessage() {
            const input = document.getElementById('aiInput');
            const chatBody = document.getElementById('aiChatBody');
            const text = input.value.trim();
            
            if(!text) return;

            // User Message
            addMessage(text, 'user');
            input.value = '';

            // Loading Indicator
            const loaderId = 'loader-' + Date.now();
            const loader = document.createElement('div');
            loader.id = loaderId;
            loader.className = 'typing-indicator ms-2';
            loader.innerText = 'Elite AI đang suy nghĩ...';
            chatBody.appendChild(loader);
            chatBody.scrollTop = chatBody.scrollHeight;

            try {
                const response = await fetch('/ai-chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: text })
                });
                
                const data = await response.json();
                loader.remove();
                
                // Trả về reply từ Gemini
                addMessage(data.reply || "Xin lỗi, tôi không thể trả lời lúc này.", 'bot');
                
            } catch (error) {
                console.error('❌ AI Chat Error:', error);
                loader.remove();
                addMessage("Có lỗi kết nối với hệ thống AI. Bạn vui lòng thử lại nhé!", 'bot');
            }
        }

        function addMessage(text, side) {
            const chatBody = document.getElementById('aiChatBody');
            const msgDiv = document.createElement('div');
            msgDiv.className = `ai-msg ai-msg-${side} shadow-sm`;
            msgDiv.innerHTML = text;
            chatBody.appendChild(msgDiv);
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    </script>

    <!-- ELITE LOADING OVERLAY -->
    <div id="elite-loading-overlay">
        <div class="elite-loader-content flex-column">
            <div class="elite-spinner mb-3"></div>
            <div class="loader-text-elite">Đang tải dữ liệu...</div>
        </div>
    </div>

    <!-- MOBILE CATEGORY MENU (RIGHT TO LEFT FULL SCREEN) -->
    <div class="offcanvas offcanvas-end w-100 border-0" tabindex="-1" id="offcanvasCategory">
        <div class="offcanvas-header bg-dark text-white p-4">
            <h5 class="offcanvas-title fw-bold text-uppercase" style="letter-spacing: 1px;"><i class="fas fa-bars text-warning me-2"></i> Danh mục sản phẩm</h5>
            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body p-0">
             @php
                $mobileCats = [
                    ['img' => 'vecteezy_ergonomic-mechanical-keyboard-with-custom-keycaps-for_60514914.png', 'text' => 'Bàn phím cơ', 'slug' => 'ban-phim-co'],
                    ['img' => 'gaming-mouse-3d-icon-png-download-9675855.webp', 'text' => 'Chuột Gaming', 'slug' => 'chuot-gaming'],
                    ['img' => 'premium-computer-parts-display-monitor-icon-3d-rendering-isolated-background_150525-4565.png', 'text' => 'Màn hình đồ họa', 'slug' => 'man-hinh-do-hoa'],
                    ['img' => 'laptop-gaming-3d-icon-png-download-11431625.webp', 'text' => 'Laptop Gaming', 'slug' => 'laptop-gaming'],
                    ['img' => 'audio-icon-concept-with-3d-cartoon-style-headphone-and-blue-speaker-3d-illustration-png.png', 'text' => 'Âm thanh & Loa', 'slug' => 'am-thanh-loa'],
                    ['img' => 'ai-gaming-mouse-pad-3d-icon-png-download-jpg-13387054.webp', 'text' => 'Lót chuột Gear', 'slug' => 'lot-chuot-gear'],
                    ['img' => 'keycap-p-3d-icon-png-download-13964981.png', 'text' => 'Keycaps & Switch', 'slug' => 'keycaps-switch'],
                    ['img' => 'gaming-chair-3d-illustration-office-equipment-icon-png.png', 'text' => 'Ghế công thái học', 'slug' => 'ghe-cong-thai-hoc'],
                ];
             @endphp
             <div class="d-flex flex-column">
                 @foreach ($mobileCats as $cat)
                 <a href="{{ route('categories.show', $cat['slug']) }}" class="px-4 py-3 d-flex align-items-center justify-content-between text-decoration-none border-bottom border-light mobile-cat-link">
                     <div class="d-flex align-items-center gap-3">
                         <div class="p-2 bg-light rounded-3">
                            <img src="{{ asset('images/icon/' . $cat['img']) }}" style="width: 35px; height: 35px; object-fit: contain;">
                         </div>
                         <span class="fw-bold text-dark">{{ $cat['text'] }}</span>
                     </div>
                     <i class="fas fa-chevron-right text-muted small"></i>
                 </a>
                 @endforeach

                 <div class="p-4 mt-2">
                    <a href="#" class="btn btn-danger w-100 rounded-4 py-3 fw-black sale-highlight-mobile">
                        <i class="fas fa-bolt me-2"></i> SĂN DEAL SIÊU HOT
                    </a>
                 </div>
             </div>
        </div>
    </div>

    <style>
        .mobile-cat-link:active {
            background-color: rgba(0,0,0,0.02);
        }
        .sale-highlight-mobile {
            background: linear-gradient(45deg, #ef4444, #f97316);
            border: none;
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
        }
    </style>

    @stack('scripts')
    @livewireScripts
    <script>
        // --- LIVE SEARCH WEB IMPLEMENTATION ---
        document.addEventListener('DOMContentLoaded', function() {
            const searchInputs = document.querySelectorAll('.search-input-elite, #mobileMenu input[type="text"]');
            
            searchInputs.forEach(input => {
                const wrapper = input.closest('.search-wrapper-elite') || input.parentElement;
                
                // Set wrapper relative for absolute positioning of results
                if (wrapper.classList.contains('search-wrapper-elite')) {
                    wrapper.style.position = 'relative';
                }

                const resultsBox = document.createElement('div');
                resultsBox.className = 'search-results-elite';
                wrapper.appendChild(resultsBox);

                let debounceTimer;

                input.addEventListener('input', function() {
                    const query = this.value.trim();
                    clearTimeout(debounceTimer);

                    if (query.length < 2) {
                        resultsBox.style.display = 'none';
                        return;
                    }

                    resultsBox.style.display = 'block';
                    resultsBox.innerHTML = '<div class="search-loading-elite"><i class="fas fa-spinner fa-spin me-2"></i> Đang tìm Gear...</div>';

                    debounceTimer = setTimeout(() => {
                        fetch(`/api/v1/products?search=${encodeURIComponent(query)}`)
                            .then(res => res.json())
                            .then(data => {
                                if (data.success && data.data.data.length > 0) {
                                    let html = '';
                                    data.data.data.forEach(product => {
                                        const price = new Intl.NumberFormat('vi-VN').format(product.sale_price || product.price) + 'đ';
                                        const imgUrl = product.image.startsWith('http') ? product.image : `/storage/${product.image.replace('public/', '')}`;
                                        
                                        html += `
                                            <a href="/products/${product.id}" class="search-result-item-elite">
                                                <img src="${imgUrl}" class="search-result-img" onerror="this.src='https://via.placeholder.com/50'">
                                                <div class="search-result-info">
                                                    <div class="search-result-name">${product.name}</div>
                                                    <div class="search-result-price">${price}</div>
                                                </div>
                                            </a>
                                        `;
                                    });
                                    resultsBox.innerHTML = html;
                                } else {
                                    resultsBox.innerHTML = '<div class="search-empty-elite"><i class="fas fa-box-open d-block fs-3 mb-2 opacity-20"></i> Không tìm thấy siêu phẩm nào khớp!</div>';
                                }
                            })
                            .catch(err => {
                                console.error('Live Search Error:', err);
                                resultsBox.style.display = 'none';
                            });
                    }, 400);
                });

                // Close on escape
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') resultsBox.style.display = 'none';
                });
            });

            // Close when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.search-wrapper-elite') && !e.target.closest('.search-results-elite')) {
                    document.querySelectorAll('.search-results-elite').forEach(box => box.style.display = 'none');
                }
            });
        });
    </script>
</body>
</html>