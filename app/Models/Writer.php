<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Writer extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'writer';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        // 'balance' if you plan to store it directly in the future
        'profile_image',
        'bio',
        'skills',
        'profile_completion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'writer_id');
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'writer_id');
    }

    // Calculate writer balance dynamically
    public function getBalanceAttribute()
    {
        $totalPayments = $this->payments()->sum('amount');
        $totalWithdrawals = $this->withdrawals()->sum('amount');
        return $totalPayments - $totalWithdrawals;
    }
}
