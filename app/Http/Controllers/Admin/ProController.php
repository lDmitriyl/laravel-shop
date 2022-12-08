<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProRequest;
use App\Models\Pro;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        $pros = $product->pros()->paginate(10);
        return view('auth.pros.index', compact('pros', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('auth.pros.form', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(ProRequest $request, Product $product)
    {
        $params = $request->all();
        $params['product_id'] = $request->product->id;
        $pro = Pro::create($params);
        $pro->propertyOptions()->sync($request->property_id);

        return redirect()->route('pros.index', $product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @param \App\Models\Pro $pro
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product, Pro $pro)
    {
        return view('auth.pros.show', compact('product', 'pro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Product $product
     * @param \App\Models\Pro $pro
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product, Pro $pro)
    {
        return view('auth.pros.form', compact('product', 'pro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @param \App\Models\Pro $pro
     * @return \Illuminate\Http\Response
     */
    public function update(ProRequest $request, Product $product, Pro $pro)
    {
        $params = $request->all();
        $params['product_id'] = $request->product->id;
        $pro->update($params);
        $pro->propertyOptions()->sync($request->property_id);

        return redirect()->route('pros.index', $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @param \App\Models\Pro $pro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Pro $pro)
    {
        $pro->delete();
        return redirect()->route('pros.index', $product);
    }
}
