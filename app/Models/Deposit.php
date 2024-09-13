<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'amount',
    ];

    // Relationship with Employer
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
