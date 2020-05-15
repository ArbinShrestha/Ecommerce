@extends('layouts.app')

@section('products')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">New Products</div>

                    <div class="card-body">
                    <form action="{{route('products.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" autocomplete="off">
                        {{--@error('name')--}}
                        {{--<small class="text-danger">{{$message}}</small>--}}
                        {{--@enderror--}}
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" value="{{old('price')}}">

                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file" name="image">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="3" cols="10" >{{old('description')}}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button type="submit" class="btn btn-success">Save products</button>
                        </div>
                    </div>
                </form>
            </div>
             </div>
            </div>
        </div>

        </div>
    </div>




    @endsection
