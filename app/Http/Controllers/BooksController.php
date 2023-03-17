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
            'user_id'=>$req->user()->id,
            'image'=>$imgName
        ]);
        return response()->json([
            'message' => "Book Has been added successfully!",
            'book'=>$data
        ], 201);
    }
    public function showBook($id){
        // $data = books::with('category')->findOrFail($id);
        $data = books::with('category')->find($id);
        $response = ($data) ? response()->json($data, 200) : response()->json(['message' => "the Book you'r looking form doesn't exist!",]);
        return $response;
    }
    public function updateBook(request $req , $id){
        $data = books::find($id);
        $imgName=$req->file('image')->getClientOriginalName();
        $req->file('image')->move(public_path('img'), $imgName);
        $data->update([
            'title'=>$req->title,
            'description'=>$req->description,
            'price'=>$req->price,
            'category_id'=>$req->category_id,
            'user_id'=>$req->user()->id,
            'image'=>$imgName
        ]);
        return response()->json(['message' => "the book has been updated successfully", 'book'=>$data]);
    }
    public function deleteBook($id){
        $data = books::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['message' => "the book has been deleted successfully", 'book'=>$data]);
        } else {
            return response()->json(['message' => "the book you want to delete doesn't exist!"]);
        }
    }
}
