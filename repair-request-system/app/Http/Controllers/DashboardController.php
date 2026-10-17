<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $isAdmin = $user->isAdmin();
        $baseQuery = RepairRequest::query();

        if (! $isAdmin) {
            $baseQuery->where('user_id', $user->id);
        }

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $baseQuery)->whereIn('status', ['in_progress', 'waiting_parts'])->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
        ];

        $recentRepairs = (clone $baseQuery)
            ->with(['category', 'user'])
            ->latest()
            ->limit(6)
            ->get();

        return view('dashboard', compact('user', 'isAdmin', 'stats', 'recentRepairs'));
    }
}
