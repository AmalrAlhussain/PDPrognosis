<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>PDPROGNOSIS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="icon" href='{{asset('images/logo.jpg')}}'>
    <link rel="stylesheet" href="{{asset('style.css')}}">
@stack('css')
</head>

<body>
<div class="bs-example">
    <nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background:#337AB7;">
        <a href="/" class="navbar-brand">PDPROGNOSIS</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="{{route('admin.start')}}" class="nav-item nav-link">Admin</a>
                <a href="{{route('doctor.start')}}" class="nav-item nav-link">Doctor</a>
                <a href="{{route('patient.start')}}" class="nav-item nav-link">Patient</a>
            </div>
            <div class="navbar-nav">
                <a href="/aboutus" class="nav-item nav-link">About Us</a>
                <a href="/contactus" class="nav-item nav-link">Contact Us</a>
            </div>
        </div>
    </nav>
</div>

@yield('content')

<footer>
    <p>
        <a href="https://facebook.com/" class="fa fa-facebook"></a>
        <a href="https://whatsapp.com/" class="fa fa-whatsapp"></a>
        <a href="https://instagram.com/" class="fa fa-instagram"></a>
        <a href="https://twitter.com/" class="fa fa-twitter"></a>
    </p>
</footer>
</body>

</html>
