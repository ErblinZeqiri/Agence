<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyFormRequest;
use App\Models\Option;
use App\Models\Picture;
use App\Models\Property;
use Illuminate\Http\Request;

class PropertyAdminController extends Controller
{

    public function index()
    {
        return view('admin.properties.index', [
            'properties' => Property::orderBy('created_at', 'desc')->paginate(25)
        ]);
    }

    public function create()
    {
        $property = new Property();
        $property->fill([
            'surface' => 40,
            'rooms' => 3,
            'bedrooms'=> 1,
            'floor' => 0,
            'city' => 'Genève',
            'postal_code' => '1201',
            'sold' => false
        ]);
        return view('admin.properties.form', [
            'property' => $property,
            'options' => Option::pluck('name', 'id')
        ]);
    }

    public function store(PropertyFormRequest $request)
    {
        $property = Property::create($request->validated());
        $property->options()->sync($request->validated('options'));
        $property->attachFiles($request->validated('pictures'));
        return to_route('admin.property.index')->with('success', 'Bien créer avec succès!');
    }

    public function edit(Property $property)
    {
        return view('admin.properties.form', [
            'property' => $property,
            'options' => Option::pluck('name', 'id')
        ]);
    }

    public function update(PropertyFormRequest $request, Property $property)
    {
        $property->update($request->validated());
        $property->options()->sync($request->validated('options'));
        if ($request->has('pictures') && $request->validated('pictures') !== null) {
            $property->attachFiles($request->validated('pictures'));
        }
        return to_route('admin.property.index')->with('success', 'Bien modifier avec succès!');
    }

    public function destroy(Property $property)
    {
        Picture::destroy($property->pictures()->pluck('id'));
        $property->delete();
        return to_route('admin.property.index')->with('success', 'Bien supprimé avec succès!');
    }
}
