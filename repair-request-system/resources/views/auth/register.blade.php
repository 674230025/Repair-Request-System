@extends('layouts.app')

@section('title', 'สมัครสมาชิก')

@section('content')
<div class="auth-layout auth-layout-register">
    <section class="auth-promo">
        <div class="promo-orb orb-one"></div><div class="promo-orb orb-two"></div>
        <span class="eyebrow">YOUR SUPPORT SPACE</span>
        <h1>เริ่มต้นใช้งาน<br>ได้ในไม่กี่ขั้นตอน</h1>
        <p>สร้างบัญชีเพื่อแจ้งปัญหาและติดตามการซ่อมของคุณได้อย่างเป็นระบบ</p>
        <div class="promo-note"><span>✦</span><p>ข้อมูลคำขอของคุณจะแสดงให้คุณและผู้ดูแลระบบที่ได้รับอนุญาตเท่านั้น</p></div>
    </section>
    <section class="auth-card-wrap">
        <div class="auth-card">
            <div class="auth-heading"><span class="section-kicker">CREATE AN ACCOUNT</span><h2>สมัครสมาชิก</h2><p>กรอกข้อมูลด้านล่างเพื่อสร้างบัญชีใหม่</p></div>
            <form method="POST" action="{{ route('register.store') }}" class="form-stack">
                @csrf
                <div class="field"><label for="name">ชื่อ-นามสกุล</label><input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="ชื่อที่ใช้ในระบบ" autocomplete="name" maxlength="100" required autofocus>@error('name')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field"><label for="email">อีเมล</label><input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required>@error('email')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field"><label for="password">รหัสผ่าน</label><input id="password" name="password" type="password" placeholder="อย่างน้อย 8 ตัวอักษร" autocomplete="new-password" required>@error('password')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field"><label for="password_confirmation">ยืนยันรหัสผ่าน</label><input id="password_confirmation" name="password_confirmation" type="password" placeholder="กรอกรหัสผ่านอีกครั้ง" autocomplete="new-password" required></div>
                <button class="btn btn-primary btn-block" type="submit">สร้างบัญชี <span>→</span></button>
            </form>
            <p class="auth-switch">มีบัญชีอยู่แล้ว? <a href="{{ route('login') }}">เข้าสู่ระบบ</a></p>
        </div>
    </section>
</div>
@endsection
