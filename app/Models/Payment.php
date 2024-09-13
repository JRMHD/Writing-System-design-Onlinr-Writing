<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['writer_id', 'assignment_id', 'amount'];

    // Relationship with Writer
    public function writer()
    {
        return $this->belongsTo(Writer::class, 'writer_id');
    }

    // Relationship with Assignment
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }
}
