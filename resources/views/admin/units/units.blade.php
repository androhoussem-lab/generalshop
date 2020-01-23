@extends('layouts.app')
<!--header search -->
@section('search')
    <form class="form-inline my-2 my-lg-0" action="{{route('search-units')}}" method="get">
        @csrf
        <input class="form-control mr-sm-2" id="unit-search" name="unit-search" type="search" placeholder="Search unit" aria-label="Search" required>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
@endsection

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
                                <div class="alert alert-secondary" role="alert">
                                    <span class="buttons-container">
                                        <span><a class="edit-button"
                                                 data-unitid="{{$unit->id}}"
                                                 data-unitname="{{$unit->unit_name}}"
                                                 data-unitcode="{{$unit->unit_code}}"
                                            ><i class="fas fa-edit"></i></a></span>
                                        <span><a class="delete-button"
                                                 data-unitid="{{$unit->id}}"
                                                 data-unitname="{{$unit->unit_name}}"
                                                 data-unitcode="{{$unit->unit_code}}"
                                            ><i class="fas fa-trash-alt"></i></a></span>
                                    </span>
                                    <p>{{$unit->unit_name}} , {{$unit->unit_code}}</p>
                                </div>
                        </div>
                    @endforeach

                        </div>
                        {{(! is_null($showLinks) && $showLinks)?$units->links():''}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--model for delete unit-->
        <div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete unit</h5>
                </div>
                <form action="{{route('units')}}" method="post" style="position:relative;">
                    @csrf
                    <div class="modal-body">
                        <p class="delete-message"></p>
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="unit_id" value="" id="delete-unit-id"> <!--id for using on jquery "$hiddenDeleteInput"-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--model for edit unit-->
    <div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit unit</h5>
                </div>
                <div class="modal-body">
                    <form class="row" action="{{route('units')}}" method="post">
                        @csrf
                        <div class="form-group col-md-6" >
                            <label for="edit-unit_name">unit name</label>
                            <input type="text" class="form-control" id="edit-unit-name" name="unit_name" placeholder="unit name" required>
                        </div>
                        <div class="form-group col-md-6" >
                            <label for="edit-unit_code">unit code</label>
                            <input type="text" class="form-control" id="edit-unit-code" name="unit_code" placeholder="unit code" required>
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="unit_id" value="" id="edit-unit-id"> <!--id for using on jquery "$hiddenUpdateInput"-->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                            <button type="submit" class="btn btn-primary">UPDATE</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!--check if session has message for start javascript code & show toast 'bootstrap part' -->
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


@section('scripts')
    <script>

        $(document).ready(function () {
            //TODO:Delete unit
            var $deleteButton = $('.delete-button'); // 111 ,$ for a hint that this variable is html element ,get element by class
            var $deleteWindow = $('#delete-window'); // get element 'pop-up window' by id
            var $hiddenDeleteInput = $('#delete-unit-id'); //get hidden input 'element' with id = "unit_id"
            var $deleteMessage = $('.delete-message'); //get element 'p' with his class="delete-message"
            $deleteButton.click(function (element) {
                element.preventDefault(); //block default behavior
                $deleteWindow.modal('show'); // show the pop-up window
                var unitId = $(this).data('unitid'); //get the data named unitid from  anchor  111
                var unitName = $(this).data('unitname');
                var unitCode = $(this).data('unitcode');
                //console.log(unitName + ' ' + unitCode);
                $deleteMessage.text('are you sure you want to delete ' + unitName + ' with code ' + unitCode + ' ?');
                $hiddenDeleteInput.val(unitId); //add this data to value of hidden input
                //1:22:00

            });

            //TODO:Edit unit
            var $editButton = $('.edit-button');
            var $editWindow = $('.edit-window');
            var $hiddenEditInput = $('#edit-unit-id');
            var $inputUnitName = $('#edit-unit-name');
            var $inputUnitCode = $('#edit-unit-code');
            $editButton.click(function ( element ) {
                element.preventDefault();
                $editWindow.modal('show');
                var unitId = $(this).data('unitid');
                var unitName = $(this).data('unitname');
                var unitCode = $(this).data('unitcode');
                $hiddenEditInput.val(unitId);
                $inputUnitName.val(unitName);
                $inputUnitCode.val(unitCode);
            });
            
        });

    </script>

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
@endsection
