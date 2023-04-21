@if(session()->has('success'))
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
            <div class="text-success" role="alert">
                    <div class="alert-text">
                    @php
                        $successes = session()->get('success');   
                        $successes = is_array($successes) ? $successes : [$successes];
                    @endphp
                    @foreach ($successes as $success)
                        <li>{{ $success }}</li>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if ($errors->any())
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-block">
                <div class="text-danger" role="alert">
                    <div class="alert-text">
                        <strong>Có lỗi xảy ra</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

