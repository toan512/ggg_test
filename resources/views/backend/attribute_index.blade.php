@extends('layout.backend')

@push('css')
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert/sweetalert.css') }}">
@endpush

@section('title', 'Manager Fee')

@section('content')

<style>
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block text-center">
                <a href="{{ route('backend.attribute_create') }}"><button type="submit" class="btn btn-block btn-success p-2">Tạo mới</button></a>
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
                                    <th class="text-center">Attribute Name</th>
                                    <th class="text-center">Attribute Text</th>
                                    <th class="text-center">Regular Expression</th>
                                    <th class="text-center">Regular Expression Index</th>
                                    <th class="text-center">Value type</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productattribute as $key => $detail) 
                                <tr>
                                    <td class="text-center"><a href="{{route('backend.attribute_detail', $detail->pa_id)}}">{{$detail->pa_name}}</a></td>
                                    <td class="text-center"><a href="{{route('backend.attribute_detail', $detail->pa_id)}}">{{$detail->pa_text_show}}</a></td>
                                    <td class="text-center"><a href="{{route('backend.attribute_detail', $detail->pa_id)}}">{{$detail->regular_exp}}</a></td>
                                    <td class="text-center"><a href="{{route('backend.attribute_detail', $detail->pa_id)}}">{{$detail->regular_exp_index}}</a></td>
                                    <td class="text-center"><a href="{{route('backend.attribute_detail', $detail->pa_id)}}">
                                        @if($detail->pa_type == 'text')
                                            Text
                                        @else
                                            Number
                                        @endif
                                    </a></td>
                                    <td class="text-center text-center">
                                        @if($detail->pa_lock == 0)
                                        <button type="button" class="btn btn-outline-danger btn_remove" data-id="{{$detail->pa_id}}" ><i class="fa fa-trash"></i></button>
                                        @endif
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
<script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.btn_remove').click(function(){
        let data_id = $(this).attr('data-id');
        swal({
            title: "Có chắc muốn xóa không ?!",
            text: "việc xóa thuộc tính của sản phẩm có thể ảnh hưởng đến cấu hình giá phí, viết nút 'DELETE' để xóa",
            type: "input",
            confirmButtonColor: "#DD6B55",
            showCancelButton: true,
            closeOnConfirm: false,
            allowEscapeKey: true,
            allowOutsideClick: true,
            animation: "slide-from-top",
            inputPlaceholder: "DELETE"
        },
        function(inputValue){
            if( inputValue != null && inputValue != '' && inputValue.toUpperCase() === 'DELETE'){
                window.location.replace('attribute/'+data_id+"/remove");
                swal("Thành công!", "Bạn đã xóa");
                return false;
            }
            swal({
                title: "Cancelled",
                type: "error",
                text: "Dữ liệu đã an toàn, lần sau cẩn thận hơn nhé! :)",   
                timer: 2000,   
                showConfirmButton: false 
            });
            return false;
        });
    });
    });
</script>
@endpush