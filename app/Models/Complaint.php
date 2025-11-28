<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        "tracking_id",
        "subject",
        "description",
        "file_path",
        "file_type",
        "status",
        "user_id",
        "department_id",
        "officer_id",
        "resolution_notes",
        "resolved_at"
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function department()
    {
        return $this->belongsTo(Department::class, "department_id");
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function assignedComplaints()
    {
        return $this->hasMany(Complaint::class, 'officer_id');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'complaint_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'complaint_id');
    }
}
