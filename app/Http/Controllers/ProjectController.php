<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Bead;
use App\Models\Project;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Project/Index', [
            'projects' => Project::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Project/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->safe()->only(['name', 'type', 'width', 'long']);

        $project = new Project;
        $project->name = $validated['name'];
        $project->type = $validated['type'];
        $project->width = $validated['width'];
        $project->long = $validated['long'];
        $project->user_id = $request->user()->id;

        $project->save();

        return to_route('projects.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $delicas = [];
        foreach ($project->delicas as $delica) {
            $delicas[$delica->id] = $delica;
        }
        $delicas = collect($delicas);
        $beads = [];
        foreach ($project->beads as $bead) {
            if ($bead->delica) {
                $beads[$bead->row . '-' . $bead->col] = [
                    'badge' => $bead->badge,
                    'id' => $bead->delica->id,
                    'image_color_url' => $bead->delica->image_color_url,
                    'name' => $bead->delica->name,
                ];
            }
        }

        return Inertia::render('Project/Show', [
            'project' => $project,
            'beads' => $beads,
            'delicas' => $delicas,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * https://www.threadabead.com/Delica_Colours.aspx
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        if ($request->has('bead_delica')) {
            if (empty($request->bead_delica)) {
                Bead::where('project_id', $project->id)
                    ->where('row', $request->bead_row)
                    ->where('col', $request->bead_col)
                    ->delete();
                return;
            }
            $bead = Bead::firstOrNew([
                'project_id' => $project->id,
                'row' => $request->bead_row,
                'col' => $request->bead_col,
            ]);
            if ($request->bead_row > 1) {
                $count = 1;
                $start = $request->bead_row - 1;
                while ($start > 0) {
                    $previous_bead = Bead::firstOrNew([
                        'project_id' => $project->id,
                        'row' => $start,
                        'col' => $request->bead_col,
                    ]);
                    if (!$previous_bead) {
                        break;
                    }
                    if ($previous_bead->delica_id !== $request->bead_delica) {
                        break;
                    }
                    $previous_bead->badge = null;
                    $previous_bead->save();
                    $start--;
                    $count++;
                }
                if ($count > 1) {
                    $bead->badge = $count;
                }
            }
            $bead->delica()->associate($request->bead_delica);
            $bead->save();
        }
        elseif ($request->has('width')) {
            $project->width = $request->width;
            $project->long = $request->long;
            $project->type = $request->type;
            $project->name = $request->name;
            $project->save();
            $beads = Bead::where('project_id', $project->id)
                ->where('row', '>', $request->width)
                ->delete();
            $beads = Bead::where('project_id', $project->id)
                ->where('col', '>', $request->long)
                ->delete();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
