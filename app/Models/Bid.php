<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['assignment_id', 'writer_id', 'amount', 'message'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function writer()
    {
        return $this->belongsTo(Writer::class, 'writer_id');
    }
}
