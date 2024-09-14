<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['writer_id', 'employer_id', 'rating', 'remarks'];

    public function writer()
    {
        return $this->belongsTo(Writer::class);
    }

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }
}
