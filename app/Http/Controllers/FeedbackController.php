<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the feedback based on user role.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        if ($user->hasRole('admin')) {
            // Admin sees all feedback
            $query = Feedback::with(['complaint', 'user', 'officer']);
        } elseif ($user->hasRole('officer')) {
            // Officer sees feedback from citizens (given to them) and their own feedback
            $query = Feedback::with(['complaint', 'user'])
                ->where(function($q) use ($user) {
                    $q->where('officer_id', $user->id) // Feedback received from citizens
                      ->orWhere('user_id', $user->id); // Feedback they gave
                });
        } else {
            // Citizen sees only their own feedback
            $query = Feedback::with(['complaint', 'officer'])
                ->where('user_id', $user->id);
        }

        // Search filter
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('complaint', function($q) use ($search) {
                    $q->where('tracking_id', 'LIKE', "%{$search}%")
                      ->orWhere('subject', 'LIKE', "%{$search}%");
                })
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

        // Rating filter
        if ($request->has('rating') && !empty($request->rating)) {
            $query->where('rating', $request->rating);
        }

        // Department filter (for admin and officer)
        if (($user->hasRole('admin') || $user->hasRole('officer')) && $request->has('department_id') && !empty($request->department_id)) {
            $query->whereHas('complaint', function($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }

        // Feedback type filter for officer
        if ($user->hasRole('officer') && $request->has('feedback_type') && !empty($request->feedback_type)) {
            if ($request->feedback_type === 'received') {
                $query->where('officer_id', $user->id)
                      ->where('user_id', '!=', $user->id);
            } elseif ($request->feedback_type === 'given') {
                $query->where('user_id', $user->id);
            }
        }

        $feedback = $query->latest()->paginate(10);
        
        // Get departments for filter (admin and officer)
        $departments = [];
        if ($user->hasRole('admin') || $user->hasRole('officer')) {
            $departments = \App\Models\Department::orderBy('name')->get();
        }

        // Get statistics for dashboard
        $stats = $this->getFeedbackStats();

        return view('feedback.index', compact('feedback', 'departments', 'stats'));
    }

    /**
     * Show the form for creating new feedback.
     */
    public function create(Complaint $complaint)
    {
        // Check if user has access to this complaint
        $user = Auth::user();
        
        if ($user->hasRole('officer')) {
            // Officer can only give feedback on complaints assigned to them
            if ($complaint->officer_id !== $user->id) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Citizen can only give feedback on their own complaints
            if ($complaint->user_id !== $user->id) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Check if feedback already exists for this complaint
        $existingFeedback = Feedback::where('complaint_id', $complaint->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingFeedback) {
            return redirect()->route('feedback.show', $existingFeedback)
                ->with('info', 'You have already submitted feedback for this complaint.');
        }

        return view('feedback.create', compact('complaint'));
    }

    /**
     * Store a newly created feedback.
     */
    public function store(Request $request, Complaint $complaint)
    {
        $user = Auth::user();
        
        // Check if user has access to this complaint
        if ($user->hasRole('officer')) {
            if ($complaint->officer_id !== $user->id) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            if ($complaint->user_id !== $user->id) {
                abort(403, 'Unauthorized action.');
            }
        }

        // Check if feedback already exists
        $existingFeedback = Feedback::where('complaint_id', $complaint->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingFeedback) {
            return redirect()->route('feedback.show', $existingFeedback)
                ->with('error', 'You have already submitted feedback for this complaint.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
            'file' => 'nullable|file|max:10240|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        // Handle file upload
        $filePath = null;
        $fileType = null;
        
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('feedback_files', 'public');
            $fileType = $file->getClientMimeType();
        }

        $feedbackData = [
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'status' => 'submitted',
            'complaint_id' => $complaint->id,
            'user_id' => $user->id,
        ];

        // If officer is giving feedback, set officer_id
        if ($user->hasRole('officer')) {
            $feedbackData['officer_id'] = $user->id;
        }

        $feedback = Feedback::create($feedbackData);

        return redirect()->route('feedback.show', $feedback)
                         ->with('success', 'Feedback submitted successfully!');
    }

    /**
     * Display the specified feedback.
     */
    public function show(Feedback $feedback)
    {
        $user = Auth::user();
        
        // Check if user has access to this feedback
        if ($user->hasRole('admin')) {
            // Admin can see all feedback
        } elseif ($user->hasRole('officer')) {
            // Officer can see feedback given to them and feedback they gave
            if ($feedback->officer_id !== $user->id && $feedback->user_id !== $user->id) {
                abort(403, 'Unauthorized action.');
            }
        } else {
            // Citizen can only see their own feedback
            if ($feedback->user_id !== $user->id) {
                abort(403, 'Unauthorized action.');
            }
        }

        $feedback->load(['complaint', 'user', 'officer']);

        return view('feedback.show', compact('feedback'));
    }

    /**
     * Get feedback statistics for dashboard.
     */
    private function getFeedbackStats()
    {
        $user = Auth::user();
        $stats = [];
        
        if ($user->hasRole('admin')) {
            // Admin stats - all feedback
            $stats['total_feedback'] = Feedback::count();
            $stats['average_rating'] = Feedback::avg('rating');
            $stats['low_ratings'] = Feedback::where('rating', '<=', 2)->count();
            $stats['high_ratings'] = Feedback::where('rating', '>=', 4)->count();
            
            // Recent low ratings for admin to review
            $stats['recent_low_ratings'] = Feedback::with(['complaint', 'user', 'officer'])
                ->where('rating', '<=', 2)
                ->latest()
                ->take(5)
                ->get();
                
        } elseif ($user->hasRole('officer')) {
            // Officer stats - feedback received from citizens
            $stats['total_received'] = Feedback::where('officer_id', $user->id)
                ->where('user_id', '!=', $user->id)
                ->count();
            $stats['average_rating'] = Feedback::where('officer_id', $user->id)
                ->where('user_id', '!=', $user->id)
                ->avg('rating');
            $stats['low_ratings'] = Feedback::where('officer_id', $user->id)
                ->where('user_id', '!=', $user->id)
                ->where('rating', '<=', 2)
                ->count();
            $stats['feedback_given'] = Feedback::where('user_id', $user->id)->count();
            
            // Recent low ratings for officer to address
            $stats['recent_low_ratings'] = Feedback::with(['complaint', 'user'])
                ->where('officer_id', $user->id)
                ->where('user_id', '!=', $user->id)
                ->where('rating', '<=', 2)
                ->latest()
                ->take(5)
                ->get();
                
        } else {
            // Citizen stats
            $stats['total_feedback'] = Feedback::where('user_id', $user->id)->count();
            $stats['average_rating_given'] = Feedback::where('user_id', $user->id)->avg('rating');
        }

        // Format average rating
        if (isset($stats['average_rating'])) {
            $stats['average_rating'] = round($stats['average_rating'], 1);
        }
        if (isset($stats['average_rating_given'])) {
            $stats['average_rating_given'] = round($stats['average_rating_given'], 1);
        }

        return $stats;
    }

    /**
     * Update feedback status (for admin).
     */
    public function updateStatus(Request $request, Feedback $feedback)
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'status' => 'required|in:submitted,reviewed,action_required',
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $feedback->update([
            'status' => $validated['status'],
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Feedback status updated successfully!');
    }
}       