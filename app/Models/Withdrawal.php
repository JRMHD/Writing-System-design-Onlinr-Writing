<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = ['writer_id', 'amount', 'status'];

    // Relationship with Writer
    public function writer()
    {
        return $this->belongsTo(Writer::class, 'writer_id');
    }
}
