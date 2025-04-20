<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Place;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function bookmark(Place $place){
        auth()->user()->bookmarks()->toggle($place->id);

        return back();
    }
    public function getByUser()
    {
        $bookmarks = auth()->user()->bookmarks;

        return view('user_bookmarks', compact('bookmarks'));
    }
}
