@extends('layouts.app')

@section('title', $isAdmin ? 'จัดการงานซ่อม' : 'รายการแจ้งซ่อม')

@section('content')
<div class="page-heading heading-with-action">
    <div><span class="section-kicker">{{ $isAdmin ? 'REPAIR MANAGEMENT' : 'REPAIR HISTORY' }}</span><h1>{{ $isAdmin ? 'จัดการงานซ่อม' : 'รายการแจ้งซ่อมของฉัน' }}</h1><p>{{ $isAdmin ? 'ค้นหา ตรวจสอบ และอัปเดตสถานะคำขอของผู้ใช้งาน' : 'ค้นหาและติดตามความคืบหน้าของคำขอที่คุณส่งไว้' }}</p></div>
    @if(!$isAdmin)<a class="btn btn-primary" href="{{ route('repairs.create') }}"><span>＋</span> แจ้งซ่อมใหม่</a>@endif
</div>

<div class="panel filter-panel">
    <form method="GET" action="{{ $isAdmin ? route('admin.repairs.index') : route('repairs.index') }}" class="filter-form">
        <div class="field filter-search"><label for="search">ค้นหา</label><div class="input-with-icon"><span>⌕</span><input id="search" type="search" name="search" value="{{ request('search') }}" placeholder="เลขที่คำขอ หรือหัวข้อปัญหา{{ $isAdmin ? ' หรือชื่อผู้แจ้ง' : '' }}"></div></div>
        <div class="field filter-status"><label for="status">สถานะ</label><select id="status" name="status"><option value="">ทุกสถานะ</option>@foreach(\App\Models\RepairRequest::STATUSES as $value => $label)<option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>@endforeach</select></div>
        <div class="filter-actions"><button class="btn btn-primary" type="submit">ค้นหา</button><a class="btn btn-outline" href="{{ $isAdmin ? route('admin.repairs.index') : route('repairs.index') }}">ล้างค่า</a></div>
    </form>
</div>

<div class="section-heading list-section-heading"><div><h2>{{ $repairs->total() }} รายการ</h2><p>แสดงรายการล่าสุดก่อน</p></div></div>
<div class="panel table-panel">
    @if($repairs->isEmpty())
        <div class="empty-state"><span class="empty-icon">⌕</span><h3>ไม่พบรายการแจ้งซ่อม</h3><p>ลองเปลี่ยนคำค้นหาหรือเลือกตัวกรองอื่น</p>@if(!$isAdmin)<a class="btn btn-primary" href="{{ route('repairs.create') }}">＋ แจ้งซ่อมใหม่</a>@endif</div>
    @else
        <div class="table-responsive"><table class="data-table"><thead><tr><th>เลขที่คำขอ</th><th>หัวข้อ / ประเภท</th>@if($isAdmin)<th>ผู้แจ้ง</th>@endif<th>สถานที่</th><th>ความเร่งด่วน</th><th>วันที่แจ้ง</th><th>สถานะ</th><th></th></tr></thead><tbody>
        @foreach($repairs as $repair)
            <tr>
                <td><span class="ticket-number">{{ $repair->ticket_no }}</span></td>
                <td><span class="table-title">{{ $repair->title }}</span><small class="table-subtitle">{{ $repair->category->name ?? 'ไม่ระบุประเภท' }}</small></td>
                @if($isAdmin)<td><span class="table-title">{{ $repair->user->name ?? '-' }}</span><small class="table-subtitle">{{ $repair->user->email ?? '' }}</small></td>@endif
                <td>{{ $repair->location }}</td>
                <td><span class="urgency urgency-{{ $repair->urgency }}">{{ \App\Models\RepairRequest::URGENCIES[$repair->urgency] ?? $repair->urgency }}</span></td>
                <td>{{ $repair->created_at->format('d/m/Y') }}<small class="table-subtitle">{{ $repair->created_at->format('H:i') }} น.</small></td>
                <td><span class="status-pill status-{{ str_replace('_', '-', $repair->status) }}">{{ \App\Models\RepairRequest::STATUSES[$repair->status] ?? $repair->status }}</span></td>
                <td><a class="icon-link" aria-label="เปิดรายละเอียด" href="{{ $isAdmin ? route('admin.repairs.show', $repair) : route('repairs.show', $repair) }}">→</a></td>
            </tr>
        @endforeach
        </tbody></table></div>
        @if($repairs->hasPages())<div class="pagination-wrap">{{ $repairs->links() }}</div>@endif
    @endif
</div>
@endsection
