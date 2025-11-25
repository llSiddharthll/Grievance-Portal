<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminComplaintController extends Controller
{
    /**
     * Display a listing of the complaints.
     */
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'department', 'officer']);

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tracking_id', 'LIKE', "%{$search}%")
                  ->orWhere('subject', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('full_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Status filter
        if ($request->has('status') && !empty($request->status) && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Department filter
        if ($request->has('department_id') && !empty($request->department_id)) {
            $query->where('department_id', $request->department_id);
        }

        // Assignment filter
        if ($request->has('assignment') && !empty($request->assignment)) {
            if ($request->assignment === 'assigned') {
                $query->whereNotNull('officer_id');
            } elseif ($request->assignment === 'unassigned') {
                $query->whereNull('officer_id');
            }
        }

        $complaints = $query->latest()->paginate(10);
        $departments = Department::orderBy('name')->get();
        $totalComplaints = Complaint::count();
        $unassignedComplaints = Complaint::whereNull('officer_id')->count();

        return view('admin.complaints.index', compact(
            'complaints', 
            'departments', 
            'totalComplaints',
            'unassignedComplaints'
        ));
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        $complaint->load(['user', 'department', 'officer']);
        
        // Get available officers for this department
        $availableOfficers = User::whereHas('roles', function($query) {
            $query->where('name', 'officer');
        })
        ->where('department_id', $complaint->department_id)
        ->get();

        return view('admin.complaints.show', compact('complaint', 'availableOfficers'));
    }

    /**
     * Update complaint status.
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,rejected',
        ]);

        $complaint->update([
            'status' => $validated['status'],
        ]);

        return redirect()->back()
                         ->with('success', 'Complaint status updated successfully!');
    }

    /**
     * Assign complaint to officer.
     */
    public function assignOfficer(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'officer_id' => 'required|exists:users,id',
        ]);

        // Verify the user is an officer in the same department
        $officer = User::where('id', $validated['officer_id'])
                      ->whereHas('roles', function($query) {
                          $query->where('name', 'officer');
                      })
                      ->where('department_id', $complaint->department_id)
                      ->first();

        if (!$officer) {
            return redirect()->back()
                             ->with('error', 'Selected officer is not available for this department.');
        }

        $complaint->update([
            'officer_id' => $validated['officer_id'],
            'status' => 'in_progress',
        ]);

        return redirect()->back()
                         ->with('success', 'Complaint assigned to officer successfully!');
    }

    /**
     * Unassign complaint from officer.
     */
    public function unassignOfficer(Complaint $complaint)
    {
        $complaint->update([
            'officer_id' => null,
            'status' => 'pending',
        ]);

        return redirect()->back()
                         ->with('success', 'Complaint unassigned successfully!');
    }

    /**
     * Get officers by department for assignment.
     */
    public function getOfficersByDepartment(Department $department)
    {
        $officers = User::whereHas('roles', function($query) {
            $query->where('name', 'officer');
        })
        ->where('department_id', $department->id)
        ->select('id', 'full_name', 'email')
        ->get();

        return response()->json($officers);
    }

    /**
     * Update complaint department and auto-assign officer if needed.
     */
    public function updateDepartment(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $oldDepartmentId = $complaint->department_id;
        $complaint->update([
            'department_id' => $validated['department_id'],
            'officer_id' => null, // Remove assignment when department changes
        ]);

        return redirect()->back()
                         ->with('success', 'Complaint department updated successfully!');
    }
}