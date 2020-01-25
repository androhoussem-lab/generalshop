@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Products <a class="btn btn-primary" href="{{route('new-product')}}"><i class="fas fa-plus-circle"></i></a></div>
                    <div class="card-body">
                        <div class="row">
                           @foreach($products as $product)
                                <div class="col-md-4">
                                    <div class="alert alert-success" role="alert">
                                        <h5>{{$product->title}}</h5>
                                        <p>{{$product->category->name}}</p>
                                        <p>{{$currency_code}}{{$product->price}}</p>
                                        {!! ( count( $product->images ) > 0 ) ? '<img alt = "product image" class="img-thumbnail card-img" src="'. $product->images[0]->url .'">' : '<img alt = "product image" class="img-thumbnail card-img" src="https://cdn.icon-icons.com/icons2/1713/PNG/512/iconfinder-boxemptyplaybuttonvideo-3993859_112670.png">' !!}
                                        <a class="btn btn-success mt-2" href="{{route('update-product' , ['id' => $product->id])}}">Update</a>
                                    </div>
                                </div>
                           @endforeach
                        </div>
                        {{$products->links()}}
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection