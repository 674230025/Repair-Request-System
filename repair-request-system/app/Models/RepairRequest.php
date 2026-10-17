<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairRequest extends Model
{
    use HasFactory;

    public const STATUSES = [
        'pending' => 'รอดำเนินการ',
        'in_progress' => 'กำลังดำเนินการ',
        'waiting_parts' => 'รออะไหล่',
        'completed' => 'ซ่อมเสร็จแล้ว',
        'rejected' => 'ไม่อนุมัติ',
        'cancelled' => 'ยกเลิก',
    ];

    public const URGENCIES = [
        'low' => 'ไม่เร่งด่วน',
        'normal' => 'ปกติ',
        'high' => 'เร่งด่วน',
    ];

    protected $fillable = [
        'ticket_no',
        'user_id',
        'category_id',
        'title',
        'description',
        'location',
        'urgency',
        'status',
        'image_path',
        'admin_note',
        'assigned_to',
        'completed_at',
    ];

    protected function casts(): array
    {
        return ['completed_at' => 'datetime'];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(RepairCategory::class, 'category_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function updates()
    {
        return $this->hasMany(RepairUpdate::class, 'repair_request_id')->orderBy('created_at');
    }
}
