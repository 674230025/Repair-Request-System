@extends('layouts.app')

@section('title', 'เข้าสู่ระบบ')

@section('content')
<div class="auth-layout">
    <section class="auth-promo">
        <div class="promo-orb orb-one"></div><div class="promo-orb orb-two"></div>
        <span class="eyebrow">REPAIR DESK / SUPPORT CENTER</span>
        <h1>แจ้งปัญหาได้ง่าย<br>ติดตามงานได้ทุกขั้นตอน</h1>
        <p>ส่งคำขอแจ้งซ่อมออนไลน์ ตรวจสอบสถานะ และดูประวัติการดำเนินงานได้จากที่เดียว</p>
        <div class="promo-points">
            <div><span class="promo-icon">01</span><span><strong>แจ้งซ่อมสะดวก</strong><small>บอกรายละเอียดและแนบรูปภาพประกอบ</small></span></div>
            <div><span class="promo-icon">02</span><span><strong>ติดตามสถานะ</strong><small>เห็นความคืบหน้าของคำขอแบบเป็นลำดับ</small></span></div>
            <div><span class="promo-icon">03</span><span><strong>มีประวัติย้อนหลัง</strong><small>เรียกดูเลขที่คำขอและบันทึกการซ่อมได้</small></span></div>
        </div>
    </section>
    <section class="auth-card-wrap">
        <div class="auth-card">
            <div class="auth-heading"><span class="section-kicker">WELCOME BACK</span><h2>เข้าสู่ระบบ</h2><p>กรอกข้อมูลเพื่อเข้าสู่พื้นที่ใช้งานของคุณ</p></div>
            <form method="POST" action="{{ route('login.store') }}" class="form-stack">
                @csrf
                <div class="field"><label for="email">อีเมล</label><input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="name@example.com" autocomplete="email" required autofocus>@error('email')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field"><label for="password">รหัสผ่าน</label><input id="password" name="password" type="password" placeholder="กรอกรหัสผ่าน" autocomplete="current-password" required>@error('password')<small class="field-error">{{ $message }}</small>@enderror</div>
                <label class="checkbox-line"><input type="checkbox" name="remember" value="1"> จดจำการเข้าสู่ระบบ</label>
                <button class="btn btn-primary btn-block" type="submit">เข้าสู่ระบบ <span>→</span></button>
            </form>
            <p class="auth-switch">ยังไม่มีบัญชี? <a href="{{ route('register') }}">สมัครสมาชิก</a></p>
        </div>
    </section>
</div>
@endsection
