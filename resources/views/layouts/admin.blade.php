<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') — DDH Electronics</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/favicon.jpg') }}">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Outfit:wght@400;600;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vn.js"></script>
    @livewireStyles

    <style>
        /* ═══════════════════════════════════════════
           DDH ADMIN DESIGN SYSTEM — PREMIUM OVERHAUL
           ═══════════════════════════════════════════ */
        :root {
            --ddh-navy:     #0d2137;
            --ddh-navy-mid: #132d47;
            --ddh-navy-light:#1a3d5c;
            --ddh-blue:     #005696;
            --ddh-orange:   #F7941E;
            --ddh-orange-glow: rgba(247, 148, 30, 0.35);
            --ddh-bg:       #f0f2f5;
            --ddh-card:     #ffffff;
            --ddh-text:     #1e293b;
            --ddh-muted:    #64748b;
            --ddh-border:   #e2e8f0;
            --ddh-success:  #10b981;
            --ddh-danger:   #ef4444;
            --ddh-warning:  #f59e0b;
            --ddh-info:     #3b82f6;
            --sidebar-w:    270px;
            --sidebar-collapsed-w: 80px;
            --topbar-h:     70px;
            --radius:       14px;
            --radius-sm:    10px;
            --shadow-card:  0 1px 3px rgba(0,0,0,.04), 0 6px 24px rgba(0,0,0,.06);
            --shadow-hover: 0 8px 30px rgba(0,0,0,.12);
            --transition:   all .25s cubic-bezier(.4,0,.2,1);
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--ddh-bg);
            color: var(--ddh-text);
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -webkit-overflow-scrolling: touch;
        }

        /* ── LAYOUT ────────────────────────────── */
        /* ── LAYOUT ────────────────────────────── */
        #admin-wrapper { 
            display: flex; 
            min-height: 100vh; 
            width: 100%;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch; 
        }

        /* ── SIDEBAR ───────────────────────────── */
        #sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--ddh-navy) 0%, var(--ddh-navy-mid) 100%);
            z-index: 9992;
            display: flex; flex-direction: column;
            overflow-y: auto; overflow-x: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-100%);
            visibility: hidden;
        }
        
        /* State when menu is toggled OPEN */
        body.sidebar-open #sidebar { transform: translateX(0); visibility: visible; }
        body.sidebar-open #sidebar-overlay { display: block; opacity: 1; }
        
        /* Desktop specific: push content when open and HIDE overlay */
        @media (min-width: 992px) {
            body.sidebar-open #main-content { padding-left: var(--sidebar-w); }
            body.sidebar-open #sidebar-overlay { display: none !important; }
        }

        @media (max-width: 991px) {
            #main-content { padding-left: 0; }
        }

        .sidebar-brand {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(255,255,255,.06);
            display: flex; align-items: center; justify-content: space-between;
        }
        .sidebar-brand img {
            height: 36px; width: auto;
            background: #ffffff;
            padding: 4px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: var(--transition);
        }
        .sidebar-brand:hover img { box-shadow: 0 0 12px var(--ddh-orange-glow); transform: translateY(-2px); }
        .sidebar-brand-text {
            font-family: 'Inter', sans-serif; font-size: 0.95rem; font-weight: 600;
            line-height: 1.1; color: #fff; letter-spacing: -0.2px;
            white-space: nowrap;
        }

        .sidebar-section-label {
            font-size: .65rem; text-transform: uppercase; letter-spacing: 2px;
            color: rgba(255,255,255,.25); padding: 22px 24px 8px; font-weight: 700;
        }

        .sidebar-nav { flex: 1; padding: 8px 12px; }

        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            padding: 11px 16px; margin: 2px 0;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.55);
            text-decoration: none; font-size: .855rem; font-weight: 500;
            transition: var(--transition);
            position: relative;
        }
        .sidebar-link i { width: 20px; text-align: center; font-size: .9rem; }
        .sidebar-link:hover {
            background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.9);
            transform: translateX(3px);
        }
        .sidebar-link.active {
            background: linear-gradient(135deg, var(--ddh-orange), #e8850a);
            color: #fff !important; font-weight: 600;
            box-shadow: 0 4px 15px var(--ddh-orange-glow);
        }
        .sidebar-link.active i { color: #fff; }

        .sidebar-link .badge-count {
            margin-left: auto; background: var(--ddh-danger);
            font-size: .65rem; padding: 3px 7px; border-radius: 20px;
            font-weight: 700; color: #fff;
        }

        .sidebar-close-btn {
            width: 32px; height: 32px; border-radius: 10px; background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1); color: rgba(255,255,255,0.5);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); cursor: pointer; padding: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .sidebar-close-btn:hover {
            background: var(--ddh-orange); color: white; border-color: var(--ddh-orange);
            transform: rotate(90deg) scale(1.1); box-shadow: 0 4px 12px var(--ddh-orange-glow);
        }
        .sidebar-close-btn i { font-size: 14px; }

        .sidebar-footer {
            padding: 16px; border-top: 1px solid rgba(255,255,255,.06);
        }
        .sidebar-footer .sidebar-link { color: rgba(255,255,255,.35); }
        .sidebar-footer .sidebar-link:hover { color: var(--ddh-danger); background: rgba(239,68,68,.08); }

        /* ── MAIN CONTENT ──────────────────────── */
        #main-content {
            flex: 1; display: flex; flex-direction: column;
            min-height: 100vh;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding-left: 0;
        }
        @media (max-width: 991px) {
            #main-content { padding-left: 0; }
        }

        /* ── TOP BAR ───────────────────────────── */
        .topbar {
            height: var(--topbar-h);
            background: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            display: flex; align-items: center;
            padding: 0;
            position: sticky; top: 0; z-index: 1030;
        }
        .topbar-container {
            display: flex; align-items: center; justify-content: space-between;
            width: 100%; max-width: 1400px; margin: 0 auto; padding: 0 20px;
            min-width: 0;
        }
        .admin-container {
            width: 100%; max-width: 1400px; margin: 0 auto; padding: 0 20px;
            transition: padding 0.3s ease;
        }
        .topbar-title {
            font-weight: 800; font-size: 1.15rem; color: var(--ddh-navy);
            display: flex; align-items: center; gap: 12px;
            animation: slideInLeft 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .topbar-title .page-icon {
            width: 40px; height: 40px; border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            display: flex; align-items: center; justify-content: center;
        }

        .topbar-actions { 
            display: flex; align-items: center; gap: 20px; 
            animation: slideInRight 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .topbar-actions .datetime-display {
            font-size: .75rem; color: var(--ddh-navy); font-weight: 700;
            background: rgba(19, 45, 71, 0.05);
            padding: 8px 16px; border-radius: 50px;
            display: flex; align-items: center; gap: 8px;
            border: 1px solid rgba(19, 45, 71, 0.08);
        }

        .admin-avatar-wrap {
            display: flex; align-items: center; gap: 12px;
            padding: 5px 15px 5px 5px;
            border-radius: 50px; background: #fff;
            border: 1px solid var(--ddh-border);
            transition: var(--transition); cursor: pointer;
            position: relative;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .admin-avatar-wrap:hover { 
            box-shadow: 0 5px 15px rgba(0,0,0,0.08); 
            transform: translateY(-1px);
            border-color: var(--ddh-orange);
        }
        .admin-avatar-container { position: relative; }
        .admin-avatar-wrap img {
            width: 36px; height: 36px; border-radius: 50%;
            object-fit: cover; border: 2px solid #fff;
        }
        .status-dot {
            position: absolute; bottom: 2px; right: 2px;
            width: 10px; height: 10px; background: var(--ddh-success);
            border: 2px solid #fff; border-radius: 50%;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
            animation: pulse-green 2s infinite;
        }
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        @keyframes slideInLeft { from { opacity: 0; transform: translateX(-20px); } to { opacity: 1; transform: translateX(0); } }
        @keyframes slideInRight { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }

        .admin-info .admin-name { font-size: .8rem; font-weight: 800; color: var(--ddh-navy); }
        .admin-info .admin-role { font-size: .65rem; color: var(--ddh-orange); font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }

        /* ── PAGE BODY ─────────────────────────── */
        .page-body { flex: 1; padding: 28px 30px 40px; }

        /* ── CARDS ──────────────────────────────── */
        .card {
            border: none !important; border-radius: var(--radius) !important;
            box-shadow: var(--shadow-card);
            transition: var(--transition);
            overflow: hidden;
        }
        .card:hover { box-shadow: var(--shadow-hover); }

        /* ── STAT CARDS ─────────────────────────── */
        .stat-card {
            border: none; border-radius: var(--radius); position: relative;
            overflow: hidden; padding: 24px; transition: var(--transition);
            box-shadow: var(--shadow-card);
        }
        .stat-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-hover); }
        .stat-card::before {
            content: ''; position: absolute; top: 0; right: -20px; bottom: 0;
            width: 100px; opacity: .05;
            background: var(--icon-color, var(--ddh-blue));
            border-radius: 50%;
            transform: scale(2.5);
        }
        .stat-card .stat-icon {
            width: 52px; height: 52px; border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.15rem; margin-bottom: 16px;
            transition: var(--transition);
        }
        .stat-card:hover .stat-icon { transform: scale(1.1) rotate(-5deg); }
        .stat-card .stat-label {
            font-size: .72rem; text-transform: uppercase; letter-spacing: 1.2px;
            color: var(--ddh-muted); font-weight: 700; margin-bottom: 4px;
        }
        .stat-card .stat-value { font-size: 1.65rem; font-weight: 800; color: var(--ddh-text); line-height: 1; }

        /* ── TABLE STYLING ──────────────────────── */
        .table { font-size: .875rem; }
        .table thead th {
            font-size: .72rem; text-transform: uppercase; letter-spacing: .8px;
            color: var(--ddh-muted); font-weight: 700; border-bottom-width: 1px;
            padding: 14px 16px; background: #fafbfc;
        }
        .table tbody td { padding: 14px 16px; vertical-align: middle; border-color: var(--ddh-border); }
        .table-hover tbody tr:hover { background: rgba(0,86,150,.02); }

        /* ── BUTTONS ────────────────────────────── */
        .btn { font-weight: 600; font-size: .85rem; transition: var(--transition); border-radius: var(--radius-sm); }
        .btn-ddh-primary {
            background: linear-gradient(135deg, var(--ddh-blue), var(--ddh-navy));
            border: none; color: #fff; padding: 10px 24px;
        }
        .btn-ddh-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,86,150,.3); color: #fff; }
        .btn-ddh-orange {
            background: linear-gradient(135deg, var(--ddh-orange), #e8850a);
            border: none; color: #fff; padding: 10px 24px;
        }
        .btn-ddh-orange:hover { transform: translateY(-2px); box-shadow: 0 6px 20px var(--ddh-orange-glow); color: #fff; }

        /* ── ALERTS ─────────────────────────────── */
        .admin-alert {
            border: none; border-radius: var(--radius-sm); padding: 14px 20px;
            font-size: .875rem; font-weight: 500; margin-bottom: 20px;
            display: flex; align-items: center; gap: 10px;
            animation: alertSlideIn .4s cubic-bezier(.4,0,.2,1);
        }
        .admin-alert-success { background: #ecfdf5; color: #065f46; border-left: 4px solid var(--ddh-success); }
        .admin-alert-error   { background: #fef2f2; color: #991b1b; border-left: 4px solid var(--ddh-danger); }
        .admin-alert-info    { background: #eff6ff; color: #1e40af; border-left: 4px solid var(--ddh-info); }

        @keyframes alertSlideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── BADGES ─────────────────────────────── */
        .badge-outline {
            background: transparent; border: 1.5px solid; font-weight: 600;
            padding: 4px 12px; border-radius: 20px; font-size: .72rem;
        }

        /* ── FORM CONTROLS ──────────────────────── */
        .form-control, .form-select {
            border-radius: var(--radius-sm); border-color: var(--ddh-border);
            font-size: .875rem; padding: 10px 14px;
            transition: var(--transition);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--ddh-orange);
            box-shadow: 0 0 0 3px var(--ddh-orange-glow);
        }
        .form-label { font-weight: 600; font-size: .82rem; color: var(--ddh-text); margin-bottom: 6px; }

        /* ── PAGINATION ELITE (Global System) ───── */
        .pagination-elite-wrapper { padding: 1.5rem 0; background: transparent; }
        .pagination-elite-wrapper nav { display: flex; width: 100%; align-items: center; justify-content: space-between; }
        .pagination-elite-wrapper .pagination { gap: 6px; margin: 0; display: flex; align-items: center; }
        .pagination-elite-wrapper .page-item .page-link {
            border: 1px solid var(--ddh-border);
            color: var(--ddh-navy);
            padding: 8px 16px;
            border-radius: var(--radius-sm) !important;
            font-weight: 700;
            font-size: .82rem;
            transition: var(--transition);
            background: #fff;
        }
        .pagination-elite-wrapper .page-item.active .page-link {
            background: linear-gradient(135deg, var(--ddh-orange), #e8850a) !important;
            border-color: var(--ddh-orange) !important;
            color: #fff !important;
            box-shadow: 0 4px 12px var(--ddh-orange-glow);
        }
        .pagination-elite-wrapper .page-item.disabled .page-link {
            background: #fafafa;
            color: #cbd5e1;
            border-color: #f1f5f9;
        }
        .pagination-elite-wrapper .page-item:not(.active):not(.disabled) .page-link:hover {
            border-color: var(--ddh-orange);
            color: var(--ddh-orange);
            background: rgba(247, 148, 30, 0.05);
            transform: translateY(-2px);
        }

        /* Responsive Pagination Elite */
        @media(max-width: 991px) {
            .pagination-elite-wrapper { padding: 1.2rem 0 !important; }
            .pagination-elite-wrapper nav { flex-direction: row !important; justify-content: center !important; }
            .pagination-elite-wrapper nav .d-sm-none { display: none !important; } 
            .pagination-elite-wrapper nav .d-sm-flex { display: flex !important; width: 100% !important; flex-direction: column !important; align-items: center; }
            .pagination-elite-wrapper .small.text-muted, .pagination-elite-wrapper .text-muted { display: none !important; } 

            .pagination-elite-wrapper .pagination { 
                display: flex !important; width: 100% !important; justify-content: center !important; 
                align-items: center !important; gap: 20px !important; overflow: visible !important;
            }
            
            .pagination-elite-wrapper .page-item:not(:first-child):not(:last-child):not(.active) { display: none !important; }
            
            .pagination-elite-wrapper .page-item:first-child .page-link, 
            .pagination-elite-wrapper .page-item:last-child .page-link { 
                width: 44px !important; height: 44px !important; border-radius: 50% !important;
                background: #fff !important; border: 1px solid var(--ddh-border) !important; color: var(--ddh-navy) !important;
                box-shadow: 0 4px 12px rgba(0,0,0,0.06) !important; font-size: 0 !important;
                position: relative; transition: var(--transition);
                display: flex !important; align-items: center; justify-content: center;
            }
            
            .pagination-elite-wrapper .page-item:first-child .page-link::after { 
                content: "\f053"; font-family: "Font Awesome 6 Free"; font-weight: 900; 
                font-size: 0.85rem; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);
            }
            .pagination-elite-wrapper .page-item:last-child .page-link::after { 
                content: "\f054"; font-family: "Font Awesome 6 Free"; font-weight: 900; 
                font-size: 0.85rem; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);
            }
            
            .pagination-elite-wrapper .page-item.active { flex: 0 0 auto; min-width: 100px; text-align: center; }
            .pagination-elite-wrapper .page-item.active .page-link { 
                background: #fff !important; color: var(--ddh-navy) !important; 
                font-weight: 700 !important; font-size: 0.85rem !important; border-radius: 50px !important;
                padding: 8px 20px !important; box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
                display: inline-flex !important; align-items: center; justify-content: center; gap: 5px;
                border: 1px solid var(--ddh-border) !important;
            }
            .pagination-elite-wrapper .page-item.active .page-link::before { 
                content: "Trang"; font-weight: 600; color: var(--ddh-muted); font-size: 0.8rem;
            }
        }

        /* ── SCROLLBAR ELITE (Synchronized) ────── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(0,0,0,0.02); }
        ::-webkit-scrollbar-thumb { 
            background: var(--ddh-orange); 
            border-radius: 10px; 
            transition: var(--transition);
        }
        ::-webkit-scrollbar-thumb:hover { background: #e8850a; }

        /* Sidebar specific scrollbar */
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 10px; }
        #sidebar::-webkit-scrollbar-thumb:hover { background: var(--ddh-orange); }

        /* ── RESPONSIVE ─────────────────────────── */
        @media(min-width: 992px) { .topbar-actions .datetime-display { display: flex; } }
        
        @media(max-width: 991px) {
            body { overflow-x: hidden; width: 100%; }
            #admin-wrapper { overflow-x: hidden; width: 100%; }
            #main-content { width: 100%; min-width: 0; }
            .page-body { padding: 15px 10px; width: 100%; }
            .topbar { height: 60px; width: 100%; }
            .topbar-container { padding: 0 12px; width: 100%; max-width: 100vw; }
            .admin-container { padding: 0; width: 100%; max-width: 100vw; }
            .topbar-title { gap: 8px; font-size: 0.9rem; }
            .topbar-title .page-icon { width: 32px; height: 32px; border-radius: 8px; }
            .topbar-title .page-icon img, .topbar-title .page-icon i { transform: scale(0.8); }
            
            .admin-avatar-wrap { 
                padding: 0; background: transparent; border: none; box-shadow: none; 
            }
            .admin-avatar-wrap img { width: 32px; height: 32px; }
            .topbar-actions { gap: 8px; }
        }

        @media(max-width: 575.98px) {
            .topbar-title span { display: none; }
            .datetime-display { font-size: 0.65rem !important; padding: 4px 8px !important; gap: 4px !important; }
            .datetime-display i { font-size: 0.75rem !important; }
        }

        /* ── FLATPICKR ELITE CUSTOM ────────────── */
        .flatpickr-calendar {
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
            border: 1px solid var(--ddh-border) !important;
            border-radius: 12px !important;
            padding: 5px;
        }
        .flatpickr-day.selected {
            background: var(--ddh-orange) !important;
            border-color: var(--ddh-orange) !important;
        }
        .flatpickr-day:hover { background: rgba(247, 148, 30, 0.1) !important; }
        .flatpickr-months .flatpickr-month { background: transparent !important; color: var(--ddh-navy) !important; fill: var(--ddh-navy) !important; }
        .flatpickr-current-month .flatpickr-monthDropdown-months { font-weight: 700 !important; }

        /* ── ANIMATIONS ─────────────────────────── */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
        .animate-in { animation: fadeInUp .5s cubic-bezier(.4,0,.2,1) both; }
        .delay-1 { animation-delay: .06s; }
        .delay-2 { animation-delay: .12s; }
        .delay-3 { animation-delay: .18s; }
        .delay-4 { animation-delay: .24s; }

        /* ── ELITE TOAST (ADMIN) ────────────────── */
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
            border-left: 4px solid var(--ddh-orange);
            transform: translateX(120%);
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            min-width: 320px;
        }

        .elite-toast.active {
            transform: translateX(0);
        }

        .elite-toast-icon {
            width: 40px;
            height: 40px;
            background: rgba(247, 148, 30, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ddh-orange);
            font-size: 18px;
            flex-shrink: 0;
        }

        .elite-toast-content .toast-label {
            font-size: 0.65rem;
            font-weight: 800;
            color: rgba(255,255,255,0.5);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .elite-toast-content .toast-msg {
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* ── SIDEBAR OVERLAY ELITE ──────────────── */
        #sidebar-overlay {
            position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);
            z-index: 9991; display: none; opacity: 0;
            transition: opacity 0.3s ease;
        }
        body.sidebar-open { overflow: hidden !important; }
        body.sidebar-open #sidebar-overlay { display: block; opacity: 1; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
    @stack('styles')
    @yield('styles')
</head>
<body>
    <div id="sidebar-overlay" onclick="toggleSidebar()"></div>
    <div id="admin-wrapper">
        <!-- ═══ SIDEBAR ═══ -->
        <nav id="sidebar">
            <div class="d-flex align-items-center justify-content-between pe-3 d-lg-none">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand text-decoration-none" wire:navigate>
                    <img src="{{ asset('images/logo.jpg') }}" alt="Admin Logo">
                </a>
                <button class="btn border-0 p-0 text-white opacity-50" onclick="toggleSidebar()">
                    <i class="fas fa-xmark fa-xl"></i>
                </button>
            </div>
            <div class="sidebar-brand d-none d-lg-flex justify-content-between align-items-center">
                <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none" style="min-width: 0;" wire:navigate>
                    <img src="{{ asset('images/logo.jpg') }}" alt="Admin Logo">
                    <span class="sidebar-brand-text">Bảng điều khiển</span>
                </a>
                <button class="btn sidebar-close-btn d-flex align-items-center justify-content-center flex-shrink-0" onclick="toggleSidebar()">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>

            <div class="sidebar-nav">
                @if(Auth::user()->is_admin)
                <div class="sidebar-section-label">Tổng quan</div>
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->is('admin') && !request()->is('admin/*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/dashboard.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Dashboard
                </a>
                @endif
 
                <div class="sidebar-section-label">Quản lý</div>
 
                @if(Auth::user()->is_admin)
                <a href="{{ route('admin.products') }}" class="sidebar-link {{ request()->is('admin/products*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/box.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Sản phẩm
                </a>
                <a href="{{ route('admin.categories') }}" class="sidebar-link {{ request()->is('admin/categories*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/categories.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Danh mục
                </a>
                <a href="{{ route('admin.brands') }}" class="sidebar-link {{ request()->is('admin/brands*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/brand_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Thương hiệu
                </a>
                <a href="{{ route('admin.slides') }}" class="sidebar-link {{ request()->is('admin/slides*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/slide_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Quản lý Slide
                </a>
                <a href="{{ route('admin.banners') }}" class="sidebar-link {{ request()->is('admin/banners*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/banner_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Quản lý Banner
                </a>
                @endif
 
                @if(Auth::user()->can_write_posts || Auth::user()->email === 'admin@ddh.com')
                <a href="{{ route('admin.posts') }}" class="sidebar-link {{ request()->is('admin/posts*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/newspaper_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Bài viết
                </a>
                @endif
                 
                @if(Auth::user()->is_admin)
                <a href="{{ route('admin.subscribers') }}" class="sidebar-link {{ request()->is('admin/subscribers*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/subcription_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Người đăng ký
                </a>
                @endif
 
                @if(Auth::user()->is_admin)
                <a href="{{ route('admin.orders') }}" class="sidebar-link {{ request()->is('admin/orders*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/invoice_icon.webp') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Đơn hàng
                </a>
                <a href="{{ route('admin.flash_sales') }}" class="sidebar-link {{ request()->is('admin/flash-sales*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/flash_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Flash Sale
                </a>
                <a href="{{ route('admin.coupons') }}" class="sidebar-link {{ request()->is('admin/coupons*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/discount_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Mã giảm giá
                </a>
 
                <div class="sidebar-section-label">Hệ thống</div>
 
                <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->is('admin/users*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/user_icon.webp') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Người dùng
                </a>
                <a href="{{ route('admin.reports') }}" class="sidebar-link {{ request()->is('admin/reports*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/chart_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Báo cáo
                </a>
                <a href="{{ route('admin.settings') }}" class="sidebar-link {{ request()->is('admin/settings*') ? 'active' : '' }}" wire:navigate>
                    <img src="{{ asset('images/icon/setting_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Cài đặt
                </a>
                @endif
            </div>

            <div class="sidebar-footer">
                <a href="/" class="sidebar-link" target="_blank">
                    <img src="{{ asset('images/icon/external_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Xem cửa hàng
                </a>
                <a href="{{ route('logout') }}" class="sidebar-link confirm-logout-app">
                    <img src="{{ asset('images/icon/logout_icon.png') }}" style="width: 18px; height: 18px; object-fit: contain; margin-right: 2px;"> Đăng xuất
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </nav>

        <!-- ═══ MAIN CONTENT ═══ -->
        <div id="main-content">
            <!-- Top Bar -->
            <header class="topbar">
                <div class="topbar-container">
                    <div class="topbar-title">
                        <button class="btn p-0 border-0 me-2" onclick="toggleSidebar()">
                            <i class="fas fa-bars-staggered fa-lg text-navy"></i>
                        </button>
                        <div class="page-icon">
                            @php $icon = $__env->yieldContent('page-icon', 'fas fa-th-large'); @endphp
                            @if(strpos($icon, '.') !== false)
                                <img src="{{ asset($icon) }}" style="width: 24px; height: 24px; object-fit: contain;">
                            @else
                                <i class="{{ $icon }}"></i>
                            @endif
                        </div>
                        <span>@yield('page-title', 'Dashboard')</span>
                    </div>

                    <div class="topbar-actions">
                        <div class="datetime-display d-flex" id="liveDateTimeBadge">
                            <i class="fas fa-calendar-day text-orange" style="color: var(--ddh-orange);"></i>
                            <span id="liveDateTimeText"></span>
                        </div>
                        
                        <a href="{{ route('admin.settings') }}" class="admin-avatar-wrap text-decoration-none">
                            <div class="admin-avatar-container">
                                <img src="{{ Auth::user()->avatar ? asset(Auth::user()->avatar) : (Auth::user()->social_avatar ?? asset('images/default-avatar.png')) }}" alt="Admin">
                                <span class="status-dot"></span>
                            </div>
                            <div class="admin-info d-none d-md-block">
                                <div class="admin-name">{{ Auth::user()->name }}</div>
                                <div class="admin-role">Administrator</div>
                            </div>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="page-body">
                <div class="admin-container">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- ELITE TOAST CONTAINER -->
    <div class="elite-toast-container" id="eliteToastContainer"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar Toggle Elite
        function toggleSidebar() {
            document.body.classList.toggle('sidebar-open');
        }

        // Live clock Enhanced
        function updateClock() {
            const now = new Date();
            const opts = { weekday: 'long', day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
            const el = document.getElementById('liveDateTimeText');
            if(el) el.textContent = now.toLocaleDateString('vi-VN', opts);
        }
        setInterval(updateClock, 1000);
        updateClock();

        // 🚪 ELITE LOGOUT CONFIRMATION
        document.addEventListener('click', function(e) {
            const logoutLink = e.target.closest('.confirm-logout-app');
            if (logoutLink) {
                e.preventDefault();
                Swal.fire({
                    title: 'Xác nhận thoát?',
                    text: 'Bạn có chắc chắn muốn đăng xuất tài khoản DDH Elite?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Đăng xuất ngay',
                    cancelButtonText: 'Quay lại',
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

        // 🛡️ PREMIUM CONFIRMATION DIALOG (SweetAlert2)
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.confirm-elite');
            if (!btn) return;
            
            e.preventDefault();
            const form = btn.closest('form');
            const prompt = btn.getAttribute('data-prompt') || 'Bạn có chắc chắn muốn thực hiện hành động này?';
            const type = btn.getAttribute('data-type') || 'warning'; // warning, danger, success
            const btnText = btn.getAttribute('data-btn-text') || 'Xác nhận';
            
            let color = '#F7941E'; // Default Elite Orange
            if (type === 'danger') color = '#ef4444';
            if (type === 'success') color = '#10b981';

            Swal.fire({
                title: 'Xác nhận hành động',
                text: prompt,
                icon: type,
                showCancelButton: true,
                confirmButtonColor: color,
                cancelButtonColor: '#64748b',
                confirmButtonText: btnText,
                cancelButtonText: 'Hủy',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0',
                    confirmButton: 'rounded-pill px-4 fw-bold',
                    cancelButton: 'rounded-pill px-4 fw-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // 🚀 ELITE TOAST SYSTEM (ADMIN)
        function showEliteToast(message, type = 'success') {
            const container = document.getElementById('eliteToastContainer');
            if(!container) return;
            
            const toast = document.createElement('div');
            toast.className = 'elite-toast';
            
            let iconClass = 'fa-check';
            if(type === 'error') iconClass = 'fa-circle-xmark';
            if(type === 'info') iconClass = 'fa-circle-info';
            if(type === 'warning') iconClass = 'fa-triangle-exclamation';

            toast.innerHTML = `
                <div class="elite-toast-icon">
                    <i class="fas ${iconClass}"></i>
                </div>
                <div class="elite-toast-content">
                    <div class="toast-label">Hệ thống</div>
                    <div class="toast-msg">${message}</div>
                </div>
            `;
            container.appendChild(toast);
            
            // Trigger animation
            setTimeout(() => toast.classList.add('active'), 100);
            
            // Auto remove
            setTimeout(() => {
                toast.classList.remove('active');
                setTimeout(() => toast.remove(), 500);
            }, 4000);
        }

        // Trigger session toasts
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showEliteToast("{{ session('success') }}", 'success');
            @endif
            @if(session('error'))
                showEliteToast("{{ session('error') }}", 'error');
            @endif
            @if(session('info'))
                showEliteToast("{{ session('info') }}", 'info');
            @endif
        });
    </script>
    @stack('scripts')
    @yield('scripts')
    @livewireScripts
</body>
</html>
