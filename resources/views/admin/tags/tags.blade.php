@extends('layouts.app')
@section('search')
    <form class="form-inline my-2 my-lg-0" action="{{route('search-tags')}}" method="get">
        @csrf
        <input class="form-control mr-sm-2" id="tag-search" name="tag_search" type="search" placeholder="Search tags" aria-label="Search" required>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <div class="card-header">Tags</div>
            <div class="card-body">
                <form class="row" action="{{route('tags')}}" method="post">
                    @csrf
                    <div class="form-group col-md-6" >
                        <input type="text" class="form-control" id="tag_name" name="tag_name" placeholder="new tag" required>
                    </div>
                    <div class="form-group col-md-12" >
                        <button type="submit" class="btn btn-primary">Save new tag</button>
                    </div>
                </form>
                <div class="row">
                    @foreach($tags as $tag)
                        <div class="col-md-3">
                            <div class="alert alert-success" role="alert">
                                 <span class="buttons-container">
                                        <span><a class="edit-button"
                                                 data-tagid="{{$tag->id}}"
                                                 data-tagname="{{$tag->tag}}"
                                            ><i class="fas fa-edit"></i></a></span>
                                        <span><a class="delete-button"
                                                 data-tagid="{{$tag->id}}"
                                                 data-tagname="{{$tag->tag}}"
                                            ><i class="fas fa-trash-alt"></i></a></span>
                                 </span>
                                <p>{{$tag->tag}}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
                {{(! is_null($showLinks) && $showLinks)?$tags->links() : ''}}
            </div>

        </div>
    </div>
</div>

<!--model for delete tag-->
<div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete tag</h5>
            </div>
            <form action="{{route('tags')}}" method="post" style="position:relative;">
                @csrf
                <div class="modal-body">
                    <p class="delete-message"></p>
                    <input type="hidden" name="_method" value="DELETE">
                    <input type="hidden" name="tag_id" value="" id="delete-tag-id"> <!--id for using on jquery "$hiddenDeleteInput"-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                    <button type="submit" class="btn btn-danger">DELETE</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--model for edit tag-->
<div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit tag</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('tags')}}" method="post">
                    @csrf
                    <div class="form-group col-md-6" >
                        <label for="edit-tag-name">tag</label>
                        <input type="text" class="form-control" id="edit-tag-name" name="tag_name" placeholder="tag" required>
                    </div>
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="tag_id" value="" id="edit-tag-id"> <!--id for using on jquery "$hiddenUpdateInput"-->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!--Session-->
@if(Session::has('message'))
    <div class="toast" style="position: absolute; z-index: 99999; top: 5%; right: 5%;">
        <div class="toast-header" style="background-color: #2a9055;color: #f8f9fa;">
            <strong class="mr-auto">Tags</strong>
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
        var $hiddenDeleteInput = $('#delete-tag-id');
        var $deleteMessage = $('.delete-message');
        $($deleteButton).click(function (element) {
            element.preventDefault();
            $deleteWindow.modal('show');
            var dTagId = $(this).data('tagid'); //d for delete
            var dTagName = $(this).data('tagname');
            $deleteMessage.text('are you sure you want to delete ' + dTagName +' ?');
            $hiddenDeleteInput.val(dTagId);
        });

        //TODO:Update
        var $editButton = $('.edit-button');
        var $editWindow = $('#edit-window');
        var $hiddenUpdateInput = $('#edit-tag-id');
        var $inputTagName = $('#edit-tag-name');
        $($editButton).click(function (element) {
            element.preventDefault();
            $editWindow.modal('show');
            var eTagId = $(this).data('tagid'); //e for edit
            var eTagName = $(this).data('tagname');
            $hiddenUpdateInput.val(eTagId);
            $inputTagName.val(eTagName);
        })


        
    
    </script>
@endsection