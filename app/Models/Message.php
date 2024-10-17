<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender_type',
        'sender_id',
        'message',
        'content',
        'attachment',
        'file'
    ];

    /**
     * A message belongs to a conversation.
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * A message is sent by a user.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
