<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Import the Deposit model
use App\Models\Deposit;

class Employer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'employer';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'profile_image',
        'bio',
        'profile_completion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship with Wallet
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'employer_id');
    }

    // Relationship with Assignments
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    // Relationship with Deposits
    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'employer_id');
    }

    // Calculate employer's wallet balance
    public function getBalanceAttribute()
    {
        return $this->wallet ? $this->wallet->balance : 0;
    }

    public function writers()
    {
        return $this->belongsToMany(Writer::class)->withPivot('status');
    }
}
