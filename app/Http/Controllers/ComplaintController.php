<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Start with user's complaints
        $complaints = Complaint::with('department')
            ->where('user_id', $user->id)
            ->latest();

        // Apply status filter
        if ($request->has('status') && $request->status != 'all') {
            $complaints->where('status', $request->status);
        }

        // Apply search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $complaints->where(function ($query) use ($search) {
                $query->where('tracking_id', 'LIKE', "%{$search}%")
                    ->orWhere('subject', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $complaints = $complaints->paginate(10);
        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();

        return view('complaints.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'department_id' => 'required|exists:departments,id',
            'file' => 'nullable|file|max:25600|mimes:jpg,jpeg,png,pdf,doc,docx,mp4,avi,mov,heic',
        ]);

        // Ensure file_path is always declared
        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {

            $file = $request->file('file');

            // stores to storage/app/public/complaint_files
            $filePath = $file->store('complaint_files', 'public');
            $fileType = $file->getClientMimeType();
        }

        // Tracking ID
        $trackingId = $this->generateTrackingId();

        Complaint::create([
            'tracking_id' => $trackingId,
            'subject'     => $validated['subject'],
            'description' => $validated['description'],
            'file_path'   => $filePath,   // Will now save!
            'file_type'   => $fileType,
            'status'      => 'pending',
            'user_id'     => Auth::id(),
            'department_id' => $validated['department_id'],
        ]);

        return redirect()
            ->route('complaints.thanks', $trackingId)
            ->with('success', 'Complaint registered successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        // Allow admin to view any complaint
        if (auth()->user()->hasRole('admin')) {
            return view('complaints.show', compact('complaint'));
        }

        // For normal users: allow only if complaint belongs to them
        if ($complaint->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('complaints.show', compact('complaint'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        //
    }

    /**
     * Generate unique tracking ID
     */
    private function generateTrackingId(): string
    {
        $date = now()->format('Ymd');
        // safer: use DB transaction to avoid duplicates or use sequences
        $seq = \DB::table('complaints')->whereDate('created_at', now())->count() + 1;
        return sprintf('GRV-%s-%04d', $date, $seq);
    }

    /**
     * Show thanks page after complaint registration
     */
    public function thanks($trackingId)
    {
        $complaint = Complaint::where('tracking_id', $trackingId)->firstOrFail();

        return view('complaints.thanks', compact('complaint'));
    }
}
