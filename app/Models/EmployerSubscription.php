<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerSubscription extends Model
{
    use HasFactory;

    protected $fillable = ['employer_id', 'plan_name', 'price', 'start_date', 'end_date'];

    // An employer subscription belongs to an employer
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
