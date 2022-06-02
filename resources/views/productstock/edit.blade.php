<div class="card bg-none card-box">
    {{ Form::model($productService, array('route' => array('productstock.update', $productService->id), 'method' => 'PUT')) }}
    <div class="row">

        <div class="form-group col-md-6">
            {{ Form::label('Product', __('Product'),['class'=>'form-control-label']) }}<br>
            {{$productService->name}}

        </div>
        <div class="form-group col-md-6">
            {{ Form::label('Product', __('SKU'),['class'=>'form-control-label']) }}<br>
            {{$productService->sku}}

        </div>

        <div class="form-group col-md-6 quantity">
{{--            {!! Form::label('quantity', __('Quantity'),['class'=>'form-control-label']) !!}--}}
            <div class="d-flex radio-check">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="plus_quantity" value="Add" name="quantity_type" class="custom-control-input" checked="checked">
                    <label class="custom-control-label" for="plus_quantity">{{__('Add Quantity')}}</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="minus_quantity" value="Less" name="quantity_type" class="custom-control-input">
                    <label class="custom-control-label" for="minus_quantity">{{__('Less Quantity')}}</label>
                </div>
            </div>
        </div>

        <div class="form-group col-md-12">
            {{ Form::label('quantity', __('Quantity'),['class'=>'form-control-label']) }}<span class="text-danger">*</span>
            {{ Form::number('quantity',"", array('class' => 'form-control','required'=>'required')) }}
        </div>


        <div class="col-md-12">
            <input type="submit" value="{{__('Save')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
