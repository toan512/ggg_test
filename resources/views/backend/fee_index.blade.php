@extends('layout.backend')

@push('css')
<style>

</style>
@endpush

@section('title', 'Manager Fee')

@section('content')

<style>
</style>
<div class="row">
    <div class="col-lg-2">
        <div class="card">
            <div class="card-block text-center">
                <a href="{{ route('backend.fee_create') }}"><button type="submit" class="btn btn-block btn-success p-2">Tạo mới</button></a>
            </div>
        </div>
    </div>
    <div class="col-lg-10">
        <div class="card">
            <div class="card-block">
                <form method="get" class="form-material">
                    <div class="row">
                        @php
                        $fee_list = "";
                        if($feeConfig){
                            $lastElement = $feeConfig->last();
                            foreach($feeConfig as $key => $detail){
                                $fee_list .= "<span class='attribute_cls'>".$detail->fee_name."</span>";
                                if($detail != $lastElement){
                                    $fee_list .= ", ";
                                }
                            }
                        }
                        @endphp
                        @if($feeConfig)
                            Shipping Fee =&nbsp;max({!! html_entity_decode($fee_list) !!})
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">STT</th>
                                    <th class="text-left">Fee Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feeConfig as $key => $detail) 
                                <tr>
                                    <td class="center_table text-center"><a href="{{route('backend.fee_detail', $detail->fee_id)}}">{{$detail->fee_name}}</a></td>
                                    <td class="center_table"><a href="{{route('backend.fee_detail', $detail->fee_id)}}">{{$detail->fee_name}}</a></td>
                                    <td class="text-center center_table">
                                        <button type="button" class="btn btn-outline-danger btn_remove" data-id="{{$detail->fee_id}}" ><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function(){
    
});
</script>
@endpush