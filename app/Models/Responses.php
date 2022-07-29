<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responses extends Model
{
    use HasFactory;

    protected $fillable = ['creator_id','vacancy_id', 'message'];

    public function job_vacancies()
    {
        return $this->belongsTo(JobVacancies::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
