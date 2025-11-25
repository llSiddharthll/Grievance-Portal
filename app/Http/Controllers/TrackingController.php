<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Complaint;

class TrackingController extends Controller
{
    public function showTrackingForm()
    {
        return view('tracking.form');
    }

    public function trackComplaint(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string|max:255'
        ]);

        $complaint = Complaint::with(['department', 'officer'])
            ->where('tracking_id', $request->tracking_id)
            ->first();

        if (!$complaint) {
            return back()->with('error', 'No complaint found with this tracking ID. Please check and try again.');
        }

        return view('tracking.result', compact('complaint'));
    }

    public function trackComplaintPublic($tracking_id)
    {
        $complaint = Complaint::with(['department', 'officer'])
            ->where('tracking_id', $tracking_id)
            ->first();

        if (!$complaint) {
            return redirect()->route('tracking.form')->with('error', 'No complaint found with this tracking ID.');
        }

        return view('tracking.result', compact('complaint'));
    }
}