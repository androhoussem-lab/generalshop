@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tickets</div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($tickets as $ticket)
                                <div class="col-md-3">
                                    <div class="alert alert-primary" role="alert">
                                        <p>created by:{{$ticket->customer->formatName()}}</p>
                                        <p>type:{{$ticket->ticketType->name}}</p>
                                        <p>title:{{$ticket->title}}</p>
                                        <p>content:{{$ticket->message}}</p>
                                        <h5>status:{{$ticket->status}}</h5>
                                        <p>created at:{{$ticket->formatTimeForHuman()}}</p>
                                    </div>
                                </div>
                            @endforeach
                            {{$tickets->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
