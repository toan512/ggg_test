@extends('layout.frontend')


@section('content')

<div class="container pt-3">
    <div class="row text-center">
        <div class="col-12"><img class="frontend_logo" src="{{ asset('assets/images/ggg_logo.png') }}" alt=""></div>
        <div class="col-12 fs-3 fw-bold mt-2">Amazon Shipping Service</div>
        <div class="col-12 fs-6 mt-2 fw-light text-secondary-emphasis">Only support Amazon US (amazon.com)</div>
        <div class="col-12 mt-4">
            <div class="input-group">
                <input type="text" class="form-control input_search" placeholder="Example : https://www.amazon.com/gp/product/B098RL6SBJ">
            </div>
        </div>
    </div>
    <div class="row text-center mt-4">
        <div class="col-8">
            <button type="button" class="col-12 btn btn-outline-primary btn_search">Search</button>
        </div>
        <div class="col-4">
            <a href="{{route('cart')}}"><button type="button" class="col-12 btn btn-outline-primary">Cart</button></a>
        </div>
    </div>
    <div class="row text-center mt-4">
        <div class="col-12">
            <a href="{{route('backend.fee_manager')}}"><button type="button" class="col-12 btn btn-outline-primary">Backend</button></a>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-4 error_mess text-danger text-center hide">
        <div class="col-12 error_text ">Not found product via url, please check link again or contact with administrator via email : support@ggg_check.com</div>
    </div>
</div>

@endsection

@push('script')
<script>
    $(document).ready(function(){
        
    });
</script>
@endpush