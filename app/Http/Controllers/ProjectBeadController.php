<?php

namespace App\Http\Controllers;

use App\Models\Bead;
use App\Models\Project;

class ProjectBeadController extends Controller
{

    /**
     * Update the specified resource in storage.
     */
    public function update(Project $project, int $row, int $col)
    {
        $bead = Bead::firstOrNew([
            'project_id' => $project->id,
            'row' => $row,
            'col' => $col,
        ]);
        $bead->delica_id = request()->input('delica_id');
        $bead->save();
        $project->refreshBeadCounters($col);
        return to_route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, int $row, int $col)
    {
        $project->beads()->where('row', $row)->where('col', $col)->delete();
        $project->refreshBeadCounters($col);
        return to_route('projects.show', $project);
    }
}
