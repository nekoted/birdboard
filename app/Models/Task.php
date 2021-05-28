<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Activity;
use App\Traits\RecordsActivity;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, RecordsActivity;

    protected $guarded = [];
    protected $touches = ['project'];
    protected $casts = [
        'completed' => 'boolean',
    ];
    protected static $recordableEvents = ['created','deleted'];


    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return '/projects/' . $this->project->id . '/tasks/' . $this->id;
    }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->recordActivity('completed_task');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->recordActivity('incompleted_task');
    }
    
}
