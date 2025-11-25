<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerDashboardController extends Controller
{
    /**
     * Display officer dashboard.
     */
    public function index()
    {
        $officer = Auth::user();
        
        // Statistics for the officer
        $assignedComplaints = Complaint::where('officer_id', $officer->id)->count();
        $pendingComplaints = Complaint::where('officer_id', $officer->id)
                                    ->where('status', 'in_progress')
                                    ->count();
        $resolvedComplaints = Complaint::where('officer_id', $officer->id)
                                     ->where('status', 'resolved')
                                     ->count();
        $recentComplaints = Complaint::with(['user', 'department'])
                                   ->where('officer_id', $officer->id)
                                   ->latest()
                                   ->take(5)
                                   ->get();

        // Department stats
        $departmentStats = Complaint::where('department_id', $officer->department_id)
                                  ->selectRaw('status, count(*) as count')
                                  ->groupBy('status')
                                  ->get();

        return view('officer.dashboard.index', compact(
            'assignedComplaints',
            'pendingComplaints',
            'resolvedComplaints',
            'recentComplaints',
            'departmentStats',
        ));
    }
}