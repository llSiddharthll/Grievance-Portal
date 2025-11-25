<?php

namespace App\Http\Controllers\Officer;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfficerComplaintController extends Controller
{
    /**
     * Display a listing of the complaints assigned to the officer.
     */
    public function index(Request $request)
    {
        $officer = Auth::user();
        
        $query = Complaint::with(['user', 'department'])
                         ->where('officer_id', $officer->id);

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

        $complaints = $query->latest()->paginate(10);


        return view('officer.complaints.index', compact('complaints'));
    }

    /**
     * Display the specified complaint.
     */
    public function show(Complaint $complaint)
    {
        // Ensure the complaint belongs to this officer
        if ($complaint->officer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $complaint->load(['user', 'department']);


        return view('officer.complaints.show', compact('complaint'));
    }

    /**
     * Mark complaint as resolved.
     */
    public function markAsResolved(Request $request, Complaint $complaint)
    {
        // Ensure the complaint belongs to this officer
        if ($complaint->officer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $complaint->update([
            'status' => 'resolved',
            'resolved_at' => now(),
        ]);

        return redirect()->route('officer.complaints.show', $complaint)
                         ->with('success', 'Complaint marked as resolved successfully!');
    }

    /**
     * Update complaint status.
     */
    public function updateStatus(Request $request, Complaint $complaint)
    {
        // Ensure the complaint belongs to this officer
        if ($complaint->officer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:in_progress,resolved',
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];

        if ($validated['status'] === 'resolved') {
            $updateData['resolved_at'] = now();
        }

        $complaint->update($updateData);

        return redirect()->route('officer.complaints.show', $complaint)
                         ->with('success', 'Complaint status updated successfully!');
    }
}