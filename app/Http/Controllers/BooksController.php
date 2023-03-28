<?php

namespace App\Http\Controllers;
use App\Models\books;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $req->validate([
            'title' => 'required||max:30',
            'description' => 'required|string|max:255',
            'statut'=>'in:available,unavailable,borrowed,Processing',
        ]);
        $imgName=$req->file('image')->getClientOriginalName();
        $req->file('image')->move(public_path('img'), $imgName);
        $data=books::create([
            'title'=>$req->title,
            'description'=>$req->description,
            'price'=>$req->price,
            'category_id'=>$req->category_id,
            'user_id'=>$req->user()->id,
            'image'=>$imgName,
            'isbn'=>$req->isbn,
            'auteur'=>$req->auteur,
            'statut'=>$req->statut
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
        $user = Auth::user();
        if($user->can('edit every book') || $user->id == $data->user_id){
            $imgName=$req->file('image')->getClientOriginalName();
            $req->file('image')->move(public_path('img'), $imgName);
            $data->update([
                'title'=>$req->title,
                'description'=>$req->description,
                'price'=>$req->price,
                'category_id'=>$req->category_id,
                'image'=>$imgName,
                'isbn'=>$req->isbn,
                'auteur'=>$req->auteur,
                'statut'=>$req->statut
            ]);
            return response()->json(['message' => "the book has been updated successfully"]);
        }
            return response()->json(['message' => "you don't have permission to update this book"]);

    }
    public function deleteBook($id){
        $data = books::find($id);
        $user = Auth::user();
        if($user->can('edit every book') || $user->id == $data->user_id){
            if ($data) {
                $data->delete();
                return response()->json(['message' => "the book has been deleted successfully", 'book'=>$data]);
            } else {
                return response()->json(['message' => "the book you want to delete doesn't exist!"]);
            }
        }
        return response()->json(['message' => "you don't have permission to delete this book"]);

    }
    public function filter($category)
    {
        $category = categories::where('category', $category)->firstOrFail();
        $books = books::where('category_id', $category->id)->get();
        return response()->json($books);
    }

    public function test(){
        $book=books::orderBy('price', 'desc')->get();
        return $book;
    }
}
