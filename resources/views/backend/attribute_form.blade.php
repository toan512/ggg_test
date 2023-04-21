@extends('layout.backend')

@section('title', 'Attribute Form')

@section('content')
<form method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pa_text_show">Product Attribute Text <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" name="pa_text_show" id="pa_text_show" placeholder="Text show on frontend" value="{{ $productattribute->pa_text_show }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pa_name">Product Attribute Name <span class="text-danger">(Only letter normal a-z and character _)*</span> : </label>
                            <input type="text" class="form-control" name="pa_name" id="pa_name" placeholder="username for config fee" value="{{ $productattribute->pa_name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pa_name">Regular expression <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" name="regular_exp" id="regular_exp" placeholder="username for config fee" value="{{ $productattribute->regular_exp }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="regular_exp_index">Regular expression index <span class="text-danger">(index of function preg_match() regex, only number)*</span> : </label>
                            <input type="text" class="form-control" name="regular_exp_index" id="regular_exp_index" placeholder="username for config fee" value="{{ $productattribute->regular_exp_index }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="pa_type">Attribute Value Type <span class="text-danger">*</span> : </label>
                            <select name="pa_type" id="pa_type" class="form-control">
                                <option {{ ($productattribute->pa_type === 'text' || $productattribute == null) ? 'selected' : '' }} value="text">Text</option>
                                <option {{ ($productattribute->pa_type === 'number') ? 'selected' : '' }} value="number">Number</option>
                            </select>
                        </div>
                    </div>
                </div>
                <a href="{{route('backend.attribute_manager')}}"><button type="button" class="btn btn-default waves-effect waves-light m-r-10">Back</button></a>
                <button type="submit" class="btn btn-success waves-effect waves-light m-r-20">Submit</button>
            </div>
        </div>
    </div>
</div>
</form>

@endsection

@push('script')
<script>
  $(document).ready(function(){
    

  });
</script>
@endpush