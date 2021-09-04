<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftMessage extends Model
{
    use HasFactory;
    protected $table = 'gift_message';

    protected $fillable = [
        'msg_id',
        'sender_id',
        'receiver_id',
        'status'
    ];
    public function gift_msg(){
        return $this->hasOne(ThreadMessage::class, 'id', 'msg_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','sender_id');
    }
}
