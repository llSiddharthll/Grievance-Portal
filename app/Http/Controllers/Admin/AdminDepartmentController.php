<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminDepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     */
    public function index(Request $request)
    {
        // Search filter
        $search = $request->get('search');
        
        $query = Department::withCount(['complaints', 'officers']);

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        $departments = $query->orderBy('name')->paginate(10);
        
        // Statistics for the dashboard
        $totalDepartments = Department::count();
        $totalComplaints = Department::withCount('complaints')->get()->sum('complaints_count');
        $totalOfficers = Department::withCount('officers')->get()->sum('officers_count');

        return view('admin.departments.index', compact(
            'departments',
            'totalDepartments',
            'totalComplaints',
            'totalOfficers',
            'search'
        ));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created department.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
        ]);

        Department::create($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department created successfully!');
    }

    /**
     * Display the specified department.
     */
    public function show(Department $department)
    {
        $department->load(['officers', 'complaints' => function($query) {
            $query->latest()->take(10);
        }]);

        // Statistics for this department
        $stats = [
            'total_complaints' => $department->complaints->count(),
            'pending_complaints' => $department->complaints->where('status', 'pending')->count(),
            'in_progress_complaints' => $department->complaints->where('status', 'in_progress')->count(),
            'resolved_complaints' => $department->complaints->where('status', 'resolved')->count(),
            'total_officers' => $department->officers->count(),
        ];

        return view('admin.departments.show', compact('department', 'stats'));
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified department.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments')->ignore($department->id),
            ],
        ]);

        $department->update($validated);

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified department.
     */
    public function destroy(Department $department)
    {
        // Check if department has complaints
        if ($department->complaints()->count() > 0) {
            return redirect()
                ->route('admin.departments.index')
                ->with('error', 'Cannot delete department that has complaints. Please reassign complaints first.');
        }

        // Check if department has officers
        if ($department->officers()->count() > 0) {
            return redirect()
                ->route('admin.departments.index')
                ->with('error', 'Cannot delete department that has officers. Please reassign officers first.');
        }

        $department->delete();

        return redirect()
            ->route('admin.departments.index')
            ->with('success', 'Department deleted successfully!');
    }

    /**
     * Get department statistics for dashboard
     */
    public function getDepartmentStats()
    {
        $departments = Department::withCount(['complaints', 'officers'])
            ->orderBy('complaints_count', 'desc')
            ->take(10)
            ->get();

        return response()->json($departments);
    }
}