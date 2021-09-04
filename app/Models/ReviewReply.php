<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewReply extends Model
{
  protected $table = 'review_replies';
  protected $fillable = ['id', 'review_id', 'reply', 'created_at', 'updated_at'];
  protected $with = ['user'];
  public function user(){
      return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
