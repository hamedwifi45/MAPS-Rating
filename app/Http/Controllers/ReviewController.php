<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewFormRequest;
use App\Models\Review;
use Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewFormRequest $request)
    {
        // dd($request->place_id ,$request->user()->reviews()->first()->where('place_id' , $request->place_id)->exists() );
        if($request->user()->reviews()->where('place_id',$request->place_id)->exists()){

            return redirect(url()->previous() . '#review-div')->with('fail', 'لقد قيمت هذا الموقع سابقا');
        }
        Review::create($request->all() + ['user_id' => auth()->id()]);
        return redirect(url()->previous() . '#review-div')->with('success', 'تم بنجاح إضافة مراجعة');
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        //
    }
}
