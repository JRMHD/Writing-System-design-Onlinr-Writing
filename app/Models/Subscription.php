<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    // Fillable fields for mass assignment
    protected $fillable = [
        'writer_id',
        'plan_name',
        'price',
        'phone',
        'start_date',
        'end_date',
    ];

    // Define the relationship to the writer
    public function writer()
    {
        return $this->belongsTo(Writer::class);
    }
}
