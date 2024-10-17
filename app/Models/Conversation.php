<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'writer_id'
    ];

    /**
     * A conversation belongs to an employer.
     */
    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function writer()
    {
        return $this->belongsTo(Writer::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
