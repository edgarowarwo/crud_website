<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;

class CategoryController extends Controller
{
    public function __construct(){
          $this->middleware('auth');
    }

    public function AllCat(){
        $categories = Category::latest()->paginate(5);
        $trashedCat = Category::onlyTrashed()->latest()->paginate(3);
        return view('admin.category.index', compact('categories','trashedCat'));
    }
    public function AddCat(Request $request){

        $validator = $request->validate([
            'category_name' =>'required|unique:categories|max:255',
        ],        
        [
            'category_name.required' => 'Please input category',
        ],
        [
            'category_name.unique:categories' => $request.' already exists',
        ],
        [
            'category_name.max:255' => 'Category name is too long',
        ]);

        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id'=> Auth::user()->id,
        //     'created_at'=> Carbon::now()
        // ]);

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->save();

        return Redirect()->back()->with('success','Category added successfully');
    }

    public function EditCat($id){

        $categories = Category::find($id);
        return view('admin.category.edit', compact('categories'));

    }

    public function UpdateCat(Request $request, $id){

        $update = Category::find($id)->update([
            'category_name' =>  $request->category_name,
            'user_id' => Auth::user()->id     
        ]);
        
        return Redirect()->route('all.category')->with('success','Category updated successfully');

  }

    public function SoftdeleteCat($id){
        $delete = Category::find($id)->delete();
        return Redirect()->back()->with('delete_success','Category soft deleted successfully');
    }
   
    public function RestoreCat($id){

        $categories = Category::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success','Category Restored successfully');

    }
  
    public function PermanentdeleteCat($id){
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('delete_success','Category Permanently deleted successfully');
    }
  
}
