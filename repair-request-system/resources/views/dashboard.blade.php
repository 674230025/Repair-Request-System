@extends('layouts.app')

@section('title', 'ภาพรวม')

@section('content')
<div class="page-heading heading-with-action">
    <div><span class="section-kicker">{{ $isAdmin ? 'ADMIN OVERVIEW' : 'YOUR WORKSPACE' }}</span><h1>{{ $isAdmin ? 'ภาพรวมงานแจ้งซ่อม' : 'สวัสดี, '. $user->name }}</h1><p>{{ $isAdmin ? 'ติดตามและจัดการคำขอแจ้งซ่อมทั้งหมดในระบบ' : 'ยินดีต้อนรับกลับมา ติดตามสถานะคำขอแจ้งซ่อมของคุณได้ที่นี่' }}</p></div>
    <a class="btn btn-primary" href="{{ route('repairs.create') }}"><span>＋</span> แจ้งซ่อมใหม่</a>
</div>

<div class="stats-grid">
    <article class="stat-card stat-blue"><div class="stat-top"><span>รายการทั้งหมด</span><span class="stat-symbol">▤</span></div><strong>{{ number_format($stats['total']) }}</strong><small>คำขอแจ้งซ่อม</small></article>
    <article class="stat-card stat-amber"><div class="stat-top"><span>รอดำเนินการ</span><span class="stat-symbol">◷</span></div><strong>{{ number_format($stats['pending']) }}</strong><small>รอรับเรื่องหรือเริ่มซ่อม</small></article>
    <article class="stat-card stat-purple"><div class="stat-top"><span>กำลังดำเนินงาน</span><span class="stat-symbol">⚙</span></div><strong>{{ number_format($stats['in_progress']) }}</strong><small>รวมงานที่รออะไหล่</small></article>
    <article class="stat-card stat-green"><div class="stat-top"><span>ซ่อมเสร็จแล้ว</span><span class="stat-symbol">✓</span></div><strong>{{ number_format($stats['completed']) }}</strong><small>ปิดงานเรียบร้อย</small></article>
</div>

<div class="section-heading"><div><h2>{{ $isAdmin ? 'คำขอแจ้งซ่อมล่าสุด' : 'รายการแจ้งซ่อมล่าสุด' }}</h2><p>{{ $isAdmin ? 'ตรวจสอบคำขอที่เข้ามาล่าสุด' : 'ตรวจสอบความคืบหน้าของรายการของคุณ' }}</p></div><a class="text-link" href="{{ $isAdmin ? route('admin.repairs.index') : route('repairs.index') }}">ดูรายการทั้งหมด <span>→</span></a></div>
<div class="panel table-panel">
    @if ($recentRepairs->isEmpty())
        <div class="empty-state"><span class="empty-icon">▤</span><h3>ยังไม่มีรายการแจ้งซ่อม</h3><p>เริ่มต้นโดยกดปุ่ม “แจ้งซ่อมใหม่” เพื่อส่งคำขอแรกของคุณ</p><a class="btn btn-primary" href="{{ route('repairs.create') }}">＋ แจ้งซ่อมใหม่</a></div>
    @else
        <div class="table-responsive"><table class="data-table"><thead><tr><th>เลขที่คำขอ</th><th>หัวข้อปัญหา</th>@if($isAdmin)<th>ผู้แจ้ง</th>@endif<th>วันที่แจ้ง</th><th>สถานะ</th><th></th></tr></thead><tbody>
        @foreach($recentRepairs as $repair)
            <tr><td><span class="ticket-number">{{ $repair->ticket_no }}</span></td><td><span class="table-title">{{ $repair->title }}</span><small class="table-subtitle">{{ $repair->category->name ?? 'ไม่ระบุประเภท' }}</small></td>@if($isAdmin)<td>{{ $repair->user->name ?? '-' }}</td>@endif<td>{{ $repair->created_at->format('d/m/Y') }}<small class="table-subtitle">{{ $repair->created_at->format('H:i') }} น.</small></td><td><span class="status-pill status-{{ str_replace('_', '-', $repair->status) }}">{{ \App\Models\RepairRequest::STATUSES[$repair->status] ?? $repair->status }}</span></td><td><a class="icon-link" aria-label="ดูรายละเอียด" href="{{ $isAdmin ? route('admin.repairs.show', $repair) : route('repairs.show', $repair) }}">→</a></td></tr>
        @endforeach
        </tbody></table></div>
    @endif
</div>
@endsection
