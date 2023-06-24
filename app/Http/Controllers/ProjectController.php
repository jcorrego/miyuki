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

        return to_route('projects.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $delicas = [];
        foreach ($project->delicas as $delica) {
            $delicas[$delica->id] = [
                'id' => $delica->id,
                'code' => $delica->code,
                'name' => $delica->name,
                'rgb' => $delica->rgb,
                'count' => 0,
            ];
        }
        $beads = [];
        foreach ($project->beads as $bead) {
            if ($bead->delica) {
                $beads[$bead->row . '-' . $bead->col] = [
                    'badge' => $bead->badge,
                    'id' => $bead->delica->id,
                    'rgb' => $bead->delica->rgb,
                    'code' => $bead->delica->code,
                ];
                $delicas[$bead->delica->id]['count']++;
            }
        }
        // Sorts delicas by count, this lost the keys, but they are not used.
        usort($delicas, function ($a, $b) {
            return $a['count'] < $b['count'];
        });
        $items = [];
        for ($row = 1; $row <= $project->width; $row++) {
            $items[$row] = [];
            for ($col = 1; $col <= $project->long; $col++) {
                $key = $row . '-' . $col;
                $items[$row][$col] = [
                    'rgb' => '#fff',
                    'badge' => null,
                ];
                if (isset($beads[$key])) {
                    $items[$row][$col]['rgb'] = $beads[$key]['rgb'];
                    $items[$row][$col]['badge'] = $beads[$key]['badge'] > 0 ? $beads[$key]['badge'] : '';
                }
            }
        }
        return Inertia::render('Project/Show', [
            'project' => $project,
            'delicas' => $delicas,
            'items' => $items,
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
        if ($request->has('width')) {
            if ($request->width != $project->width) {
                $increase = $request->width > $project->width;
                $project->width = $request->width;
                if (!$request->bottom) {
                    Bead::where('project_id', $project->id)
                        ->update(['row' => Bead::raw('`row` ' . ($increase ? '+' : '-') . ' 1')]);
                }
                Bead::where('project_id', $project->id)
                    ->where('row', '>', $request->width)
                    ->delete();
                Bead::where('project_id', $project->id)
                    ->where('row', '<', 1)
                    ->delete();
            }
            if ($request->long != $project->long) {
                $increase = $request->long > $project->long;
                $project->long = $request->long;
                if (!$request->right) {
                    Bead::where('project_id', $project->id)
                        ->update(['col' => Bead::raw('`col` ' . ($increase ? '+' : '-') . ' 1')]);
                }
                Bead::where('project_id', $project->id)
                    ->where('col', '>', $request->long)
                    ->delete();
                Bead::where('project_id', $project->id)
                    ->where('col', '<', 1)
                    ->delete();
            }
            $project->type = $request->type;
            $project->name = $request->name;
            $project->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return to_route('projects.index');
    }
}
