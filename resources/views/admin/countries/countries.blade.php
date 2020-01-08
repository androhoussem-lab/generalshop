@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card-header">Countries</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($countries as $country)
                            <div class="col-md-3">
                                <div class="alert alert-primary" role="alert">
                                    <h5>country name:{{$country->name}}</h5>
                                    <p>currency:{{$country->currency}}</p>
                                    <p>code:{{$country->iso3}}</p>
                                </div>
                            </div>
                        @endforeach
                        {{$countries->links()}}
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

@endsection