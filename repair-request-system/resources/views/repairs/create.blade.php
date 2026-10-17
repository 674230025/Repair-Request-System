@extends('layouts.app')

@section('title', 'แจ้งซ่อมใหม่')

@section('content')
<div class="page-heading"><span class="section-kicker">NEW REPAIR REQUEST</span><h1>แจ้งซ่อมใหม่</h1><p>กรอกรายละเอียดปัญหาให้ครบถ้วน เพื่อให้ทีมงานตรวจสอบและดำเนินการได้รวดเร็วขึ้น</p></div>
<div class="form-page-grid">
    <section class="panel form-panel">
        <div class="panel-heading"><span class="panel-icon">＋</span><div><h2>รายละเอียดคำขอ</h2><p>ช่องที่มีเครื่องหมาย <b>*</b> จำเป็นต้องกรอก</p></div></div>
        <form method="POST" action="{{ route('repairs.store') }}" enctype="multipart/form-data" class="form-stack">
            @csrf
            <div class="field"><label for="title">หัวข้อปัญหา <b>*</b></label><input id="title" name="title" type="text" value="{{ old('title') }}" maxlength="180" placeholder="เช่น คอมพิวเตอร์เปิดไม่ติด" required>@error('title')<small class="field-error">{{ $message }}</small>@enderror</div>
            <div class="form-row">
                <div class="field"><label for="category_id">ประเภทงานซ่อม <b>*</b></label><select id="category_id" name="category_id" required><option value="">เลือกประเภทงานซ่อม</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>@endforeach</select>@error('category_id')<small class="field-error">{{ $message }}</small>@enderror</div>
                <div class="field"><label for="urgency">ระดับความเร่งด่วน <b>*</b></label><select id="urgency" name="urgency" required>@foreach(\App\Models\RepairRequest::URGENCIES as $value => $label)<option value="{{ $value }}" @selected(old('urgency', 'normal') === $value)>{{ $label }}</option>@endforeach</select>@error('urgency')<small class="field-error">{{ $message }}</small>@enderror</div>
            </div>
            <div class="field"><label for="location">สถานที่ / ห้อง / หมายเลขครุภัณฑ์ <b>*</b></label><input id="location" name="location" type="text" value="{{ old('location') }}" maxlength="180" placeholder="เช่น อาคาร 3 ห้อง 302" required>@error('location')<small class="field-error">{{ $message }}</small>@enderror</div>
            <div class="field"><label for="description">รายละเอียดปัญหา <b>*</b></label><textarea id="description" name="description" rows="5" maxlength="5000" placeholder="อธิบายอาการที่พบ สิ่งที่ลองแก้ไขแล้ว และข้อมูลอื่นที่เป็นประโยชน์" required>{{ old('description') }}</textarea><small class="field-hint">อย่างน้อย 10 ตัวอักษร และไม่เกิน 5,000 ตัวอักษร</small>@error('description')<small class="field-error">{{ $message }}</small>@enderror</div>
            <div class="field"><label for="image">รูปภาพประกอบ <span class="optional-label">ไม่บังคับ</span></label><input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"> <small class="field-hint">รองรับ JPG, PNG, WEBP ขนาดไม่เกิน 4 MB</small>@error('image')<small class="field-error">{{ $message }}</small>@enderror</div>
            <div class="form-actions"><a class="btn btn-outline" href="{{ route('repairs.index') }}">ยกเลิก</a><button class="btn btn-primary" type="submit">ส่งคำขอแจ้งซ่อม <span>→</span></button></div>
        </form>
    </section>
    <aside class="side-info-column">
        <div class="info-card info-card-blue"><span class="info-icon">✦</span><h3>เขียนรายละเอียดให้ชัดเจน</h3><p>ระบุอาการที่พบ ช่วงเวลาที่เกิดปัญหา และสิ่งที่ลองทำไปแล้ว เพื่อช่วยให้แก้ไขได้ตรงจุด</p></div>
        <div class="info-card"><span class="info-icon info-icon-green">✓</span><h3>ติดตามได้ทุกเวลา</h3><p>หลังส่งคำขอ ระบบจะออกเลขที่คำขอให้โดยอัตโนมัติ ใช้เลขนี้ในการตรวจสอบสถานะได้</p></div>
        <div class="notice-box"><strong>ก่อนส่งคำขอ</strong><p>ตรวจสอบสถานที่และข้อมูลติดต่อให้ถูกต้อง และอย่าแนบรูปที่มีรหัสผ่านหรือข้อมูลส่วนตัวสำคัญ</p></div>
    </aside>
</div>
@endsection
