<?php
use \Carbon\Carbon;
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card-header">Reviews</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($reviews as $review)
                            <div class="col-md-3">
                                <div class="alert alert-primary" role="alert">
                                    <h5>customer:{{$review->customer->formatName()}}</h5>
                                    <h5>product: {{$review->product->title}}</h5>
                                    <p>rating:
                                    @php
                                    $totalStars = 5;
                                    $currentStars = $review->stars;
                                    $remainingStars = $totalStars - $currentStars;
                                    @endphp
                                        @for($i = 0 ; $i<$currentStars;$i++)
                                            <i class="fas fa-star"></i>
                                        @endfor
                                        @for($j = 0 ; $j<$remainingStars;$j++)
                                            <i class="far fa-star"></i>
                                        @endfor
                                    </p>
                                    <p>review:<br> {{$review->review}}</p>
                                    <p>time: {{ $review->formatTimeForHuman() }}</p>
                                </div>
                            </div>
                        @endforeach
                        {{$reviews->links()}}
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection