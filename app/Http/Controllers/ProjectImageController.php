<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Intervention\Image\Facades\Image;

class ProjectImageController extends Controller
{
    public function show(Project $project)
    {
        // dump($project);
        $img = Image::canvas($project->long+2, $project->width+2, '#fff');
        foreach ($project->beads()->with('delica')->get() as $bead) {
            $img->pixel($bead->delica->rgb, $bead->col, $bead->row);
        }
        $img->widen(100);
        $img->resizeCanvas(100, 100, 'center', false, '#94a3b8');
        return $img->response('jpg');
    }
}
