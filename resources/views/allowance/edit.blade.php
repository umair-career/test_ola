<div class="card bg-none card-box">
    {{Form::model($allowance,array('route' => array('allowance.update', $allowance->id), 'method' => 'PUT')) }}
    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('allowance_option', __('Allowance Options')) }}<span class="text-danger">*</span>
                    {{ Form::select('allowance_option',$allowance_options,null, array('class' => 'form-control select2','required'=>'required')) }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('title', __('Title')) }}
                    {{ Form::text('title',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('type', __('Type'), ['class' => 'form-control-label']) }}
                    {{ Form::select('type', $Allowancetypes, null, ['class' => 'form-control select2 amount_type', 'required' => 'required']) }}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('amount', __('Amount')) }}
                    {{ Form::number('amount',null, array('class' => 'form-control ','required'=>'required')) }}
                </div>
            </div>
        </div>
        <div class="col-12 pt-5 text-right">
            <input type="submit" value="{{__('Update')}}" class="btn-create badge-blue">
            <input type="button" value="{{__('Cancel')}}" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
    {{Form::close()}}
</div>
