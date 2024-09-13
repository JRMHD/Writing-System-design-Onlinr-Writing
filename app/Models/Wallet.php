<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'balance',
    ];

    // Relationship with Employer
    public function employer()
    {
        return $this->belongsTo(Employer::class, 'employer_id');
    }

    // Relationship with Deposit
    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'employer_id');
    }
}
