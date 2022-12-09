<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Carbon;


class SliderController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function AllSliders(){
        $sliders = Slider::latest()->paginate(3);
        $trashedSliders = Slider::onlyTrashed()->latest()->paginate(3);
        return view('admin.slider.index', compact('sliders','trashedSliders'));
                
    }

    public function AddSlider(Request $request){
        $request->validate([
            'title' =>'required|unique:sliders|min:4',
            'description' =>'required|unique:sliders|min:15',
            'image' =>'required|mimes:jpg,jpeg,png',
        ],        
        [
            'title.required' => 'Please input Slider Title',
            'description.required' => 'Please input Slider Description',
            'image.required' => 'Please attach Slider Image',
        ],
        [
            'iamge.required' => 'Please attach Slider Image',
        ],
        [
            'title.min' => 'Slider title should be longer than 4 characters',
            'description.min' => 'Slider description should be longer than 15 characters',
        ]);

        $slider_image = $request->file('image'); // original passed image from the submitted form

        $name_generate = hexdec(uniqid()); // generate a unique image name
        $img_ext = strtolower($slider_image->getClientOriginalExtension()); //get image extension from original image
        $img_name = $name_generate.'.'.$img_ext; // the new image name with extension
        $upload_location = 'images/slider/'; // the image upload folder
        $last_img = $upload_location.$img_name; // the full image path
        $slider_image->move($upload_location,$img_name); // actual image upload happening

        $slider = new Slider;
        $slider->title = $request->title;
        $slider->description = $request->description;
        $slider->image = $last_img;
        $slider->save();

        return Redirect()->back()->with('success','Slider added successfully');
    }

    public function EditSlider($id){
        $sliders = Slider::find($id);
        return view('admin.slider.edit', compact('sliders'));
    }

    public function UpdateSlider(Request $request, $id){

        $request->validate([
            'title' =>'required|min:4',
            'description' =>'required|min:15',
            'image' =>'mimes:jpg,jpeg,png',
        ],        
        [
            'title.required' => 'Please input Slider Title',
            'description.required' => 'Please input Slider Description',
        ],                
        [
            'title.min' => 'Slider title should be longer than 4 characters',
            'description.min' => 'Slider description should be longer than 15 characters',
        ]);

        $old_image = $request->old_image;

        $slider_image = $request->file('image'); // original passed image from the submitted form   
        
        if($slider_image){
           
            $name_generate = hexdec(uniqid()); // generate a unique image name
            $img_ext = strtolower($slider_image->getClientOriginalExtension()); //get image extension from original image
            $img_name = $name_generate.'.'.$img_ext; // the new image name with extension
            $upload_location = 'images/slider/'; // the image upload folder
            $last_img = $upload_location.$img_name; // the full image path
            $slider_image->move($upload_location,$img_name); // actual image upload happening        

            unlink($old_image);
            Slider::find($id)->update([
                    'title' =>  $request->title,
                    'description' => $request->description,
                    'image' => $last_img,
                    'created_at' => Carbon::now()    
                ]);

            return Redirect()->back()->with('success','Slider updated successfully');

        }else{

            Slider::find($id)->update([
                'title' =>  $request->title,
                'description' => $request->description,
                'created_at' => Carbon::now()    
            ]);

            return Redirect()->back()->with('success','Slider updated successfully');

        }                        
        
    }

    public function SoftdeleteSlider($id){
        Slider::find($id)->delete();
        return Redirect()->back()->with('delete_success','Slider has been soft-deleted successfully');    
    }

    public function RestoreSlider($id){
        Slider::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success','Slider Restored successfully');
    }

    public function PermanentdeleteSlider($id){
        $slider = Slider::onlyTrashed()->find($id, ['image','title']);
        
        $slider_title = $slider->title;
        $slider_image = $slider->image;
        unlink($slider_image);

        Slider::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('delete_success',$slider_title.' Slider: Permanently deleted successfully');
    }
}
