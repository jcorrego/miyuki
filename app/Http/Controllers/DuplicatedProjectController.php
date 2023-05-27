<?php

namespace App\Http\Controllers;

use App\Models\Project;

class DuplicatedProjectController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Project $project) {
        $duplicate = $project->replicate()->fill([
            'name' => $project->name . ' - Copy'
        ]);

        $duplicate->save();
        foreach ($project->delicas as $delica) {
            $duplicate->delicas()->attach($delica);
        }
        foreach ($project->beads as $bead) {
            $duplicate->beads()->create([
                'row' => $bead->row,
                'col' => $bead->col,
                'delica_id' => $bead->delica_id,
                'badge' => $bead->badge,
            ]);

        }
        return to_route('projects.show', $duplicate);
    }
}
