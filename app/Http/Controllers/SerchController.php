<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class SerchController extends Controller
{
    public function auto(Request $request)
{
    if($request->address) {
        $input = $request->address;
        $data = Place::where('address','LIKE', "%$input%")->get();
        $output =  '<ul  class="bg-gray-100  cursor-pointer rounded  px-6">';
        foreach($data as $row) {
            $output .=  '<li class="flex items-center bg-gray-300 hover:bg-gray-100 justify-between p-2 my-4">'.$row->address.'<li>';
        }
        $output .= '<ul>';

        return $output;
    }
}



protected function getLocationDetails($place)
{
    $details = [];
    if ($place->city) $details[] = $place->city;
    if ($place->district) $details[] = $place->district;
    return implode('، ', $details);
}
    public function show(Request $request)
    {
        $places = Place::search($request)->get();

        return view('list', compact('places'));
    }
}
