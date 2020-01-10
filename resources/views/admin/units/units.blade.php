@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Units</div>
                    <div class="card-body">
                            <form class="row" action="{{route('units')}}" method="post">
                                @csrf
                                <div class="form-group col-md-6" >
                                    <label for="unit_name">unit name</label>
                                    <input type="text" class="form-control" id="unit_name" name="unit_name" placeholder="unit name" required>
                                </div>
                                <div class="form-group col-md-6" >
                                    <label for="unit_code">unit code</label>
                                    <input type="text" class="form-control" id="unit_code" name="unit_code" placeholder="unit code" required>
                                </div>
                                <div class="form-group col-md-12" >
                                    <button type="submit" class="btn btn-primary">Save new unit</button>
                                </div>
                            </form>
                        <div class="row">
                    @foreach($units as $unit)
                        <div class="col-md-3">
                                <div class="alert alert-primary" role="alert">
                                     <span>
                                        <form action="{{route('units')}}" method="post" style="position:relative;">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="unit_id" value="{{$unit->id}}">
                                            <button type="submit" class="delete-btn"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </span>
                                    <p>{{$unit->unit_name}} , {{$unit->unit_code}}</p>
                                </div>
                        </div>
                    @endforeach
                            {{$units->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Session::has('message'))
        <div class="toast" style="position: absolute; z-index: 99999; top: 5%; right: 5%;">
            <div class="toast-header" style="background-color: #2a9055;color: #f8f9fa;">
                <strong class="mr-auto">Unit</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close" style="color: #f7f7f7;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body" style="background-color: #38c172;color: #f8f9fa;">
                    {{Session::get('message')}}
            </div>
        </div>
    @endif
@endsection
@if(Session::has('message'))
@section('scripts')
    <script>
        $(document).ready(function($){
            var $toast = $('.toast').toast({
                delay : 1500
            });
            $toast.toast('show');
        });
    </script>

@endsection
@endif