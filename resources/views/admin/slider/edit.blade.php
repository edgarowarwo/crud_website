@extends('admin.admin_master')
@section('admin')

    <div class="py-12">
        <div class="container">
            <div class="row">                

                <div class="col-md-8">
                    @if(session('success'))
                        <div class="alert alert-success alert-highlighted" role="alert">
                            <span class="mdi mdi-check-circle-outline"></span>
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card ">                        
                        <div class="card-header"> Edit Slider 
                            <a style="float:right;" href="{{ route('all.sliders') }}" class="mb-1 btn active btn-primary">
                                 <b> View All Sliders </b>
                            </a>
                        </div>
                            <div class="card-body">
                                <form method="POST" action="{{ url('slider/update/'.$sliders->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="old_image" value="{{ $sliders->image }}"/>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Update Slider Title</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title" 
                                        value="{{ $sliders->title }}">  
                                        
                                        @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Slider Description</label>
                                        <textarea class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="description" rows="5">
                                            {{ $sliders->description }}
                                        </textarea>                                        
                                        
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Update Slider Image</label>
                                        <img src="{{ asset($sliders->image) }}" width="250" height="200" alt="{{ $sliders->title }}"/>
                                        <input type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="image" 
                                        value="{{ $sliders->image }}">  
                                        
                                        @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success" name="update_slider">Update Slider</button>
                                </form>
                            </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
