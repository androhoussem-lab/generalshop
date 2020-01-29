@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Products <a class="btn btn-outline-success mr-3"  href="{{route('new-product')}}">New product</a></div>
                    <div class="card-body">
                        <div class="row">
                           @foreach($products as $product)
                                <div class="col-md-4">
                                    <div class="alert alert-success" role="alert">
                                        <h5>{{$product->title}}</h5>
                                        <p>{{$product->category->name}}</p>
                                        <p>{{$currency_code}}{{$product->price}}</p>
                                        @if(! is_null($product->options))
                                            <div class="row">
                                            <div class="form-group col-md-12">
                                            <label for="options"  >options</label>
                                            <select id="options" class="form-control" multiple>
                                            @foreach($product->jsonOptions() as $optionKey => $optionValue)
                                                    <optgroup label="{{$optionKey}}">
                                                @foreach($optionValue as $option)

                                                        <option>{{$option}}</option>

                                                @endforeach
                                                    </optgroup>
                                            @endforeach
                                            </select>
                                            </div>
                                            </div>
                                        @endif

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
    <!--Session-->
    @if(Session::has('message'))
        <div class="toast" style="position: absolute; z-index: 99999; top: 5%; right: 5%;">
            <div class="toast-header" style="background-color: rebeccapurple;color: #FFF;">
                <strong class="mr-auto">Products</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close" style="color: #f7f7f7;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body" style="background-color: deeppink;color: #FFF;">
                {{Session::get('message')}}
            </div>
        </div>
    @endif
@endsection
@section('scripts')
    <!--check if session has message for start javascript code & show toast 'javascript part' -->
    @if(Session::has('message'))
        <script>
            $(document).ready(function($){
                var $toast = $('.toast').toast({
                    delay : 5000
                });
                $toast.toast('show');
            });
        </script>
    @endif
@endsection