<?php

namespace App\Http\Controllers;
use App\Models\books;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    //

    public function index(){
        $books = books::with('category')->get();

        return response()->json([
            '========' => '================== Display books : ==================',
            'Books' => $books,
        ]);
    }
    public function addBook(Request $req){
        $imgName=$req->file('image')->getClientOriginalName();
        $req->file('image')->move(public_path('img'), $imgName);
        $data=books::create([
            'title'=>$req->title,
            'description'=>$req->description,
            'price'=>$req->price,
            'category_id'=>$req->category_id,
            'user_id'=>$req->user_id,
            'image'=>$imgName
        ]);
        return response()->json([
            'message' => "Book Has been added successfully!",
            'book'=>$data
        ], 201);
    }
}
