<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // Relationship with Employer model (if you have one)
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    // Add additional relationships or methods if necessary
}
