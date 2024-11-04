<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDPROGNOSIS</title>
    <link rel="icon" href="/static/images/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('dash.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@stack('css')
</head>

<body>
<nav class="menu" tabindex="0">
    <div class="smartphone-menu-trigger"></div>
    <header class="avatar">
        <img src="{{ asset('images/logo.jpg') }}" alt="Profile Pic"/>
        @auth('admin')
        <p class="tests">Admin</p> <!-- Role is 'Admin', 'Doctor', or 'Patient' -->
        <h6 class="text-white">{{ auth('admin')->user()->username }}</h6>
        @endauth
        @auth('doctor')
            <p class="tests">Doctor</p> <!-- Role is 'Admin', 'Doctor', or 'Patient' -->
            <h6 class="text-white">{{ auth('doctor')->user()->username }}</h6>
        @endauth
        @auth('patient')
            <p class="tests">Patient</p> <!-- Role is 'Admin', 'Doctor', or 'Patient' -->
            <h6 class="text-white">{{ auth('patient')->user()->username }}</h6>
            <p class="text-white">Your Doctor : {{ auth('patient')->user()->doctor->fullname }}</p>
        @endauth
    </header>
    <ul>
        @auth('admin')
        <li class="icon-dashboard {{ request()->is('admin/dashboard') ? 'activee' : '' }}">
            <a href="{{ route('admin.dashboard') }}"><i class="fa faCustom fa-dashboard"></i><span>Dashboard</span></a>
        </li>
        <li class="icon-users {{ request()->is('admin/patient-requests') ? 'activee' : '' }}">
            <a href="{{ route('admin.patientRequests') }}"><i class="fa  faCustom fa-user"></i><span>Patient Requests</span></a>
        </li>
        <li class="icon-users {{ request()->is('admin/doctor-requests') ? 'activee' : '' }}">
            <a href="{{ route('admin.doctorRequests') }}"><i class="fa faCustom fa-user-md"></i><span>Doctor Requests</span></a>
        </li>
        <li class="icon-users {{ request()->is('admin/accepted-patients') ? 'activee' : '' }}">
            <a href="{{ route('admin.patients') }}"><i class="fa faCustom fa-users"></i><span>Patients</span></a>
        </li>
        <li class="icon-users {{ request()->is('admin/accepted-doctors') ? 'activee' : '' }}">
            <a href="{{ route('admin.doctors') }}"><i class="fa faCustom fa-user-md"></i><span>Doctors</span></a>
        </li>
        <li class="icon-users {{ request()->is('admin/visit*') ? 'activee' : '' }}">
            <a href="{{ route('admin.visits') }}"><i class="fa faCustom fa-calendar"></i><span>Visits</span></a>
        </li>
{{--        <li class="icon-users {{ request()->is('admin/surveys') ? 'activee' : '' }}">--}}
{{--            <a href="{{ route('admin.surveys') }}"><i class="fa faCustom fa-question-circle"></i><span>Survey</span></a>--}}
{{--        </li>--}}
        @endauth
            @auth('doctor')
                <li class="icon-dashboard {{ request()->is('doctor/dashboard') ? 'activee' : '' }}">
                    <a href="{{ route('doctor.dashboard') }}"><i class="fa faCustom fa-dashboard"></i><span>Dashboard</span></a>
                </li>
                <li class="icon-users {{ request()->is('doctor/my-patients*') ? 'activee' : '' }}">
                    <a href="{{ route('doctor.my-patients') }}"><i class="fa  faCustom fa-user"></i><span>My Patients</span></a>
                </li>
                <li class="icon-users {{ request()->is('doctor/visits*') ? 'activee' : '' }}">
                    <a href="{{ route('doctor.visits.index') }}"><i class="fa  faCustom fa-file"></i><span>My Visits</span></a>
                </li>
            @endauth
            @auth('patient')
                <li class="icon-dashboard {{ request()->is('patient/dashboard') ? 'activee' : '' }}">
                    <a href="{{ route('patient.dashboard') }}"><i class="fa faCustom fa-dashboard"></i><span>Dashboard</span></a>
                </li>
                <li class="icon-users {{ request()->is('patient/my-visits*') ? 'activee' : '' }}">
                    <a href="{{ route('patient.my-visits') }}"><i class="fa  faCustom fa-file"></i><span>My Visits</span></a>
                </li>
            @endauth
    </ul>

</nav>
<main>
    <div class="bs-example">
        <nav class="navbar navbar-expand-md  navbar-dark fixed-top" style="background:#337AB7;">
            <a href="/doctor-dashboard" class="navbar-brand">PDPROGNOSIS</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav" style=" margin-left: 77%;">
                    @auth('admin')
                    <a href="{{ route('admin.profile') }}" class="nav-item text-white nav-link">My Profile <i class="fa fa-user"></i></a>
                    <a href="javascript:void(0)" class="nav-item text-white nav-link" onclick="confirmLogout()">Logout <i class="fa fa-sign-out"></i></a>
                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    @endauth
                        @auth('doctor')
                            <a href="{{ route('doctor.profile') }}" class="nav-item text-white nav-link">My Profile <i class="fa fa-user"></i></a>
                            <a href="javascript:void(0)" class="nav-item text-white nav-link" onclick="confirmLogout()">Logout <i class="fa fa-sign-out"></i></a>
                            <form id="logout-form" action="{{ route('doctor.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endauth
                        @auth('patient')
                            <a href="{{ route('patient.profile') }}" class="nav-item text-white nav-link">My Profile <i class="fa fa-user"></i></a>
                            <a href="javascript:void(0)" class="nav-item text-white nav-link" onclick="confirmLogout()">Logout <i class="fa fa-sign-out"></i></a>
                            <form id="logout-form" action="{{ route('patient.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endauth
                </div>
            </div>
        </nav>
    </div>
        @include('notification_messages')

    @yield('content')
</main>
<!-- jQuery FIRST -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

@stack('js')
<script>
    $(document).ready(function () {
        $('.table').DataTable();
    });
    function confirmLogout() {
        if (confirm('Are you sure you want to logout?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>

</body>
</html>
