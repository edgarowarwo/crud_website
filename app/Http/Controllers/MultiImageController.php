<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\multipic;
use Illuminate\Support\Carbon;
use Image;

class MultiImageController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    
    public function AllImages(){
        $images = multipic::all();
        //$trashedBrands = multipic::onlyTrashed()->latest()->paginate(5);
        return view('admin.multipic.index', compact('images'));
    }

    public function AddMultiImages(Request $request){
        // $validator = $request->validate([
        //     'image' =>'required|mimes:jpg,jpeg,png',
        // ]);

        $image = $request->file('image'); // original passed image from the submitted form  
        $list = array('jpg','jpeg','png','gif');
        $message = '';
        $count = 0;
        
        foreach($image as $multi_img){                     
            $check = $multi_img->getClientOriginalExtension();
            if(!in_array($check, $list)){  
                $count++;  
                $message.=$check.' | ';            
                continue;
            }else{
                // ------------------------- add using image.intervention.io --------------------------- \\
                $name_generate = hexdec(uniqid()).'.'.$multi_img->getClientOriginalExtension(); // generate a unique image name
                Image::make($multi_img)->resize(350,350)->save('images/multi/'.$name_generate);
                $last_img = 'images/multi/'.$name_generate;
                // ------------------------------------- end ----------------------------------------------\\

                $multi = new multipic;
                $multi->image = $last_img;
                $multi->save();
            }                                  
        }        
        $message = mb_substr($message, 0, -3);
        return Redirect()->back()->with('success',$count.' Multi images were not added successfully ('.$message.' are not allowed)');
    }
}
