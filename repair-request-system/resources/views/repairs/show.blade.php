@extends('layouts.app')

@section('title', 'รายละเอียดคำขอ '.$repair->ticket_no)

@section('content')
<div class="back-row"><a class="back-link" href="{{ $isAdmin ? route('admin.repairs.index') : route('repairs.index') }}">← กลับไปหน้ารายการ</a></div>
<div class="detail-heading">
    <div><span class="section-kicker">REPAIR REQUEST DETAILS</span><div class="detail-title-row"><h1>{{ $repair->title }}</h1><span class="status-pill status-{{ str_replace('_', '-', $repair->status) }}">{{ \App\Models\RepairRequest::STATUSES[$repair->status] ?? $repair->status }}</span></div><p>เลขที่คำขอ <strong class="ticket-number">{{ $repair->ticket_no }}</strong> <span class="dot-separator">•</span> แจ้งเมื่อ {{ $repair->created_at->format('d/m/Y H:i') }} น.</p></div>
</div>
<div class="detail-grid">
    <div class="detail-main-column">
        <section class="panel detail-panel">
            <div class="panel-heading"><span class="panel-icon">▤</span><div><h2>ข้อมูลการแจ้งซ่อม</h2><p>รายละเอียดที่ผู้แจ้งส่งเข้ามา</p></div></div>
            <div class="detail-fields">
                <div class="detail-field"><span>ผู้แจ้งซ่อม</span><strong>{{ $repair->user->name ?? '-' }}</strong><small>{{ $repair->user->email ?? '' }}</small></div>
                <div class="detail-field"><span>ประเภทงานซ่อม</span><strong>{{ $repair->category->name ?? '-' }}</strong></div>
                <div class="detail-field"><span>สถานที่</span><strong>{{ $repair->location }}</strong></div>
                <div class="detail-field"><span>ระดับความเร่งด่วน</span><strong><span class="urgency urgency-{{ $repair->urgency }}">{{ \App\Models\RepairRequest::URGENCIES[$repair->urgency] ?? $repair->urgency }}</span></strong></div>
                <div class="detail-field detail-field-wide"><span>รายละเอียดปัญหา</span><p class="description-text">{{ $repair->description }}</p></div>
                @if($repair->image_path)
                    <div class="detail-field detail-field-wide"><span>รูปภาพประกอบ</span><a class="attachment-link" href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($repair->image_path) }}" target="_blank" rel="noopener noreferrer"><span>▧</span> เปิดไฟล์รูปภาพแนบ</a><img class="repair-attachment-preview" src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($repair->image_path) }}" alt="รูปภาพประกอบคำขอแจ้งซ่อม"></div>
                @endif
                @if($repair->admin_note && !$isAdmin)
                    <div class="detail-field detail-field-wide"><span>บันทึกจากผู้ดูแล</span><p class="admin-note-text">{{ $repair->admin_note }}</p></div>
                @endif
            </div>
            @if(!$isAdmin && $repair->status === 'pending')
                <div class="detail-footer"><p>หากส่งคำขอผิดรายการ สามารถยกเลิกได้ขณะที่ยังรอดำเนินการ</p><form method="POST" action="{{ route('repairs.cancel', $repair) }}" onsubmit="return confirm('ยืนยันยกเลิกคำขอแจ้งซ่อมนี้หรือไม่?')">@csrf<button type="submit" class="btn btn-danger-outline">ยกเลิกคำขอ</button></form></div>
            @endif
        </section>

        <section class="panel timeline-panel">
            <div class="panel-heading"><span class="panel-icon">◷</span><div><h2>ประวัติการดำเนินงาน</h2><p>บันทึกการเปลี่ยนแปลงตามลำดับเวลา</p></div></div>
            @if($repair->updates->isEmpty())
                <p class="muted-empty">ยังไม่มีประวัติการดำเนินงาน</p>
            @else
                <div class="timeline">
                    @foreach($repair->updates as $update)
                        <div class="timeline-item"><span class="timeline-dot {{ $loop->last ? 'timeline-dot-current' : '' }}"></span><div class="timeline-content"><div class="timeline-title-row"><strong>{{ $update->status ? (\App\Models\RepairRequest::STATUSES[$update->status] ?? $update->status) : 'บันทึกการดำเนินงาน' }}</strong><time>{{ $update->created_at->format('d/m/Y H:i') }} น.</time></div>@if($update->note)<p>{{ $update->note }}</p>@endif<small>โดย {{ $update->user->name ?? 'ระบบ' }}</small></div></div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <aside class="detail-side-column">
        @if($isAdmin)
            <section class="panel admin-update-panel">
                <div class="panel-heading"><span class="panel-icon">⚙</span><div><h2>จัดการคำขอ</h2><p>อัปเดตสถานะและบันทึก</p></div></div>
                <form method="POST" action="{{ route('admin.repairs.update', $repair) }}" class="form-stack">@csrf @method('PUT')
                    <div class="field"><label for="status">สถานะงาน</label><select id="status" name="status" required>@foreach(\App\Models\RepairRequest::STATUSES as $value => $label)<option value="{{ $value }}" @selected($repair->status === $value)>{{ $label }}</option>@endforeach</select>@error('status')<small class="field-error">{{ $message }}</small>@enderror</div>
                    <div class="field"><label for="admin_note">บันทึกจากผู้ดูแล</label><textarea id="admin_note" name="admin_note" rows="5" maxlength="3000" placeholder="แจ้งความคืบหน้า หรือรายละเอียดการแก้ไข">{{ old('admin_note', $repair->admin_note) }}</textarea>@error('admin_note')<small class="field-error">{{ $message }}</small>@enderror</div>
                    <button class="btn btn-primary btn-block" type="submit">บันทึกการเปลี่ยนแปลง</button>
                </form>
            </section>
        @else
            <section class="panel status-summary-panel"><div class="panel-heading"><span class="panel-icon">◷</span><div><h2>สถานะปัจจุบัน</h2><p>สรุปความคืบหน้าของคำขอ</p></div></div><span class="status-pill status-pill-large status-{{ str_replace('_', '-', $repair->status) }}">{{ \App\Models\RepairRequest::STATUSES[$repair->status] ?? $repair->status }}</span><p class="status-summary-copy">{{ $repair->status === 'completed' ? 'งานซ่อมนี้ดำเนินการเสร็จเรียบร้อยแล้ว' : ($repair->status === 'pending' ? 'คำขอของคุณเข้าสู่ระบบแล้ว กำลังรอผู้ดูแลตรวจสอบ' : ($repair->status === 'waiting_parts' ? 'งานซ่อมกำลังรออะไหล่หรืออุปกรณ์ที่จำเป็น' : ($repair->status === 'rejected' ? 'คำขอนี้ไม่ได้รับการอนุมัติ โปรดดูบันทึกจากผู้ดูแล' : ($repair->status === 'cancelled' ? 'คำขอนี้ถูกยกเลิกแล้ว' : 'ทีมงานกำลังดำเนินการกับคำขอของคุณ')))) }}</p>@if($repair->completed_at)<div class="completed-stamp">✓ เสร็จเมื่อ {{ $repair->completed_at->format('d/m/Y H:i') }} น.</div>@endif</section>
            <section class="info-card info-card-blue"><span class="info-icon">✦</span><h3>ต้องการแจ้งปัญหาเพิ่ม?</h3><p>หากเป็นปัญหาคนละรายการ ให้สร้างคำขอแจ้งซ่อมใหม่เพื่อให้ติดตามงานได้ชัดเจน</p><a class="text-link" href="{{ route('repairs.create') }}">แจ้งซ่อมใหม่ <span>→</span></a></section>
        @endif
        <div class="mini-summary"><span>สร้างรายการเมื่อ</span><strong>{{ $repair->created_at->format('d/m/Y H:i') }} น.</strong><span>อัปเดตล่าสุด</span><strong>{{ $repair->updated_at->format('d/m/Y H:i') }} น.</strong></div>
    </aside>
</div>
@endsection
