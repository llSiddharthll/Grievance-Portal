<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'full_name',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function username()
    {
        return 'phone';
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function assignedComplaints()
    {
        return $this->hasMany(Complaint::class, 'officer_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    public function resolvedComplaints()
    {
        return $this->hasMany(Complaint::class, 'officer_id')
            ->where('status', 'resolved');
    }


    public function feedbacks()
    {
        return $this->hasManyThrough(
            Feedback::class,
            Complaint::class,
            'officer_id',   // Complaint.officer_id
            'complaint_id', // Feedback.complaint_id
            'id',
            'id'
        );
    }
}
