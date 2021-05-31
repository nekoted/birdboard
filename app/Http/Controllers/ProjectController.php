<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', ["projects" => $projects]);
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', ["project" => $project]);
    }

    public function create()
    {
        $project = new Project();
        return view('projects.create', ['project' => $project]);
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', ['project' => $project]);
    }

    public function store(Request $request)
    {
        $validated_datas = $this->validateRequest();

        $project = auth()->user()->projects()->create($validated_datas);

        return redirect($project->path());
    }

    public function  update(Project $project)
    {
        $this->authorize('update', $project);

        $validated_datas = $this->validateRequest();

        $project->update($validated_datas);

        return redirect($project->path());
    }

    public function destroy(Project $project)
    {
        $this->authorize('update', $project);
        $project->delete();
        return redirect('/projects');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }
}
