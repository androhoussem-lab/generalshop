@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    {!! (! is_null($product))?'Update product <span class="product-header">' .$product->title.'</span>':'New product'  !!}
                </div>
                <div class="card-body">
                    <form  action="{{( ! is_null($product))?route('update-product'):route('new-product')}}" method="post">
                        @csrf
                        @if(! is_null($product))
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="product_id" id="product-id" value="{{$product->id}}">
                        @endif
                        <div class="form-group col-md-8" >
                            <label for="product_title">Title</label>
                            <input type="text" class="form-control" id="product_title" value="{{(! is_null($product))?$product->title:''}}" name="product_title" placeholder="title" required>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="description">Description</label>
                            <textarea class="form-control"  name="description" id="description" rows="3" required>{{(! is_null($product))?$product->description:''}}</textarea>
                        </div>
                        <div class="form-group col-md-8" >
                            <label for="category">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option>select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                            {{ (! is_null($product) && ($product->category->id === $category->id))?'selected':'' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-8" >
                            <label for="unit">Unit</label>
                            <select class="form-control" name="unit" id="unit" required>
                                <option>select a unit</option>
                                @foreach($units as $unit)
                                    <option value="{{$unit->id}}"
                                            {{ (! is_null($product) && ($product->unit->id === $unit->id))?'selected':'' }}
                                    >{{$unit->formattedName()}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-8" >
                            <label for="price">Price</label>
                            <input type="number" step="any" class="form-control" id="price" value="{{(! is_null($product))?$product->price:''}}" name="price" placeholder="price" required>
                        </div>
                        <div class="form-group col-md-8" >
                            <label for="total">Total</label>
                            <input type="number"  class="form-control" id="total" value="{{(! is_null($product))?$product->total:''}}" name="total" placeholder="total" required>
                        </div>
                        <div class="form-group col-md-8" >
                            <label for="discount">Discount</label>
                            <input type="number" step="any" class="form-control" id="discount" value="{{(! is_null($product))?$product->discount:0}}" min="0" max="100" name="discount" placeholder="discount" required>
                        </div>

                        <!--options-->
                        <div class="form-group col-md-12">
                            <table class="table table-bordered" id="option-table"></table>
                            <a class="btn btn-warning add-option-btn" href="#">add option</a>
                        </div>
                        <!--/options-->
                        <!--images-->
                        <div class="form-group col-md-12">
                            <div class="row">
                                @for( $i = 0 ; $i < 6 ; $i++ )
                                    <div class="col-md-4 col-sm-12 mb-4">
                                        <div class="card image-card-upload">
                                            <a href="#" class="activate-image-upload">
                                                <div class="card-body" style="text-align: center">
                                                    <p><i class="fas fa-camera-retro"></i></p>
                                                    <form>
                                                        <div class="form-group">
                                                            <input type="file" class="form-control-file image-file-upload" name="product-images[]" id="image-{{$i}}">
                                                        </div>
                                                    </form>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                        <!--images-->
                        <div class="form-group col-md-6 offset-md-3" >
                            <button type="submit" class="btn btn-primary btn-block">Save new product</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        </div>
    </div>
    <!--model for new option-->
    <div class="modal option-window" tabindex="-1" role="dialog" id="option-window">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">new option</h5>
                </div>
                <div class="modal-body row">
                        <div class="form-group col-md-6" >
                            <label for="add-option-name">option name</label>
                            <input type="text" class="form-control" id="option-name" name="option_name" placeholder="option name" required>
                        </div>
                        <div class="form-group col-md-6" >
                            <label for="add-option-value">option value</label>
                            <input type="text" class="form-control" id="option-value" name="option_value" placeholder="option value" required>
                        </div>
                        <div class="modal-footer col-md-12">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                            <button type="submit" class="btn btn-primary save-option-btn">SAVE</button>
                        </div>

                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){

        var $optionWindow = $('.option-window');
        var $addOptionButton = $('.add-option-btn');
        var $imageUploadeButton = $('a.activate-image-upload');
        var optionNamesRow = '';

        $($addOptionButton).click(function (element) {
            element.preventDefault();
            $optionWindow.modal('show');

        });

        /////
        $(document).on('click','.save-option-btn',function (element) {
            element.preventDefault();
            var optionTable = $('#option-table');

            var $optionName = $('#option-name');
            if ($optionName.val() === '') {
                alert('option name is required');
                return false;
            }
            var $optionValue = $('#option-value');
            if ($optionValue.val() === '') {
                alert('option value is required');
                return false;
            }

            optionNamesRow = '<input type="hidden" name="options[]" value="' + $optionName.val() + '">'; //color[],size[]

            var optionRow = `
                <tr>
                    <td>
                        `+$optionName.val()+`
                    </td>
                    <td>
                        `+$optionValue.val()+`
                    </td>
                    <td>
                        <a class="btn btn-danger remove-option" href="#">Delete</a>
                        <input type="hidden" name="`+$optionName.val()+`[]" value="`+$optionValue.val()+`">
                    </td>
                </tr>
            `;
            optionTable.append(optionRow);
            optionTable.append(optionNamesRow);
            $optionValue.val('');


            $('.remove-option').click(function (element) {
                element.preventDefault();
                $(this).parent().parent().remove(); //parent 01 = <td> parent 02 = <tr>
            });



        });
        $($imageUploadeButton).click(function (element) {
            element.preventDefault();

        });

    });
</script>
@endsection