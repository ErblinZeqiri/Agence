<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyContactRequest;
use App\Http\Requests\SearchPropertiesRequest;
use App\Mail\PropertyContactMail;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use function Psy\sh;

class PropertyController extends Controller
{
    public function index(SearchPropertiesRequest $request) {
        $query = Property::query()->with('pictures')->orderBy('created_at', 'desc');
        if ($price = $request->validated('price')){
            $query = $query->where('price', '<=', $price);
        }
        if ($surface = $request->validated('surface')){
            $query = $query->where('surface', '>=', $surface);
        }
        if ($rooms = $request->validated('rooms')){
            $query = $query->where('rooms', '>=', $rooms);
        }
        if ($title = $request->validated('title')){
            $query = $query->where('title', 'like', "%{$title}%");
        }
        $properties = Property::paginate(16);
        return view('propertyCard.index', [
            'properties' => $query->paginate(16),
            'input' => $request->validated()
        ]);
    }

    public function show(string $slug, Property $property) {
        $expectedSlug = $property->getSlug();
        if ($slug !== $expectedSlug){
            return redirect('property.show', [$expectedSlug, 'property' => $property]);
        }
        return view('propertyCard.show', [
            'property' => $property
        ]);
    }

    public function contact(Property $property, PropertyContactRequest $request) {
        Mail::send(new PropertyContactMail($property, $request->validated()));
        return back()->with('success', 'Demande de contact envoyée');
    }
}
