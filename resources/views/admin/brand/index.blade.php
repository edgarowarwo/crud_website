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

                    <div class="card">
                        <div class="card-header"> All Brands </div>
                        <div class="card-body">
                            <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Brand Name</th>
                                <th scope="col">Brand Image</th>
                                <th scope="col">Created</th>
                                <th scope="col">Exact Time</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach($brands as $brand)
                                <tr>
                                <th scope="row">{{ $brands->firstItem()+$loop->index }}</th>
                                <td>{{ $brand->brand_name }}</td>
                                <td><img src="{{ asset($brand->brand_image) }}" alt="{{ $brand->brand_name }}" width="25" height="25"/></td>
                                <td>
                                    @if($brand->created_at == NULL)
                                    <span class="text text-danger">No Time</span>
                                    @else
                                    {{ $brand->created_at->diffForHumans() }}
                                    @endif
                                </td>
                                <td>
                                    @if($brand->created_at == NULL)
                                    <span class="text text-danger">No Date</span>
                                    @else
                                    {{ $brand->created_at }}
                                    @endif
                                </td>
                                <td> 
                                    <a href="{{ url('brand/edit/'.$brand->id) }}" class="btn btn-info text text-white"> Edit </a> 
                                    <a href="{{ url('softdelete/brand/'.$brand->id) }}" class="btn btn-danger"> Delete </a> 
                                </td>
                                </tr>    
                                @endforeach               
                            </tbody>
                            </table>
                            {{ $brands->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"> Add Brands </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('persist.brand') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Brand Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="brand_name">  
                                        
                                        @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Brand Image</label>
                                        <input type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="brand_image">  
                                        
                                        @error('brand_image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success" name="add_brand">Add Brand</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>

{{-- Trash List starts --}}
<div style="clear:both;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>


            <div class="row mb-4">

                <div class="col-md-8">
                    @if(session('delete_success'))
                        <div class="alert alert-success alert-highlighted" role="alert">
                            <span class="mdi mdi-check-circle-outline"></span>
                            {{ session('delete_success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header"> Brand Trash List </div>
                        <div class="card-body">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Brand Name</th>
                                    <th scope="col">Brand Image</th>
                                    <th scope="col">Created</th>
                                    <th scope="col">Exact Time</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trashedBrands as $brand)
                                <tr>
                                <th scope="row">{{ $trashedBrands->firstItem()+$loop->index }}</th>
                                <td>{{ $brand->brand_name }}</td>
                                <td><img src="{{ asset($brand->brand_image) }}" alt="{{ $brand->brand_name }}" width="25" height="25"/></td>
                                <td>
                                    @if($brand->created_at == NULL)
                                    <span class="text text-danger">No Time</span>
                                    @else
                                    {{ $brand->created_at->diffForHumans() }}
                                    @endif
                                </td>
                                <td>
                                    @if($brand->created_at == NULL)
                                    <span class="text text-danger">No Date</span>
                                    @else
                                    {{ $brand->created_at }}
                                    @endif
                                </td>
                                <td> 
                                    <a href="{{ url('brand/restore/'.$brand->id) }}" class="btn btn-info text text-white"> Restore </a> 
                                    <a href="{{ url('permanent_delete/brand/'.$brand->id) }}" class="btn btn-danger" onclick="return confirm('Sure? This action is irreversible!')"> Delete </a> 
                                </td>
                                </tr>    
                                @endforeach               
                            </tbody>
                            </table>
                            {{ $trashedBrands->links() }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    
                </div>

                {{-- Trash List ends --}}


            </div>
        </div>
</div>
@endsection
