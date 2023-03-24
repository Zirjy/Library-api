<?php

namespace App\Http\Controllers;

use App\Http\Resources\DetailReviewsResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{
    public function index(){
        $post = Book::all();
        return DetailReviewsResource::collection($post->loadMissing('human:id,username', "reviewer:id,post_id,user_id,comments_content"));
    }


    public function show($id){
        $post = Book::with('human:id,username')->findOrFail($id);
        return new DetailReviewsResource($post);
    }
    public function store(Request $request){
        $request-> validate([
            'book_title' => 'required|max:225',
            'book_synopsis' => 'required'
        ]);

        // return response()->json('sudah dapat di digunakan');
        $image = null;

         if ($request->file) {
             $fileName = $this ->generateRandomString();
             $extension = $request->file->extension();

             $image = $fileName. '.' .$extension;
             Storage::putFileAs('image', $request->file, $image);
         }
        $request['image'] = $image;

        $request['author'] = Auth::user()->id;

        $post = Book::create($request->all());
        return new DetailReviewsResource($post->loadMissing('writer:id,username'));
    }
    public function update(Request $request, $id)
    {
        $request-> validate([
            'title' => 'required|max:225',
            'news_content' => 'required'
        ]);

        $image = null;

        if ($request->file) {
            $fileName = $this ->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName. '.' .$extension;
            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;

        $post = Book::findOrFail($id);
        $post->update($request->all());

        return new DetailReviewsResource($post->loadMissing('writer:id,username'));
    }
    public function delete($id){
        $post = Book::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => "Book Has successfully deleted"
        ]);
    }
    function generateRandomString($length = 20) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
