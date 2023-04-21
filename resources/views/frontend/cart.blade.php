@extends('layout.frontend')


@section('content')

@php
$total = 0;
@endphp

<div class="container pt-3 detail_content">
    @foreach(session('cart') as $item)
    @php
    $total += $item['item_price'];
    @endphp
    <div class="row products_cart mb-4">
        <div class="col-3 text-center">
            <div class="d-flex flex-column">
                <img src="http://via.placeholder.com/500x300" class="image_cart">
                <button type="button" class="btn btn-outline-primary mt-3 d-none d-sm-block">Remove</button>
            </div>
        </div>
        <div class="col-9 text-left">
            <div class="d-flex flex-column">
                <div class="product_info_cart pt-1">Product Name : <span id="product_name">{{$item['product_detail']->product_name}}</span></div>
                <div class="product_info_cart pt-1">Amazon Price : <span id="product_name">${{$item['product_detail']->product_price}}</span></div>
                <div class="product_info_cart pt-1">Shipping Price : <span id="product_name">${{$item['shipping_fee']}}</span></div>
                <div class="product_info_cart pt-1">item Price : <span id="product_name">${{$item['item_price']}}</span></div>
                <div class="product_info_cart pt-1">Quantity : <span id="product_name">1</span></div>
                @foreach($item['attribute'] as $detailAttribute) 
                    <div class="product_info_cart pt-1">{{ $listAttribute[$detailAttribute['pa_id']]['pa_text_show'] }} : <span id="product_name">{{ $detailAttribute['value'] }}</span></div>
                @endforeach
            </div>
        </div>
        <div class="col-12">
            <button type="button" class="col-12 btn btn-outline-primary d-sm-none mt-3 btn_remove" data-id="">Remove</button>
        </div>
    </div>
    @endforeach
</div>

<div class="bottom_fixed_cart">
    <div class="row px-4">
        <div class="mt-3 col-12 col-md-9">
            <div class="row">
                <div class="col-12">Total price : $<span id="total_price">{{$total}}</span></div>
            </div>
        </div>
        <div class="mt-3 col-12 col-md-3 px-2">
            <div class="row pe-2"><a href="{{route('index')}}"><button type="button" class="col-12 btn btn-outline-primary">Back to home</button></a></div>
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