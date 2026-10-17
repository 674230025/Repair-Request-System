<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function repairRequests()
    {
        return $this->hasMany(RepairRequest::class);
    }

    public function assignedRepairs()
    {
        return $this->hasMany(RepairRequest::class, 'assigned_to');
    }

    public function repairUpdates()
    {
        return $this->hasMany(RepairUpdate::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
