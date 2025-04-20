<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Traits\RateableTrait;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    use RateableTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::orderBy('view_count' , 'desc')->take(6)->get();
        return view('welcome' , compact('places'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('add_place');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->image){
            $imageName = time() . '.' . $request->image->extension();
            $request->image->storeAs('images' , $imageName);
            $request->user()->places()->create($request->except('image') + ['image' => $imageName]);

        }else{
            $request->user()->places()->create($request->all());

        }

        // $place = new Place;
        // $place::create($request->all());
        $places = Place::all();
        return view('welcome' , compact('places'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Place $place)
    {
        $place = $place::withCount('reviews')->with(['reviews' => function($query) {
            $query->with('user')
                  ->withCount('likes');  
        }])->find($place->id);        
        $avg = $this->averageRating($place);
        $total = $avg['total'];
        $service_rating = $avg['service_rating'];
        $quality_rating = $avg['quality_rating'];
        $cleanliness_rating = $avg['cleanliness_rating'];
        $pricing_rating = $avg['pricing_rating'];
        return view('details', compact('place', 'total', 'service_rating', 'quality_rating', 'cleanliness_rating', 'pricing_rating'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        //
    }
}
