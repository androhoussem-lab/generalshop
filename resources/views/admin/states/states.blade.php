@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card-header">States</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($states as $state)
                            <div class="col-md-3">
                                <div class="alert alert-primary" role="alert">
                                    <h5>state name: {{$state->name}}</h5>
                                    <p>country name: {{$state->country->name}}</p>
                                </div>
                            </div>
                        @endforeach
                        {{$states->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection