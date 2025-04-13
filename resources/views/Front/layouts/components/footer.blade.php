{{--  Dynamic Contents  --}}
{{--  Social Links  --}}

@if(Route::currentRouteName() != 'front.evaluate')
    <!--Footer-Area-->
    <div class="w-100 footer">
        <div class="w-100 bg-dark pt-5">
            <div class="w-100 pt-5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-4 mb-5">
                            <div class="w-100 text-md-center">
                                <a class="navbar-brand" href="{{route('front.home')}}">
                                    <h3 class="text-light text-md-center"><strong>Rai<span class="text-danger">DOT</span></strong></h3>
                                </a>
                            </div>
                            <div class="w-100 py-3">
                                <div class="w-100 text-md-center mb-2">
                                    <a class="text-white text-decoration-none border-bottom py-2" href="mailto:{{$contact['email']}}">{{$contact['email']}}</a>
                                </div>
                                <div class="w-100 text-md-center mb-3">
                                    <a class="text-white text-decoration-none border-bottom py-2" href="{{$contact['website']}}">{{$contact['website']}}</a>
                                </div>
                                <div class="w-100 text-md-center text-white">
                                    {{$contact['address']}}
                                </div>
                            </div>
                            <div class="w-100 pt-3 text-md-center">
                                <a class="btn btn-outline-secondary rounded-pill px-2 py-2 me-2" href="{{$social['facebook']}}"><i class="fa fa-fw fa-facebook"></i></a>
                                <a class="btn btn-outline-secondary rounded-pill px-2 py-2 me-2" href="{{$social['linkedin']}}"><i class="fa fa-fw fa-linkedin"></i></a>
                                <a class="btn btn-outline-secondary rounded-pill px-2 py-2 me-2" href="{{$social['instagram']}}"><i class="fa fa-fw fa-instagram"></i></a>
                                <a class="btn btn-outline-secondary rounded-pill px-2 py-2" href="{{$social['twitter']}}"><i class="fa fa-fw fa-twitter"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-4 mb-5">
                            <h3 class="text-light text-md-center"><strong>Help & Support</strong></h3>
                            <div class="w-100 mt-5 text-md-center">
                                <p><a class="text-light text-decoration-none" href="{{route('front.pricing')}}">Pricing</a></p>
                                <p><a class="text-light text-decoration-none" href="{{route('front.contact.us')}}">Contact Us</a></p>
                                <p><a class="text-light text-decoration-none" href="{{route('front.privacy.policy')}}">Privacy Policy</a></p>
                                <p><a class="text-light text-decoration-none" href="{{route('front.cookie.policy')}}">Cookie Policy</a></p>
                                <p><a class="text-light text-decoration-none" href="{{route('front.terms.policy')}}">Terms & conditions</a></p>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <h3 class="text-light text-end text-md-center"><strong>Our Partners</strong></h3>
                            {{--                        <h3 class="text-light text-end text-md-center"><strong>DOWNLOAD MOT4AI TODAY</strong></h3>--}}
                            {{--                        <p class="mt-4 text-light text-end text-md-center">--}}
                            {{--                            <a href="{{$homepage['mobile_app_play_store']}}" class="d-inline-block me-2">--}}
                            {{--                                <img style="height: 50px" class="border border-light rounded" src="{{asset('img/widgets/play_store.png')}}">--}}
                            {{--                            </a>--}}
                            {{--                            <a href="{{$homepage['mobile_app_apple_store']}}" class="d-inline-block">--}}
                            {{--                                <img style="height: 50px" class="border border-light rounded" src="{{asset('img/widgets/app_store.png')}}">--}}
                            {{--                            </a>--}}
                            {{--                        </p>--}}

                            <div class="w-100 d-inline-block">
                                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="w-100">
                                                <p class="text-center mt-4">
                                                    <a href="{{$contact['website']}}"><img style="height: 55px" src="{{asset('img/footer/dr.png')}}" alt=""></a>
                                                </p>
                                                <p class="text-center mt-4 text-white">
                                                    <strong>D-Ready</strong>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="w-100">
                                                <p class="text-center mt-4">
                                                    <a href="{{$contact['website']}}"><img style="height: 55px" src="{{asset('img/footer/Teesside-University.png')}}" alt=""></a>
                                                </p>
                                                <p class="text-center mt-4 text-white">
                                                    <strong>Teesside University</strong>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="w-100">
                                                <p class="text-center mt-4">
                                                    <a href="{{$contact['website']}}"><img style="height: 55px" src="{{asset('img/footer/mediprospects.png')}}" alt=""></a>
                                                </p>
                                                <p class="text-center mt-4 text-white">
                                                    <strong>MediprospectsAI</strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="w-100 bg-dark p-3">
            <div class="container">
                <p class="text-end text-md-center text-secondary"><a class="text-secondary" href="{{route('front.home')}}"><strong>Rai<span class="text-danger">DOT</span></strong></a> &copy; {{date('Y')}}</p>
            </div>
        </div>
    </div>
    <!--Footer-Area/-->
@endif



<!--Cookie-Area-->
<div id="cookie-box" style="display: none">
    <div class="w-100">
        <small>
            We are using cookies to give you the best experience on our website. <br>
            You can find out more about which cookies we are using or switch them off in <a class="text-warning" href="{{route('front.cookie.policy')}}">cookie policy</a>.
        </small>
        <br><br>
        <a class="btn btn-sm btn-secondary rounded-pill me-2" onclick="declineCookie()">Close</a>
        <a class="btn btn-sm btn-warning rounded-pill" onclick="acceptCookie()">Accept</a>
    </div>
</div>
<!--Cookie-Area-->
<script>
    window.onload = function () {
        const cookieBox = document.getElementById('cookie-box');
        let cookie_mot4ai = null;
        let cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            let c = cookies[i].trim();
            if(c.includes('cookie_mot4ai')){
                cookie_mot4ai = c.replace('cookie_mot4ai=');
            }
        }
        if (cookie_mot4ai === null) {
            cookieBox.style.display = 'inline-block';
        }
    }

    function declineCookie() {
        const cookieBox = document.getElementById('cookie-box');
        cookieBox.style.display = 'none';

        let date = new Date();
        date.setTime(date.getTime() + (90 * 24 * 60 * 60 * 1000));
        let expires = "; expires=" + date.toUTCString();
        document.cookie = "cookie_mot4ai=0" + expires + "; path=/";
    }

    function acceptCookie() {
        const cookieBox = document.getElementById('cookie-box');
        cookieBox.style.display = 'none';

        let date = new Date();
        date.setTime(date.getTime() + (90 * 24 * 60 * 60 * 1000));
        let expires = "; expires=" + date.toUTCString();
        document.cookie = "cookie_mot4ai=1" + expires + "; path=/";

    }
</script>
