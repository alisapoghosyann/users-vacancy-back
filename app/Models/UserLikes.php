<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLikes extends Model
{
    use HasFactory;
    protected $fillable = ['name','user_id', 'liked_user_id'];

    public function users()
    {
        $this->belongsTo(User::class);
    }

}
