@extends('layout.frontend')


@section('content')

<div class="container pt-3 detail_content">
    <div class="row mb-4">
         <div class="col-xs-12 col-md-6 text-center">
            <img src="http://via.placeholder.com/1000x600" class="image_detail">
        </div>
        <div class="col-xs-12 col-md-6 text-left">
            <div class="d-flex flex-column">
                <div class="product_info pt-1">Product Name : <span id="product_name" class="fw-bold">{{ $product['product_name'] }}</span></div>
                <div class="product_info pt-1">Amazon Price : $<span id="product_price">{{ $product['product_price'] }}</span></div>
                <div class="product_info pt-1">Shipping fee : $<span id="">{{ $shipping_fee }}</span></div>
                <div class="product_info pt-1">item Price : $<span id="">{{ $item_price }}</span></div>
                <!-- <div class="product_info pt-1">Quantity : <span id="product_quantity">1</span></div> -->
                @foreach($product_attribute as $detailAttribute) 
                    <div class="product_info pt-1">{{ $listAttribute[$detailAttribute['pa_id']]['pa_text_show'] }} : <span id="product_name">{{ $detailAttribute['value'] }}</span></div>
                @endforeach
                <!-- <div class="product_info pt-1">Weight : <span id="product_name">3.9</span> pounds</div>
                <div class="product_info pt-1">Product Dimensions : <span id="product_name">33x24x42</span></div> -->
                <button type="button" class="col-12 btn btn-outline-primary mt-3 btn_add_cart" data-id="{{ $product['p_id'] }}" >Add Cart</button>
            </div>
        </div>
    </div>
</div>

<div class="bottom_fixed">
    <div class="row px-4">
        <div class="mt-3 col-12 col-md-3 offset-md-9">
            <a href="{{route('index')}}"><button type="button" class="col-12 btn btn-outline-primary">Back to home</button></a>
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