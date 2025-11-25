<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = ["rating", "comment", "file_path", "file_type", "status", "complaint_id", "user_id", "officer_id"];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, "complaint_id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}
