<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDelicaRequest;
use App\Http\Requests\UpdateDelicaRequest;
use App\Models\Delica;
use App\Models\Project;
use DOMDocument;
use DOMXPath;
use Inertia\Inertia;
use Illuminate\Support\Str;

class DelicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $q = request()->query('search', '');
        return Inertia::render('Delica/Index', [
            'delicas' => Delica::where('code', 'like', '%' . $q . '%')
                ->orWhere('name', 'like', '%' . $q . '%')
                ->orWhere('color', 'like', '%' . $q . '%')
            ->orderBy('code')->get(),
            'projects' => Project::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Delica/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDelicaRequest $request)
    {
        $validated = $request->safe()->only(['source_url']);
        $parsedUrl = parse_url($validated['source_url']);
        parse_str($parsedUrl['query'], $queryParams);
        $reference = $queryParams['entry_id'] ?? null;

        $doc = new DOMDocument();
        $content = file_get_contents($validated['source_url']);
        @$doc->loadHTML($content);
        $title = $doc->getElementById('ThreadABead_ContentPlaceHolder1_lbl_header')->nodeValue;
        preg_match('/(?P<code>DBS \d{4}) (?P<name>[^\(]+)/', $title, $matches);
        if (!isset($matches['code'])) {
            preg_match('/(?P<code>DB \d{4}) (?P<name>[^\(]+)/', $title, $matches);
        }
        if (isset($matches['code'])) {
            $delica = Delica::firstOrNew([
                'code' => $matches['code']
            ]);
            $delica->source_url = $validated['source_url'];
            $delica->name = $matches['name'];
            if ( !empty($reference)) {
                $delica->image_photo_url = 'https://www.threadabead.com/shop_thumbs/' . $reference . '_2.jpg';
                $delica->image_color_url = 'https://www.threadabead.com/shop_thumbs/' . $reference . '_3.jpg';
            }
            $xpath = new DOMXPath($doc);
            $details = $xpath->query("//*[local-name()='div' and contains(concat(' ', normalize-space(@class), ' '), ' Classification_Details ')]");
            foreach ($details as $detail) {
                if ( Str::of($detail->nodeValue)->startsWith('Finish:') ){
                    $delica->finish = Str::of($detail->nodeValue)->after('Finish:')->trim();
                }
                elseif ( Str::of($detail->nodeValue)->startsWith('Colour:') ) {
                    $delica->color = Str::of($detail->nodeValue)->after('Colour:')->trim();
                }
                elseif ( Str::of($detail->nodeValue)->startsWith('Size:') ) {
                    $delica->size = Str::of($detail->nodeValue)->after('Size:')->trim();
                }
                elseif ( Str::of($detail->nodeValue)->startsWith('Material:') ) {
                    $delica->material = Str::of($detail->nodeValue)->after('Material:')->trim();
                }
                elseif ( Str::of($detail->nodeValue)->startsWith('Shape:') ) {
                    $delica->shape = Str::of($detail->nodeValue)->after('Shape:')->trim();
                }
            }
            $delica->save();
        }
        return to_route('delicas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Delica $delica)
    {
        return $delica;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delica $delica)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDelicaRequest $request, Delica $delica)
    {
        if ($request->has('project_add')) {
            // Add the delica to the project
            if ($delica->projects()->where('project_id', $request->project_add)->count() == 0 ){
                $delica->projects()->attach($request->project_add);
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delica $delica)
    {
        //
    }
}
//
