@php
    $pageName = request()->route() !=null ? request()->route()->getName() : '';
@endphp

    <!--Header-Area-->
<div class="header" id="header_box">
    <div class="container">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{route('front.home')}}">
                    Rai<span class="text-danger">DOT</span>
                </a>
                <button id="mobile_trigger" class="navbar-toggler shadow-none text-white" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa fa-fw fa-2x fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link @if($pageName == 'front.home') active @endif"
                               href="{{route('front.home')}}">Home</a>
                        </li>
                        @if(Route::currentRouteName() != 'front.evaluate')
                            <li class="nav-item position-relative">
                                <div class="dropdown d-block d-lg-flex justify-content-start align-items-center" id="hoverDropdown">
                                    <a href="{{route('front.ai.safety.risks')}}" class="nav-link @if($pageName == 'front.ai.safety.risks') active @endif">Education</a>
                                    <i id="drop_trigger" data-bs-toggle="dropdown" class="fa fa-fw fa-chevron-down cursor_pointer" style="position: absolute;right: 0;top: 13px;"></i>
                                    <ul class="dropdown-menu dropdown-menu-end p-3 shadow">
                                    <li><a class="dropdown-item px-3 py-2 rounded-pill text-center @if($pageName == 'front.awareness') active-item @endif" href="{{route('front.awareness')}}">Awareness</a></li>
                                        <li><a class="dropdown-item px-3 py-2 rounded-pill text-center @if($pageName == 'front.training') active-item @endif" href="{{route('front.training')}}">Professional Training</a></li>
                                        <li><a class="dropdown-item px-3 py-2 rounded-pill text-center @if($pageName == 'front.certification') active-item @endif" href="{{route('front.certification')}}">Certification</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($pageName == 'front.manage.ai.risk') active @endif"
                                   href="{{route('front.manage.ai.risk')}}">Manage AI Risk</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('front.fair.decision.analysis')}}">Fair Decision Analysis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($pageName == 'front.team') active @endif"
                                   href="{{route('front.team')}}">Team</a>
                            </li>
                        @endif
                        <li class="nav-item ms-xl-4">
                            @if(auth()->check())
                                <div class="dropdown d-block d-lg-flex justify-content-start align-items-center" id="userDropdown">
                                    <a class="btn btn-light border rounded-pill shadow-none px-3" data-bs-toggle="dropdown">{{auth()->user()->first_name}} <i class="fa fa-fw fa-chevron-down"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end p-3 shadow">
                                        <li><a class="dropdown-item px-3 py-2 rounded-pill text-center" href="{{route('front.portal')}}">Dashboard</a></li>
                                        <li class="dropdown-divider"></li>
                                        <li><a class="dropdown-item px-3 py-2 rounded-pill text-center" href="/portal/profile">Profile</a></li>
                                        {{--                                        <li><a class="dropdown-item px-3 py-2 rounded-pill text-center" href="{{route('front.user.profile.update')}}">Update Profile</a></li>--}}
                                        {{--                                        <li><a class="dropdown-item px-3 py-2 rounded-pill text-center" href="{{route('front.user.profile.update.password')}}">Change Password</a></li>--}}
                                        {{--                                        <li class="dropdown-divider"></li>--}}
                                        <li><a class="btn btn-warning w-100 rounded-pill mt-2" href="{{route('front.logout')}}">Logout</a></li>
                                    </ul>
                                </div>
                            @else
                                <a class="btn btn-light rounded-pill shadow-none px-3" href="{{route('front.login')}}">Login / Register</a>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>
<!--Header-Area/-->


<script type="application/javascript">
    window.onscroll = function () {
        const header_box = document.getElementById('header_box');
        const mobile_trigger = document.getElementById('mobile_trigger');
        const drop_trigger = document.getElementById('drop_trigger');
        if (window.pageYOffset > 50) {
            header_box.classList = 'header header_fixed shadow';
            mobile_trigger.classList = 'navbar-toggler shadow-none text-dark';
            drop_trigger.classList = 'fa fa-fw fa-chevron-down cursor_pointer text-dark';
        } else {
            header_box.classList = 'header';
            mobile_trigger.classList = 'navbar-toggler shadow-none text-white';
            drop_trigger.classList = 'fa fa-fw fa-chevron-down cursor_pointer';
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $('#hoverDropdown, #userDropdown').hover(
        function() {
            $(this).addClass('show').find('.dropdown-menu').addClass('show');
        }, 
        function() {
            $(this).removeClass('show').find('.dropdown-menu').removeClass('show');
        }
    );
});
</script>

<style>
.dropdown-menu {
    top: 40px !important;
    transition: opacity 0.3s ease; 
}
.active-item {
    background-color: #007bff; 
    color: white; 
}
</style>
