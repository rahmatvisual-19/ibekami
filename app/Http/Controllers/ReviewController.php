<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::all();
        return view('backend.pages.review', compact('reviews'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'reviewer_name' => 'required|min:4',
            'text_review' => 'required',
            'rating_review' => 'required|numeric',
            'review_date' => 'required|date'
        ], [
            'reviewer_name.required' => 'Name must be filled in',
            'reviewer_name.min' => 'Name of reviewer at least 4 characters',
            'text_review.required' => 'Text review must be filled in',
            'rating_review.required' => 'Rating must be filled in',
            'rating_review.numeric' => 'Rating must be filled in with numeric',
            'review_date.required' => 'Date must be filled in',
            'review_date.date' => 'Date must be filled in with date format'
        ]);

        $review = new Review;
        $review->name = $request->reviewer_name;
        $review->review = $request->text_review;
        $review->star = $request->rating_review;
        $review->review_date = $request->review_date;

        $review->save();

        session()->flash('success', 'Review Data Has Been Successfully Added!');

        return redirect('/dashboard/review');
    }

    public function delete($id)
    {
        $review = Review::find($id);
        $review->delete();

        return redirect('/dashboard/review')->with('delete', 'You have succesfully deleted!');
    }

    public function edit($id)
    {
        $review = Review::find($id);
        return view('backend.pages.editreview', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'reviewer_name' => 'required|min:4',
            'text_review' => 'required',
            'rating_review' => 'required|numeric',
            'review_date' => 'required|date'
        ], [
            'reviewer_name.required' => 'Name must be filled in',
            'reviewer_name.min' => 'Name of reviewer at least 4 characters',
            'text_review.required' => 'Text review must be filled in',
            'rating_review.required' => 'Rating must be filled in',
            'rating_review.numeric' => 'Rating must be filled in with numeric',
            'review_date.required' => 'Date must be filled in',
            'review_date.date' => 'Date must be filled in with date format'
        ]);

        $review = Review::findOrFail($id);
        $review->name = $request->reviewer_name;
        $review->review = $request->text_review;
        $review->star = $request->rating_review;
        $review->review_date = $request->review_date;

        $review->save();

        session()->flash('success', 'Review has been successfully updated!');

        return redirect()->route('review');
    }
}
