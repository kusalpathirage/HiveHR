<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'assigned_member',
        'project_id',
        'project_manager',
        'company_id',
    ];

    public function assignedMember(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_member');
    }

    public function parentProject(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function projectManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_manager');
    }

    public function parentCompany(): BelongsTo
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    protected static function booted()
    {
        static::saving(function ($task) {
            if (auth()->user()->role == 1) {
                $task->company_id = auth()->user()->id;
                $task->project_manager = auth()->user()->id;
            } else {
                $task->company_id = auth()->user()->selected_company;
                $task->project_manager = auth()->user()->id;
            }
        });

    }
}
