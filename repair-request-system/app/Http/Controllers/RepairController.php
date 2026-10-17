<?php

namespace App\Http\Controllers;

use App\Models\RepairCategory;
use App\Models\RepairRequest;
use App\Models\RepairUpdate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RepairController extends Controller
{
    public function index(Request $request): View
    {
        $query = RepairRequest::query()->with(['category', 'user'])->latest();

        if (! $request->user()->isAdmin()) {
            $query->where('user_id', $request->user()->id);
        }

        if ($search = trim((string) $request->query('search', ''))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('ticket_no', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        if ($status = $request->query('status')) {
            if (array_key_exists($status, RepairRequest::STATUSES)) {
                $query->where('status', $status);
            }
        }

        $repairs = $query->paginate(10)->withQueryString();
        $isAdmin = $request->user()->isAdmin();

        return view('repairs.index', compact('repairs', 'isAdmin'));
    }

    public function create(): View
    {
        $categories = RepairCategory::query()->where('is_active', true)->orderBy('name')->get();

        return view('repairs.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', Rule::exists('repair_categories', 'id')->where('is_active', true)],
            'title' => ['required', 'string', 'max:180'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'location' => ['required', 'string', 'max:180'],
            'urgency' => ['required', Rule::in(array_keys(RepairRequest::URGENCIES))],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'category_id.required' => 'กรุณาเลือกประเภทงานซ่อม',
            'description.min' => 'รายละเอียดต้องมีอย่างน้อย 10 ตัวอักษร',
            'image.max' => 'รูปภาพต้องมีขนาดไม่เกิน 4 MB',
            'image.image' => 'ไฟล์แนบต้องเป็นรูปภาพเท่านั้น',
        ]);

        $ticketNo = $this->makeTicketNumber();
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('repair-attachments', 'public')
            : null;

        $repair = RepairRequest::create([
            'ticket_no' => $ticketNo,
            'user_id' => $request->user()->id,
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'urgency' => $validated['urgency'],
            'status' => 'pending',
            'image_path' => $imagePath,
        ]);

        RepairUpdate::create([
            'repair_request_id' => $repair->id,
            'user_id' => $request->user()->id,
            'status' => 'pending',
            'note' => 'สร้างรายการแจ้งซ่อมใหม่',
        ]);

        return redirect()->route('repairs.show', $repair)->with('success', "ส่งคำขอแจ้งซ่อมเรียบร้อยแล้ว เลขที่คำขอ {$ticketNo}");
    }

    public function show(Request $request, RepairRequest $repair): View
    {
        abort_unless($request->user()->isAdmin() || $repair->user_id === $request->user()->id, 403);

        $repair->load(['category', 'user', 'assignedTo', 'updates.user']);
        $isAdmin = $request->user()->isAdmin();

        return view('repairs.show', compact('repair', 'isAdmin'));
    }

    public function cancel(Request $request, RepairRequest $repair): RedirectResponse
    {
        abort_unless($repair->user_id === $request->user()->id, 403);
        abort_unless($repair->status === 'pending', 422, 'ยกเลิกได้เฉพาะรายการที่ยังรอดำเนินการ');

        $repair->update(['status' => 'cancelled']);
        RepairUpdate::create([
            'repair_request_id' => $repair->id,
            'user_id' => $request->user()->id,
            'status' => 'cancelled',
            'note' => 'ผู้แจ้งซ่อมยกเลิกรายการ',
        ]);

        return redirect()->route('repairs.show', $repair)->with('success', 'ยกเลิกคำขอแจ้งซ่อมแล้ว');
    }

    private function makeTicketNumber(): string
    {
        do {
            $ticketNo = 'RR-'.now()->format('ymd').'-'.Str::upper(Str::random(5));
        } while (RepairRequest::where('ticket_no', $ticketNo)->exists());

        return $ticketNo;
    }
}
