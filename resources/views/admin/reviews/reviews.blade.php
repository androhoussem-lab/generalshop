@extends('layouts.app')
@section('search')
    <form class="form-inline my-2 my-lg-0" action="{{route('search-reviews')}}">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card-header">Reviews</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($reviews as $review)
                            <div class="col-md-3">
                                <div class="alert alert-light" role="alert">
                                    <span class="buttons-container">
                                        <span><a class="delete-button"
                                                 data-reviewid="{{$review->id}}"
                                            ><i class="fas fa-trash-alt"></i></a></span>
                                    </span>
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
                    </div>
                    {{$reviews->links()}}
                    <!--form for add new review-->
                    <h3>New review</h3>
                    <form  action="{{route('reviews')}}" method="post">
                        @csrf
                            <div class="form-group col-md-6">
                                <label for="user">User id</label>
                                <input type="number" class="form-control" id="user" name="user" value="{{Auth::user()->id}}" min="{{Auth::user()->id}}" max="{{Auth::user()->id}}" required>
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="products">Product id</label>
                                    <select name="products" class="form-control" id="products">
                                        @foreach($products as $product)
                                        <option>{{$product->id}}</option>
                                        @endforeach
                                    </select>
                            </div>
                            <div class="form-group col-md-6" >
                                <label for="stars">Stars</label>
                                <select name="stars" class="form-control" id="stars">
                                    @for($stars = 1 ;$stars <= 5; $stars++)
                                        <option>{{$stars}}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="review">Review</label>
                                <textarea class="form-control" name="review" id="review" rows="3"></textarea>
                            </div>
                            <div class="form-group col-md-6" >
                                <button type="submit" class="btn btn-primary">SEND</button>
                            </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!--model for delete tag-->
    <div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete review</h5>
                </div>
                <form action="{{route('reviews')}}" method="post" style="position:relative;">
                    @csrf
                    <div class="modal-body">
                        <p> Are you sur you want to delete this review?</p>
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="review_id" value="" id="delete-review-id"> <!--id for using on jquery "$hiddenDeleteInput"-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Session-->
    @if(Session::has('message'))
        <div class="toast" style="position: absolute; z-index: 99999; top: 5%; right: 5%;">
            <div class="toast-header" style="background-color: #2a9055;color: #f8f9fa;">
                <strong class="mr-auto">Review</strong>
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
@section('scripts')
    <!--check if session has message for start javascript code & show toast 'javascript part' -->
    @if(Session::has('message'))
        <script>
            $(document).ready(function($){
                var $toast = $('.toast').toast({
                    delay : 2000
                });
                $toast.toast('show');
            });
        </script>
    @endif
    <script>
        var $deleteButton = $('.delete-button');
        var $deleteWindow = $('#delete-window');
        var $hiddenInput =$('#delete-review-id');
        $($deleteButton).click(function (element) {
            element.preventDefault();
            $deleteWindow.modal('show');
            var reviewId = $(this).data('reviewid');
            $hiddenInput.val(reviewId);

        });
    </script>
@endsection