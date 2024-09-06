<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'word_count',
        'deadline',
        'budget',
    ];

    protected $casts = [
        'budget' => 'float',
        'word_count' => 'integer',
    ];

    // Accessor for deadline
    public function getDeadlineAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    // Mutator for deadline
    public function setDeadlineAttribute($value)
    {
        $this->attributes['deadline'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    // Relationship with Employer model
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    // Relationship with Bids
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    // Scope for open assignments
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    // Helper method to check if the assignment is open
    public function isOpen()
    {
        return $this->status === 'open';
    }

    // Add any other relationships or methods as necessary
}
