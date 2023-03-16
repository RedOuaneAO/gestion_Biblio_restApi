<?php

namespace App\Http\Controllers;
use App\Models\categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function displayCategories(){
        $categories = categories::get();
        return response()->json([
            'Categories' => $categories,
        ]);
    }
    public function addCategory(Request $req){
        $category = categories::create($req->all());
        return response()->json([
            'Message' => "({$category->category}) Category has been added successfully!",
        ], 200);
    }
    public function showCategory($id){
        $data = categories::findOrFail($id);
        return $data;
    }
    public function updateCategory(request $req , $id){
        $Category = categories::findOrFail($id);
        $oldCategory=$Category->category;
        $Category->update($req->all());
        return response()->json(['message' => "the Category ({$oldCategory}) has been updated successfully", 'New Category'=>$Category]);
    }
    public function deleteCategory($id){
        $data = categories::find($id);
        if ($data) {
            $data->delete();
            return response()->json(['message' => "the Category has been deleted successfully", 'Category'=>$data]);
        } else {
            return response()->json(['message' => "the Category you want to delete doesn't exist!"]);
        }
    }
}


