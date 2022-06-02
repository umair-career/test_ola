 <form action="{{ url('company-update/'.$company->id )}}" method="POST">
            @csrf
<div class="card bg-none card-box">
    <div class="row">
         <div class="form-group col-md-12">
            <label>Edit Your Name</label>
            <input type="text" value="{{$company->name}}" name="company" class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button  class="btn btn-primary bg-gray" data-dismiss="modal">{{__('Cancel')}}</button>
        </div>
    </div>
</div>
</form>