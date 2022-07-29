<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Maize\Markable\Markable;
use Maize\Markable\Models\Like;

class JobVacancies extends Model
{
    use HasFactory,SoftDeletes ,Markable;


    protected $fillable = ['user_id', 'title', 'description'];

    protected static $marks = [
        Like::class,
    ];

    public function users()
    {
        $this->belongsTo(User::class);
    }


    public function responses()
    {
        return $this->hasMany(Responses::class, 'vacancy_id');
    }
}
