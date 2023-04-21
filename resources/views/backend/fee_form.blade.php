@extends('layout.backend')

@push('css')
<style>
.attribute_cls {
    cursor: pointer;
    color: #e46e6e;
    font-weight: bold;
}
</style>
@endpush

@section('title', 'Fee Form')

@section('content')
<form method="POST" enctype="multipart/form-data">
@csrf
<div class="row">
    @php
        $attribute_name_list = "";
        if(count($productattribute) > 0){
            $lastElement = end($productattribute);
            foreach($productattribute as $key => $detail){
                $attribute_name_list .= "<span class='attribute_cls'>|$detail|</span>";
                if($detail != $lastElement){
                    $attribute_name_list .= ", ";
                }
            }
        }
        $fee_config_condition_data['attribute_select'] = 0;
        $fee_config_condition_data['attribute_condition'] = 0;
        $fee_config_condition_data['attribute_condition_value'] = '';
        $fee_config_condition_data['config'] = '';

        if($feeConfig->fee_config_condition && $feeConfig->fee_config_condition != null && $feeConfig->fee_config_condition != ''){
            $resultData = json_decode($feeConfig->fee_config_condition, true);

            if($resultData['attribute_select'] != 0){
                $fee_config_condition_data['attribute_select'] = $resultData['attribute_select'];
            }
            if($resultData['attribute_condition'] != 0){
                $fee_config_condition_data['attribute_condition'] = $resultData['attribute_condition'];
            }
            if($resultData['attribute_condition_value'] != '' && $resultData['attribute_condition_value'] != null){
                $fee_config_condition_data['attribute_condition_value'] = $resultData['attribute_condition_value'];
            }
            if($resultData['config'] != '' && $resultData['config'] != null){
                $fee_config_condition_data['config'] = $resultData['config'];
            }
        }

    @endphp
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="fee_name">Fee name <span class="text-danger">*</span> : </label>
                            <input type="text" class="form-control" name="fee_name" id="fee_name" placeholder="Fee name" value="{{ $feeConfig->fee_name }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="fee_config">Fee Config  : </label>
                            <small class="form-control-feedback">using the attribute_name as a value to calculate fees - include | charactor (this version only support number attribute).</small>
                            <input type="text" class="form-control" name="fee_config" id="fee_config" placeholder="use |attribute_name| for config fee" value="{{ $feeConfig->fee_config }}">
                            <small class="form-control-feedback"> attribute_name list : {!! html_entity_decode($attribute_name_list) !!} </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="fee_config_condition">Fee Config Conditional : </label>
                            <small class="form-control-feedback">If the product has the appropriate attribute for the configuration condition, the fee will be calculated according to the following formula.(this version only support 1 conditions)</small>
                            <div class="row">
                                <div class="col-4">
                                    <select class="form-control custom-select" name="fee_config_condition_data[attribute_select]">
                                        <option value="0">Select</option>
                                        @foreach($productattributefull as $detail)
                                                <option {{ ($fee_config_condition_data['attribute_select'] == $detail['pa_id']) ? 'selected' : '' }} value="{{$detail['pa_id']}}">{{$detail['pa_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select class="form-control custom-select" name="fee_config_condition_data[attribute_condition]">
                                        <option {{ ($fee_config_condition_data["attribute_condition"] == '0') ? 'selected' : '' }} value="0">Select</option>
                                        <option {{ ($fee_config_condition_data["attribute_condition"] == '1') ? 'selected' : '' }} value="1">=</option>
                                        <option {{ ($fee_config_condition_data["attribute_condition"] == '2') ? 'selected' : '' }} value="2">>=</option>
                                        <option {{ ($fee_config_condition_data["attribute_condition"] == '3') ? 'selected' : '' }} value="3="><=</option>
                                        <option {{ ($fee_config_condition_data["attribute_condition"] == '4') ? 'selected' : '' }} value="4">></option>
                                        <option {{ ($fee_config_condition_data["attribute_condition"] == '5') ? 'selected' : '' }} value="5"><</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" name="fee_config_condition_data[attribute_condition_value]" placeholder="Value of attribute" value="{{ $fee_config_condition_data['attribute_condition_value'] }}">
                                </div>
                            </div>
                            <input type="text" class="form-control mt-3" name="fee_config_condition_data[config]" placeholder="use |attribute_name| for config fee" value="{{ $fee_config_condition_data['config'] }}">
                            <small class="form-control-feedback"> attribute_name list : {!! html_entity_decode($attribute_name_list) !!} </small>
                        </div>
                    </div>
                </div>
                <a href="{{route('backend.fee_manager')}}"><button type="button" class="btn btn-default waves-effect waves-light m-r-10">Back</button></a>
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