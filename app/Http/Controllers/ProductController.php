<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Bead;
use App\Models\Product;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Product/Index', [
            'products' => Product::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Product/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->safe()->only(['name', 'type', 'width', 'long']);

        $product = new Product;
        $product->name = $validated['name'];
        $product->type = $validated['type'];
        $product->width = $validated['width'];
        $product->long = $validated['long'];
        $product->user_id = $request->user()->id;

        $product->save();

        return to_route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $delicas = [];
        foreach ($product->delicas as $delica) {
            $delicas[$delica->id] = $delica;
        }
        $delicas = collect($delicas);
        $beads = [];
        foreach ($product->beads as $bead) {
            if ($bead->delica) {
                $beads[$bead->row . '-' . $bead->col] = $bead->delica;
            }
        }

        return Inertia::render('Product/Show', [
            'product' => $product,
            'beads' => $beads,
            'delicas' => $delicas,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * https://www.threadabead.com/Delica_Colours.aspx
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->has('bead_delica')) {
            if (empty($request->bead_delica)) {
                Bead::where('product_id', $product->id)
                    ->where('row', $request->bead_row)
                    ->where('col', $request->bead_col)
                    ->delete();
                return;
            }
            $bead = Bead::firstOrNew([
                'product_id' => $product->id,
                'row' => $request->bead_row,
                'col' => $request->bead_col,
            ]);
            $bead->delica()->associate($request->bead_delica);
            $bead->save();
        }
        elseif ($request->has('width')) {
            $product->width = $request->width;
            $product->long = $request->long;
            $product->type = $request->type;
            $product->name = $request->name;
            $product->save();
            $beads = Bead::where('product_id', $product->id)
                ->where('row', '>', $request->width)
                ->delete();
            $beads = Bead::where('product_id', $product->id)
                ->where('col', '>', $request->long)
                ->delete();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
