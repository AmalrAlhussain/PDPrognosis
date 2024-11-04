<div class="row text-center col-md-12  mt-5">
    @if(session('error'))
        <div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i> {{session('error')}}
{{--            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
        </div>
    @endif
    @if(session('success'))
        <div class="col-md-12 alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i> {{session('success')}}
{{--            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
        </div>
    @endif
    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="col-md-12 alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fa fa-exclamation-circle me-2"></i> {{$error}}
{{--                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>--}}
            </div>
        @endforeach
    @endif

</div>
