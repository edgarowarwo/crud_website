<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Carbon;
use Auth;
use Image;

class BrandController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function AllBrands(){
        $brands = Brand::latest()->paginate(5);
        $trashedBrands = Brand::onlyTrashed()->latest()->paginate(5);
        return view('admin.brand.index', compact('brands','trashedBrands'));
    }

    public function AddBrand(Request $request){
        $validator = $request->validate([
            'brand_name' =>'required|unique:brands|min:4',
            'brand_image' =>'required|mimes:jpg,jpeg,png',
        ],        
        [
            'brand_name.required' => 'Please input Brand Name',
        ],
        [
            'brand_image.required' => 'Please attach Brand Image',
        ],
        [
            'brand_name.unique:brands' => $request.' already exists',
        ],
        [
            'brand_name.min' => 'Brand name should be longer than 4 characters',
        ]);

        $brand_image = $request->file('brand_image'); // original passed image from the submitted form

        $name_generate = hexdec(uniqid()); // generate a unique image name
        $img_ext = strtolower($brand_image->getClientOriginalExtension()); //get image extension from original image
        $img_name = $name_generate.'.'.$img_ext; // the new image name with extension
        $upload_location = 'images/brand/'; // the image upload folder
        $last_img = $upload_location.$img_name; // the full image path
        $brand_image->move($upload_location,$img_name); // actual image upload happening

        // ------------------------- add using image.intervention.io --------------------------- \\
        // $name_generate = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension(); // generate a unique image name
        // Image::make($brand_image)->resize(350,350)->save('images/brand/'.$name_generate);
        // $last_img = 'images/brand/'.$name_generate;
        // ------------------------------------- end ----------------------------------------------\\


        // Brand::insert([
        //       'brand_name' => $request->brand_name,
        //       'brand_image' => $last_img,
        // ]);

        $brand = new Brand;
        $brand->brand_name = $request->brand_name;
        $brand->brand_image = $last_img;
        $brand->save();

        return Redirect()->back()->with('success','Brand added successfully');
    }

    public function EditBrand($id){
        $brands = Brand::find($id);
        return view('admin.brand.edit', compact('brands'));
    }

    public function UpdateBrand(Request $request, $id){

        $validator = $request->validate([
            'brand_name' =>'required|min:4',
            'brand_image' =>'mimes:jpg,jpeg,png',
        ],        
        [
            'brand_name.required' => 'Please input Brand Name',
        ],                
        [
            'brand_name.min' => 'Brand name should be longer than 4 characters',
        ]);

        $old_image = $request->old_image;

        $brand_image = $request->file('brand_image'); // original passed image from the submitted form   
        
        if($brand_image){
           
            $name_generate = hexdec(uniqid()); // generate a unique image name
            $img_ext = strtolower($brand_image->getClientOriginalExtension()); //get image extension from original image
            $img_name = $name_generate.'.'.$img_ext; // the new image name with extension
            $upload_location = 'images/brand/'; // the image upload folder
            $last_img = $upload_location.$img_name; // the full image path
            $brand_image->move($upload_location,$img_name); // actual image upload happening        

            unlink($old_image);
            $update = Brand::find($id)->update([
                    'brand_name' =>  $request->brand_name,
                    'brand_image' => $last_img,
                    'created_at' => Carbon::now()    
                ]);

            return Redirect()->back()->with('success','Brand updated successfully');

        }else{

            $update = Brand::find($id)->update([
                'brand_name' =>  $request->brand_name,
                'created_at' => Carbon::now()    
            ]);

            return Redirect()->back()->with('success','Brand updated successfully');

        }                        
        
    }


    public function SoftdeleteBrand($id){
        Brand::find($id)->delete();
        return Redirect()->back()->with('delete_success','Brand soft deleted successfully');    
    }

    public function RestoreBrand($id){
        Brand::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success','Brand Restored successfully');
    }

    public function PermanentdeleteBrand($id){
        $image = Brand::onlyTrashed()->find($id, ['brand_image','brand_name']);
        
        $old_Brand_name = $image->brand_name;
        $old_image = $image->brand_image;
        unlink($old_image);

        Brand::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('delete_success',$old_Brand_name.' Brand: Permanently deleted successfully');
    }
}
