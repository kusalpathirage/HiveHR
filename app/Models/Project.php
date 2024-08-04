<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
//        'slug',
        'status',
        'project_leader',
        'company'
    ];

    public function projectLeader()
    {
        return $this->belongsTo(User::class, 'project_leader');
    }

    public function teamMembers()
    {
        return $this->belongsToMany(User::class, 'project_user');
    }

    public function ownerBy()
    {
        return $this->belongsTo(User::class, 'company');
    }

    protected static function booted()
    {
        static::saving(function ($project) {
            if (auth()->user()->role == 1) {
                $project->company = auth()->user()->id;
            } else {
                $project->company = auth()->user()->selected_company;
            }
        });
    }
}
