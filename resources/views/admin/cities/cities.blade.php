@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card-header">Cities</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($cities as $city)
                            <div class="col-md-3">
                                <div class="alert alert-primary" role="alert">
                                    <h5>city name: {{$city->name}}</h5>
                                    <p>state name: {{$city->state->name}}</p>
                                    <p>country name: {{$city->country->name}}</p>
                                </div>
                            </div>
                        @endforeach
                        {{$cities->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection