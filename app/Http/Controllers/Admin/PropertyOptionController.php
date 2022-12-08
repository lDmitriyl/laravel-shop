<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PropertyOptionRequest;
use App\Models\Property;
use App\Models\PropertyOption;
use Illuminate\Http\Response;

class PropertyOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Property $property
     * @return Response
     */
    public function index(Property $property)
    {
        $propertyOptions = $property->propertyOptions()->paginate(10);
        return view('auth.property-options.index', compact( 'property','propertyOptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Property $property
     * @return Response
     */
    public function create(Property $property)
    {
        return view('auth.property-options.form', compact('property'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PropertyOptionRequest $request
     * @param Property $property
     * @return Response
     */
    public function store(PropertyOptionRequest $request, Property $property)
    {
        $params = $request->all();
        $params['property_id'] = $request->property->id;
        PropertyOption::create($params);
        return redirect()->route('property-options.index', $property);
    }

    /**
     * Display the specified resource.
     *
     * @param Property $property
     * @param PropertyOption $propertyOption
     * @return Response
     */
    public function show(Property $property, PropertyOption $propertyOption)
    {
        return view('auth.property-options.show', compact('propertyOption'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Property $property
     * @param PropertyOption $propertyOption
     * @return Response
     */
    public function edit(Property $property, PropertyOption $propertyOption)
    {
        return view('auth.property-options.form',compact('propertyOption', 'property'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Property $property
     * @param PropertyOption $propertyOption
     * @return Response
     */
    public function update(PropertyOptionRequest $request, Property $property, PropertyOption $propertyOption)
    {
        $params = $request->all();
        $propertyOption->update();
        return redirect()->route('property-options.index', $property);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Property $property
     * @param PropertyOption $propertyOption
     * @return Response
     * @throws \Exception
     */
    public function destroy(Property $property, PropertyOption $propertyOption)
    {
        $propertyOption->delete();
        return redirect()->route('property-options.index', $property);
    }
}
