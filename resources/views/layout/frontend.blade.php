<!doctype html>
<html lang="en">
    <title>Amazon Shipping Service - GGG Test</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name=”robots” content=”noindex” />
        <meta http-equiv="content-language" content="en-us" />
        <meta name="description" content="Amazon Shipping Service - GGG Test">
        <!-- <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors"> -->

        <!-- Favicons -->
        <link rel="apple-touch-icon" href="{{ asset('icons/icon_180w.jpg') }}" sizes="180x180">
        <link rel="icon" href="{{ asset('icons/icon_32w.jpg') }}" sizes="32x32" type="image/png">
        <link rel="icon" href="{{ asset('icons/icon_16w.jpg') }}" sizes="16x16" type="image/png">
        <link rel="mask-icon" href="{{ asset('icons/icon_svg.svg') }}" color="#000000">
        <link rel="icon" href="{{ asset('icons/favicon.ico') }}">

        
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
        <link href="{{ asset('css/frontend-style.css') }}" rel="stylesheet">
        @stack('css')
    </head>
    <body class="bg-white">
        <div class="process_request hide">
            <div class="center_alert">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border text-light" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="col-12 mt-4 text-light">Processing....</div>
            </div>
        </div>
        
        @yield('content')
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://kit.fontawesome.com/6fd2cd9dff.js" crossorigin="anonymous"></script>
    @stack('script')
    <script src="{{ asset('js/frontend.js') }}"></script>
    <script>
    $(document).ready(function(){
        $('.btn_search').click(function(){
            search_product();
        });
        $('.input_search').keyup(function(e){
            if(e.keyCode == 13) {
                search_product();
            }
        });

        $('.btn_add_cart').click(function(){
            add_to_cart();
        });

        function add_to_cart(){
            let get_id = $('.btn_add_cart').attr('data-id');
            $('.error_mess').addClass('hide');
            $('.process_request').removeClass('hide');
            $.ajax({
                type: 'GET',
                url: '{{ url("add_cart") }}'+'/'+get_id,
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                dataType: 'json',
                success: function(result){
                    $('.process_request').addClass('hide');
                    // error show
                    if (result.status == false || result.status == 'false') {
                        $('.error_text').html(result.message);
                        $('.error_mess').removeClass('hide');
                    }
                    
                    // success Redirect  link to detail
                    if (result.status == true || result.status == 'true') {
                        window.location.href = '{{ url("/cart"); }}';
                    }
                    console.log('success');
                },
                error: function(result){
                    $('.process_request').addClass('hide');
                    $('.error_mess').removeClass('hide');
                    console.log(result);
                }
            });
        }

        function search_product(){
            $('.error_mess').addClass('hide');
            $('.process_request').removeClass('hide');
            $.ajax({
                type: 'POST',
                url: '{{ url("get_product") }}',
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                dataType: 'json',
                data: {
                    url_search: $('.input_search').val()
                },
                success: function(result){
                    $('.process_request').addClass('hide');
                    // error show
                    if (result.status == false || result.status == 'false') {
                        $('.error_text').html(result.message);
                        $('.error_mess').removeClass('hide');
                    }
                    
                    // success Redirect  link to detail
                    if (result.status == true || result.status == 'true') {
                        window.location.href = '{{ url("/detail"); }}'+'/'+result.id;
                    }
                    console.log('success');
                },
                error: function(result){
                    $('.process_request').addClass('hide');
                    $('.error_mess').removeClass('hide');
                    console.log(result);
                }
            });
        }
    });
    </script>
    </body>
</html>