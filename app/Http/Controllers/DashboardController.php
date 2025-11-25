<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Complaint;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $complaints = Complaint::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Stats calculations
        $totalComplaints = Complaint::where('user_id', $user->id)->count();
        $resolvedCount = Complaint::where('user_id', $user->id)
            ->where('status', 'Resolved')
            ->count();
        $inProgressCount = Complaint::where('user_id', $user->id)
            ->where('status', 'In Progress')
            ->count();
        $pendingCount = Complaint::where('user_id', $user->id)
            ->where('status', 'Pending')
            ->count();

        // Success rate calculation
        $successRate = $totalComplaints > 0 ? round(($resolvedCount / $totalComplaints) * 100) : 0;

        // Monthly trend data (last 6 months)
        $monthlyTrend = $this->getMonthlyTrend($user->id);

        // Status distribution for chart
        $statusDistribution = [
            'resolved' => $resolvedCount,
            'in_progress' => $inProgressCount,
            'pending' => $pendingCount,
        ];

        return view('dashboard.citizen.index', compact(
            'complaints',
            'totalComplaints',
            'resolvedCount',
            'inProgressCount',
            'pendingCount',
            'successRate',
            'monthlyTrend',
            'statusDistribution'
        ));
    }

    private function getMonthlyTrend($userId)
    {
        $months = [];
        $counts = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M');
            $monthStart = $month->copy()->startOfMonth();
            $monthEnd = $month->copy()->endOfMonth();
            
            $count = Complaint::where('user_id', $userId)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->count();
            
            $months[] = $monthName;
            $counts[] = $count;
        }
        
        return [
            'months' => $months,
            'counts' => $counts
        ];
    }

    public function editProfile()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'full_name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}