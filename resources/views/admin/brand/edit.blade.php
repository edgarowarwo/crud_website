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
                        <div class="card-header"> Edit Brand 
                            <a style="float:right;" href="{{ route('all.brands') }}" class="mb-1 btn active btn-primary">
                                 <b> View All Brands </b>
                            </a>
                        </div>
                            <div class="card-body">
                                <form method="POST" action="{{ url('brand/update/'.$brands->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="old_image" value="{{ $brands->brand_image }}"/>
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Update Brand Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="brand_name" 
                                        value="{{ $brands->brand_name }}">  
                                        
                                        @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Update Brand Image</label>
                                        <img src="{{ asset($brands->brand_image) }}" width="100" height="100" alt="{{ $brands->brand_name }}"/>
                                        <input type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="brand_image" 
                                        value="{{ $brands->brand_image }}">  
                                        
                                        @error('brand_image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success" name="update_brand">Update Brand</button>
                                </form>
                            </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
