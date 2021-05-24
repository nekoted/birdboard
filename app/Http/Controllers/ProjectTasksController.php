<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate(["body" => "required"]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update', $task->project);

        $attributes = request()->validate(["body" => "required"]);

        $task->update($attributes);

        $method = request('completed') ? 'complete' : 'incomplete';

        $task->$method();

        return redirect($project->path());
    }
}
