<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\User;
use App\Services\Project\CreateProjectService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{

    public function __construct(private readonly CreateProjectService $createProjectService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['owner', 'members'])
            ->withCount('tasks')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return Inertia::render('Projects/ProjectIndex', [
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Projects/ProjectCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $projectKey = $this->createProjectService->projectKeyGenerator($request->validated()['name']);

        $project = Project::create(array_merge(
            $request->validated(),
            [
                'key' => $projectKey,
                'owner_id' => auth()->id()
            ]
        ));

        return redirect()->route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project = Project::with(['owner', 'members', 'tasks'])
            ->findOrFail($project->id);

        return Inertia::render('Projects/ProjectShow', [
            'project' => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        if (auth()->id() !== $project->owner_id) {
            abort(403, 'Unauthorized action.');
        }


        return Inertia::render('Projects/ProjectEdit', [
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if (auth()->id() !== $project->owner_id) {
            abort(403, 'Unauthorized action.');
        }


        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (auth()->id() !== $project->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function forceDelete(Project $project)
    {
        if (auth()->id() !== $project->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        $project->forceDelete(); // Permanent delete

        return redirect()->route('projects.index')
            ->with('success', 'Project permanently deleted.');
    }
    public function generateProjectKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $key = $this->createProjectService->projectKeyGenerator($request->name);

        return response()->json(['key' => $key]);
    }
    public function archive(Project $project)
    {
        if (auth()->id() !== $project->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        $project->update([
            'status' => 'archived',
            'archived_at' => now()
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project archived successfully.');
    }

    public function unarchive(Project $project)
    {
        if (auth()->id() !== $project->owner_id) {
            abort(403, 'Unauthorized action.');
        }

        $project->update([
            'status' => 'active',
            'archived_at' => null
        ]);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project restored successfully.');
    }

}
