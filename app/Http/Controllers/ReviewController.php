<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewsResourece;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request -> validate([
            'book_id' => 'required|exists:books,id',
            'book_synopsis' => 'required'
        ]);

        $request ['user_id'] = Auth()->user()->id;

        $comment = Review::create($request->all());

        // return response()->json($comment);
        return new ReviewsResourece($comment->loadMissing('reviewer:id,username'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'book_synopsis' => 'required'
        ]);

        $comment = Review::findOrFail($id);
        $comment->update($request->only('book_synopsis'));

        return new ReviewsResourece($comment->loadMissing(['reviewer:id,username']));
    }
    public function delete($id)
    {
        $comment = Review::findOrFail($id);
        $comment->delete();

        return response()->json([
            'message' => "book_synopsis Successfully deleted"
        ]);
    }
}
