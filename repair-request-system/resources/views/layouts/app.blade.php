<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ระบบแจ้งซ่อม') | Repair Desk</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                <span class="brand-mark">RD</span>
                <span><strong>Repair Desk</strong><small>ระบบแจ้งซ่อมออนไลน์</small></span>
            </a>
            @auth
                <nav class="main-nav" aria-label="เมนูหลัก">
                    <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">ภาพรวม</a>
                    <a class="{{ request()->routeIs('repairs.index', 'repairs.show') ? 'active' : '' }}" href="{{ route('repairs.index') }}">รายการแจ้งซ่อม</a>
                    <a class="{{ request()->routeIs('repairs.create') ? 'active' : '' }}" href="{{ route('repairs.create') }}">แจ้งซ่อมใหม่</a>
                    @if (auth()->user()->isAdmin())
                        <a class="{{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.repairs.index') }}">จัดการงานซ่อม</a>
                    @endif
                </nav>
                <div class="account-area">
                    <span class="avatar">{{ mb_substr(auth()->user()->name, 0, 1) }}</span>
                    <span class="account-name">{{ auth()->user()->name }}<small>{{ auth()->user()->isAdmin() ? 'ผู้ดูแลระบบ' : 'ผู้ใช้งาน' }}</small></span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-quiet btn-small" type="submit">ออกจากระบบ</button>
                    </form>
                </div>
            @else
                <div class="account-area guest-links">
                    <a href="{{ route('login') }}">เข้าสู่ระบบ</a>
                    <a class="btn btn-primary btn-small" href="{{ route('register') }}">สมัครสมาชิก</a>
                </div>
            @endauth
        </div>
    </header>

    <main class="page-shell">
        @if (session('success'))
            <div class="flash flash-success" role="status"><span>✓</span> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="flash flash-error" role="alert"><span>!</span> {{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="site-footer">
        <span>Repair Desk · ระบบแจ้งซ่อมออนไลน์</span>
        <span>Laravel + MySQL</span>
    </footer>
</body>
</html>
