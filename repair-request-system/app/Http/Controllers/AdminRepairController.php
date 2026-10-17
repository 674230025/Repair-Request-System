<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\RepairUpdate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRepairController extends Controller
{
    public function index(Request $request): View
    {
        $query = RepairRequest::query()->with(['category', 'user'])->latest();

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('ticket_no', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->query('status')) {
            if (array_key_exists($status, RepairRequest::STATUSES)) {
                $query->where('status', $status);
            }
        }

        $repairs = $query->paginate(12)->withQueryString();
        $isAdmin = true;

        return view('repairs.index', compact('repairs', 'isAdmin'));
    }

    public function show(RepairRequest $repair): View
    {
        $repair->load(['category', 'user', 'assignedTo', 'updates.user']);
        $isAdmin = true;

        return view('repairs.show', compact('repair', 'isAdmin'));
    }

    public function update(Request $request, RepairRequest $repair): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(RepairRequest::STATUSES))],
            'admin_note' => ['nullable', 'string', 'max:3000'],
        ]);

        $oldStatus = $repair->status;
        $newStatus = $validated['status'];
        $note = trim((string) ($validated['admin_note'] ?? ''));

        $repair->update([
            'status' => $newStatus,
            'admin_note' => $note !== '' ? $note : null,
            'completed_at' => $newStatus === 'completed' ? ($repair->completed_at ?? now()) : null,
        ]);

        if ($note === '') {
            $note = $oldStatus !== $newStatus
                ? 'เปลี่ยนสถานะจาก '.(RepairRequest::STATUSES[$oldStatus] ?? $oldStatus).' เป็น '.(RepairRequest::STATUSES[$newStatus] ?? $newStatus)
                : 'อัปเดตข้อมูลรายการแจ้งซ่อม';
        }

        RepairUpdate::create([
            'repair_request_id' => $repair->id,
            'user_id' => $request->user()->id,
            'status' => $newStatus,
            'note' => $note,
        ]);

        return redirect()->route('admin.repairs.show', $repair)->with('success', 'บันทึกการเปลี่ยนแปลงเรียบร้อยแล้ว');
    }
}
