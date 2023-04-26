<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class ProjectController extends Controller
{
    public function create()
{
    $users = User::all();
    $project = new Project();

    return view('projects.create', compact('users', 'project'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'members.*' => 'exists:users,id',

        ]);

        $project = new Project([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
            'user_id' => auth()->id(),
            'completed_tasks' => $request->get('completed_tasks')
        ]);
        $project->save();

        $members = $request->input('members', []);
        $project->members()->attach($members);

        return redirect()->route('projects.show', $project);
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $users = User::all();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
        ]);

        $project->name = $request->get('name');
        $project->description = $request->get('description');
        $project->price = $request->get('price');
        $project->start_date = $request->get('start_date');
        $project->end_date = $request->get('end_date');
        $project->completed_tasks = $request->get('completed_tasks');
        $project->save();

        $members = $request->input('members', []);
        
        $project->members()->sync($request->get('members'));

        return redirect()->route('projects.show', $project);
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect()->route('home');
    }
}
