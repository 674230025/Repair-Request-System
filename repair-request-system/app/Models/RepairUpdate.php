<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepairUpdate extends Model
{
    use HasFactory;

    protected $fillable = ['repair_request_id', 'user_id', 'status', 'note'];

    public function repairRequest()
    {
        return $this->belongsTo(RepairRequest::class, 'repair_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
