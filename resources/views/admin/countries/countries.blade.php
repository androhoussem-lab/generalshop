@extends('layouts.app')
@section('search')
    <form class="form-inline my-2 my-lg-0" action="{{route('search-countries')}}" method="GET">
        <input class="form-control mr-sm-2" type="search" name="search_country" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card-header">Countries</div>
                <div class="card-body">
                    <div class="row">
                        @foreach($countries as $country)
                            <div class="col-md-3">
                                <div class="alert alert-success" role="alert">
                                    <span class="buttons-container">
                                         <span><a class="delete-button"
                                                  data-countryid="{{$country->id}}"
                                                  data-countryname="{{$country->name}}"
                                             ><i class="fas fa-trash-alt"></i></a>
                                        </span>
                                    </span>
                                    <h5>country name:{{$country->name}}</h5>
                                    <p>currency:{{$country->currency}}</p>
                                    <p>code:{{$country->iso3}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{(! is_null($showLinks) && $showLinks)?$countries->links():''}}
                </div>
                <h3>Add new country</h3>
                <form  action="{{route('countries')}}" method="post">
                    @csrf
                    <div class="form-group col-md-6" >
                        <label for="country_name">Name</label>
                        <input type="text" class="form-control" id="country_name" name="country_name" placeholder="country name" required>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="iso03">ISO03</label>
                        <input type="text" class="form-control" id="iso03" name="iso03" placeholder="iso03" required>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="iso02">ISO02</label>
                        <input type="text" class="form-control" id="iso02" name="iso02" placeholder="iso02" required>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="phone_code">Phone code</label>
                        <input type="text" class="form-control" id="phone_code" name="phone_code" placeholder="phone code" required>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="capital">Capital</label>
                        <input type="text" class="form-control" id="capital" name="capital" placeholder="capital" required>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="currency">Currency</label>
                        <input type="text" class="form-control" id="currency" name="currency" placeholder="currency" required>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="flag">Flag</label>
                        <input type="text" class="form-control" id="flag" name="flag" placeholder="flag" required>
                    </div>
                    <div class="form-group col-md-6" >
                        <label for="wikipedia_data_id">Wikipedia data id</label>
                        <input type="text" class="form-control" id="wikipedia_data_id" name="wikipedia_data_id" placeholder="wikipedia data id" required>
                    </div>
                    <div class="form-group col-md-12" >
                        <button type="submit" class="btn btn-primary">Save new Country</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    <!--model for delete tag-->
    <div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete country</h5>
                </div>
                <form action="{{route('countries')}}" method="post" style="position:relative;">
                    @csrf
                    <div class="modal-body">
                        <p class="delete-message"></p>
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="country_id" value="" id="delete-country-id"> <!--id for using on jquery "$hiddenDeleteInput"-->
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
                <strong class="mr-auto">countries</strong>
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
        //TODO:Delete
        var $deleteButton = $('.delete-button');
        var $deleteWindow = $('#delete-window');
        var $hiddenInput = $('#delete-country-id');
        var $deleteMessage = $('.delete-message');
        $($deleteButton).click(function (element) {
            element.preventDefault();
            $deleteWindow.modal('show');
            var countryId = $(this).data('countryid');
            var countryName = $(this).data('countryname');
            $deleteMessage.text('are you sure you want to delete ' + countryName + ' ?');
            $hiddenInput.val(countryId);
        });
    </script>
@endsection