@extends('layouts.app')
@section('search')
    <form class="form-inline my-2 my-lg-0" action="{{route('search-categories')}}" method="get">
        @csrf
        <input class="form-control mr-sm-2" id="category-search" name="category_search" type="search" placeholder="Search categories" aria-label="Search" required>
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">categories</div>
                        <div class="card-body">
                            <form class="row" action="{{route('categories')}}" method="post">
                                @csrf
                                <div class="form-group col-md-6" >
                                    <label for="category_name">category</label>
                                    <input type="text" class="form-control" id="category_name" name="category_name" placeholder="new category" required>
                                </div>
                                <div class="form-group col-md-12" >
                                    <button type="submit" class="btn btn-primary">Save new category</button>
                                </div>
                            </form>
                            <div class="row">
                                @foreach($categories as $category)
                                    <div class="col-md-3">
                                        <div class="alert alert-danger" role="alert">
                                            <span class="buttons-container">
                                        <span><a class="edit-button"
                                                 data-categoryid="{{$category->id}}"
                                                 data-categoryname="{{$category->name}}"
                                            ><i class="fas fa-edit"></i></a></span>
                                        <span><a class="delete-button"
                                                 data-categoryid="{{$category->id}}"
                                                 data-categoryname="{{$category->name}}"
                                            ><i class="fas fa-trash-alt"></i></a></span>
                                    </span>
                                            <p>{{$category->name}}</p>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            {{(! is_null($showLinks) && $showLinks)?$categories->links():''}}
                        </div>
                </div>

            </div>
        </div>
    </div>
    <!--model for delete category-->
    <div class="modal delete-window" tabindex="-1" role="dialog" id="delete-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete category</h5>
                </div>
                <form action="{{route('categories')}}" method="post" style="position:relative;">
                    @csrf
                    <div class="modal-body">
                        <p class="delete-message"></p>
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="category_id" value="" id="delete-category-id"> <!--id for using on jquery "$hiddenDeleteInput"-->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn btn-danger">DELETE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--model for edit category-->
    <div class="modal edit-window" tabindex="-1" role="dialog" id="edit-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit category</h5>
                </div>
                <div class="modal-body">
                    <form action="{{route('categories')}}" method="post">
                        @csrf
                        <div class="form-group col-md-6" >
                            <label for="edit-category-name">category</label>
                            <input type="text" class="form-control" id="edit-category-name" name="category_name" placeholder="category" required>
                        </div>
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="category_id" value="" id="edit-category-id"> <!--id for using on jquery "$hiddenEditInput"-->
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
                <strong class="mr-auto">Categories</strong>
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
       var $hiddenDeleteInput = $('#delete-category-id');
       var $deleteMessage = $('.delete-message');
       $($deleteButton).click(function (element) {
           element.preventDefault();
           $deleteWindow.modal('show');
           var dCategoryId = $(this).data('categoryid');
           var dCategoryName = $(this).data('categoryname');
           $deleteMessage.text('are you sure you want to delete ' + dCategoryName + ' ?');
           $hiddenDeleteInput.val(dCategoryId);
       });
       //TODO:Edit
       var $editButton = $('.edit-button');
       var $editWindow = $('#edit-window');
       var $hiddenEditInput = $('#edit-category-id');
       var $inputCategoryName = $('#edit-category-name');
       $($editButton).click(function (element) {
           element.preventDefault();
           $editWindow.modal('show');
           var eCategoryId = $(this).data('categoryid');
           var eCategoryName = $(this).data('categoryname');
           $hiddenEditInput.val(eCategoryId);
           $inputCategoryName.val(eCategoryName);
       });




    </script>

@endsection