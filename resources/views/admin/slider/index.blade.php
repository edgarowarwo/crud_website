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
                        <div class="card-header"> All Sliders </div>
                        <div class="card-body">
                            <table class="table">
                            <thead>
                                <tr>
                                <th scope="col" width="2%">#</th>
                                <th scope="col" width="10%">Slider Title</th>
                                <th scope="col" width="25%">Slider Description</th>
                                <th scope="col" width="10%">Slider Image</th>
                                <th scope="col" width="10%">Created</th>
                                <th scope="col" width="10%">Exact Time</th>
                                <th scope="col" width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                @foreach($sliders as $slider)
                                <tr>
                                <th scope="row">{{ $sliders->firstItem()+$loop->index }}</th>
                                <td>{{ $slider->title }}</td>
                                <td>{{ $slider->description }}</td>
                                <td><img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" width="150" height="100"/></td>
                                <td>
                                    @if($slider->created_at == NULL)
                                    <span class="text text-danger">No Time</span>
                                    @else
                                    {{ $slider->created_at->diffForHumans() }}
                                    @endif
                                </td>
                                <td>
                                    @if($slider->created_at == NULL)
                                    <span class="text text-danger">No Date</span>
                                    @else
                                    {{ $slider->created_at }}
                                    @endif
                                </td>
                                <td> 
                                    <a href="{{ url('slider/edit/'.$slider->id) }}" class="btn btn-info text text-white"> Edit </a> 
                                    <a href="{{ url('softdelete/slider/'.$slider->id) }}" class="btn btn-danger"> Delete </a> 
                                </td>
                                </tr>    
                                @endforeach               
                            </tbody>
                            </table>
                            {{ $sliders->links() }}
                        </div>
                    </div>

        {{-- Trash List starts --}}
        <div style="clear:both;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
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
            <div class="card-header"> Slider Trash List </div>
            <div class="card-body">
                <table class="table">
                <thead>
                    <tr>
                        <th scope="col" width="2%">#</th>
                        <th scope="col" width="10%">Slider Title</th>
                        <th scope="col" width="25%">Slider Description</th>
                        <th scope="col" width="10%">Slider Image</th>
                        <th scope="col" width="10%">Created</th>
                        <th scope="col" width="10%">Exact Time</th>
                        <th scope="col" width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($trashedSliders as $slider)
                    <tr>
                    <th scope="row">{{ $trashedSliders->firstItem()+$loop->index }}</th>
                    <td>{{ $slider->title }}</td>
                    <td>{{ $slider->description }}</td>
                    <td><img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}" width="150" height="100"/></td>
                    <td>
                        @if($slider->created_at == NULL)
                        <span class="text text-danger">No Time</span>
                        @else
                        {{ $slider->created_at->diffForHumans() }}
                        @endif
                    </td>
                    <td>
                        @if($slider->created_at == NULL)
                        <span class="text text-danger">No Date</span>
                        @else
                        {{ $slider->created_at }}
                        @endif
                    </td>
                    <td> 
                        <a href="{{ url('slider/restore/'.$slider->id) }}" class="btn btn-info text text-white"> Restore </a> 
                        <a href="{{ url('permanent_delete/slider/'.$slider->id) }}" class="btn btn-danger" onclick="return confirm('Sure? This action is irreversible!')"> Delete </a> 
                    </td>
                    </tr>    
                    @endforeach               
                </tbody>
                </table>
                {{ $trashedSliders->links() }}
            </div>
        </div>
        {{-- Trash List ends --}}
    
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"> Add Slider </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('persist.slider') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Slider Title</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="title">  
                                        
                                        @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Slider Description</label>
                                        <textarea class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="description" rows="5">  
                                        </textarea>                                        
                                        
                                        @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Slider Image</label>
                                        <input type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="image">  
                                        
                                        @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <button type="submit" class="btn btn-success" name="add_slider">Add Slider</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>

        </div>
</div>
@endsection
