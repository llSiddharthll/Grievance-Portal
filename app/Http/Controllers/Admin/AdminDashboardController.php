<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Department;
use App\Models\User;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $inProgressComplaints = Complaint::where('status', 'in_progress')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $totalDepartments = Department::count();
        $totalUsers = User::whereHas('roles', function($query) {
            $query->where('name', 'user');
        })->count();

        // Recent complaints
        $recentComplaints = Complaint::with(['user', 'department'])
            ->latest()
            ->take(5)
            ->get();

        // Department-wise complaint distribution
        $departmentStats = Department::withCount(['complaints as total_complaints',
            'complaints as pending_complaints' => function($query) {
                $query->where('status', 'pending');
            },
            'complaints as resolved_complaints' => function($query) {
                $query->where('status', 'resolved');
            }
        ])->get();

        // Monthly complaint trend
        $monthlyTrend = Complaint::selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as count,
            SUM(CASE WHEN status = "resolved" THEN 1 ELSE 0 END) as resolved_count
        ')
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get();

    

        return view('dashboard.admin.index', compact(
            'totalComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'totalDepartments',
            'totalUsers',
            'recentComplaints',
            'departmentStats',
            'monthlyTrend',
        ));
    }
}
