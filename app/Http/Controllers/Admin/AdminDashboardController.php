<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Department;
use App\Models\User;
use App\Models\Feedback;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        /* -------------------------------------------------------------
         | BASIC STATS
         ------------------------------------------------------------- */
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $inProgressComplaints = Complaint::where('status', 'in_progress')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();

        $totalDepartments = Department::count();

        $totalUsers = User::whereHas('roles', fn($q) => $q->where('name', 'user'))->count();
        $totalOfficers = User::role('officer')->count();
        $totalAdmins = User::role('admin')->count();
        $totalCitizens = User::role('citizen')->count();

        /* -------------------------------------------------------------
         | TODAY & THIS WEEK STATS
         ------------------------------------------------------------- */
        $todayComplaints = Complaint::whereDate('created_at', today())->count();
        $weekComplaints = Complaint::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])->count();

        /* -------------------------------------------------------------
         | RECENT COMPLAINTS
         ------------------------------------------------------------- */
        $recentComplaints = Complaint::with(['user', 'department'])
            ->latest()
            ->take(5)
            ->get();

        /* -------------------------------------------------------------
         | OLDEST PENDING COMPLAINTS
         ------------------------------------------------------------- */
        $oldestPending = Complaint::where('status', 'pending')
            ->orderBy('created_at')
            ->take(5)
            ->get();

        /* -------------------------------------------------------------
         | DEPARTMENT-WISE DISTRIBUTION
         ------------------------------------------------------------- */
        $departmentStats = Department::withCount([
            'complaints as total_complaints',
            'complaints as pending_complaints' => fn($q) => $q->where('status', 'pending'),
            'complaints as resolved_complaints' => fn($q) => $q->where('status', 'resolved'),
            'complaints as in_progress_complaints' => fn($q) => $q->where('status', 'in_progress'),
        ])
            ->get();

        /* -------------------------------------------------------------
         | TOP DEPARTMENTS BY ACTIVITY
         ------------------------------------------------------------- */
        $topDepartments = Department::withCount('complaints')
            ->orderByDesc('complaints_count')
            ->take(5)
            ->get();

        /* -------------------------------------------------------------
         | MONTHLY COMPLAINT TREND (LAST 6 MONTHS)
         ------------------------------------------------------------- */
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

        /* -------------------------------------------------------------
         | USER ROLE DISTRIBUTION (PIE CHART)
         ------------------------------------------------------------- */
        $roleStats = [
            'admins'   => $totalAdmins,
            'officers' => $totalOfficers,
            'citizens' => $totalCitizens,
        ];

        /* -------------------------------------------------------------
         | CITIZEN COMPLAINT COUNTS
         ------------------------------------------------------------- */
        $citizenStats = User::role('citizen')
            ->withCount('complaints')
            ->orderByDesc('complaints_count')
            ->take(10)
            ->get();

        /* -------------------------------------------------------------
         | OFFICER PERFORMANCE (RESOLVED COUNT)
         ------------------------------------------------------------- */
        $officers = User::role('officer')
            ->withCount([
                'assignedComplaints as workload_count',
                'resolvedComplaints as resolved_count',
                'feedbacks as total_feedbacks',
            ])
            ->with('feedbacks')
            ->get()
            ->map(function ($officer) {

                /* -------------------------------
                    1. RESOLUTION RATE
                --------------------------------*/
                $workload = max($officer->workload_count, 1);
                $officer->resolution_rate = round(($officer->resolved_count / $workload) * 100, 2);

                /* -------------------------------
                    2. FEEDBACK SCORE (average rating 1–5)
                --------------------------------*/
                if ($officer->total_feedbacks > 0) {
                    $avgRating = round($officer->feedbacks->avg('rating'), 2);
                    $officer->feedback_score = round(($avgRating / 5) * 100, 2);
                } else {
                    $officer->feedback_score = 50;
                }

                /* -------------------------------
                    3. RESOLUTION TIME SCORE
                --------------------------------*/
                $avgHours = Complaint::where('officer_id', $officer->id)
                    ->whereNotNull('resolved_at')
                    ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
                    ->value('avg_hours') ?? 0;

                if ($avgHours > 0) {
                    $officer->resolution_time_score = max(0, 100 - min($avgHours, 100));
                } else {
                    $officer->resolution_time_score = 50;
                }

                /* -------------------------------
                    4. FINAL SCORE WITH WEIGHTS
                --------------------------------*/
                $weightA = 0.4;  // resolution rate
                $weightB = 0.4;  // feedback
                $weightC = 0.2;  // resolution time
                $baseline = 10;  // ensures no zeros

                $officer->performance_score =
                    ($officer->resolution_rate * $weightA) +
                    ($officer->feedback_score * $weightB) +
                    ($officer->resolution_time_score * $weightC) +
                    $baseline;

                return $officer;
            });

        $topOfficers = $officers
            ->sortByDesc('performance_score')
            ->take(10)
            ->values();

        $lowOfficers = $officers
            ->sortBy('performance_score')   // ASCENDING
            ->take(10)
            ->values();


        /* -------------------------------------------------------------
         | FEEDBACK ANALYTICS
         ------------------------------------------------------------- */
        $feedbackStats = [
            'total_feedback' => Feedback::count(),
            'positive' => Feedback::where('rating', '>=', 4)->count(),
            'neutral'  => Feedback::where('rating', 3)->count(),
            'negative' => Feedback::where('rating', '<=', 2)->count(),
        ];

        /* -------------------------------------------------------------
         | AVERAGE RESOLUTION TIME (HRS)
         ------------------------------------------------------------- */
        $avgResolutionTime = Complaint::whereNotNull('resolved_at')
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
            ->value('avg_hours');

        /* -------------------------------------------------------------
         | NEW USERS TREND (LAST 6 MONTHS)
         ------------------------------------------------------------- */
        $userGrowth = User::selectRaw('
            YEAR(created_at) as year,
            MONTH(created_at) as month,
            COUNT(*) as count
        ')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        /* -------------------------------------------------------------
         | PRIORITY-BASED COMPLAINT STATS (if you have priority column)
         ------------------------------------------------------------- */
        $priorityStats = Complaint::selectRaw('priority, COUNT(*) as total')
            ->groupBy('priority')
            ->pluck('total', 'priority');

        /* -------------------------------------------------------------
         | DEPARTMENT-BASED COMPLAINT TO RESOLVED STATS (if you have priority column)
         ------------------------------------------------------------- */
        $departmentScores = Department::with([
            'complaints.feedbacks'
        ])->get()->map(function ($dept) {

            $total = $dept->complaints->count();
            $resolved = $dept->complaints->where('status', 'resolved')->count();

            /* -----------------------------------------
                1. RESOLUTION RATE (40%)
            ------------------------------------------*/
            $resolutionRate = $total > 0
                ? ($resolved / $total) * 100
                : 0; // zero activity → zero score


            /* -----------------------------------------
                2. FEEDBACK SCORE (40%)
            ------------------------------------------*/
            $ratings = $dept->complaints->flatMap->feedbacks->pluck('rating');

            if ($ratings->count() > 0) {
                $avgRating = $ratings->avg();     // 1–5
                $feedbackScore = ($avgRating / 5) * 100;
            } else {
                $feedbackScore = 0; // no feedback → zero
            }


            /* -----------------------------------------
                3. RESOLUTION SPEED SCORE (20%)
            ------------------------------------------*/
            $avgHours = Complaint::whereIn('id', $dept->complaints->pluck('id'))
                ->where('status', 'resolved')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
                ->value('avg_hours') ?? null;

            if ($avgHours === null) {
                $resolutionSpeed = 0; // no resolved → zero speed score
            } else {
                $resolutionSpeed = max(0, 100 - min($avgHours, 100));
            }


            /* -----------------------------------------
                4. FINAL SCORE
            ------------------------------------------*/
            $dept->performance_score =
                ($resolutionRate * 0.4) +
                ($feedbackScore * 0.4) +
                ($resolutionSpeed * 0.2);

            return $dept;
        });



        /* -------------------------------------------------------------
         | RETURN VIEW
         ------------------------------------------------------------- */
        return view('dashboard.admin.index', compact(
            'totalComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'resolvedComplaints',

            'totalDepartments',
            'totalUsers',
            'totalOfficers',
            'totalAdmins',

            'todayComplaints',
            'weekComplaints',

            'recentComplaints',
            'oldestPending',

            'departmentStats',
            'topDepartments',

            'monthlyTrend',
            'roleStats',

            'citizenStats',
            'topOfficers',
            'lowOfficers',

            'feedbackStats',
            'avgResolutionTime',

            'userGrowth',
            'priorityStats',

            'departmentScores',
        ));
    }
}
