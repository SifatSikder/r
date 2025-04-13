@extends('Front.layouts.front')
@section('title', 'Multi-scale Operation-assurance evaluation Tool for AI Systems')
@section('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')

    <div class="home-banner" style="background-image: url('{{$homepage['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100 h-100 d-flex flex-column justify-content-between">
                                <div class="w-100">
                                    &nbsp;&nbsp;
                                </div>
                                <div class="w-100 pt-5">
                                    <div class="row pt-5">
                                        <div class="col-xl-12">
                                            <h1 class="w-100 title d-inline-block text-center"><strong>{{$homepage['banner_title']}}</strong></h1>
                                            <p class="w-100 banner_desc d-inline-block text-center">{{$homepage['banner_intro']}}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-100 pt-5">
                                    <div class="w-100 text-center">
                                        <a href="{{route('front.ai.safety.risks')}}" style="width: 250px"
                                           class="btn rounded-pill btn-primary py-3 me-md-3 shadow">
                                            <strong>Education</strong>
                                        </a>
                                        <a href="{{route('front.manage.ai.risk')}}" style="width: 250px"
                                           class="btn rounded-pill btn-warning shadow py-3 mt-3 mt-sm-0">
                                            <strong>Manage AI Risks</strong>
                                        </a>
                                    </div>
                                </div>
                                <div class="w-100 pb-5">
                                    <div class="w-100 mt-5">
                                        <p class="w-100 slogan d-inline-block text-center mt-5">{{$homepage['banner_description']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 border-bottom border-top pb-5">
        <div class="w-100">

            <div class="container pt-5 px-3">
                <div class="py-5">
                    <div class="h1 mb-3" style="text-align: center;"><strong>Welcome to RaiDOT</strong></div>
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            <h5 class="mt-0 text-secondary">
                                {!! nl2br($homepage['about_us']) !!}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
                <div class="container pt-5 px-3">
                    <img style="width:100%" src="{{asset('img/banners/RaiDOT-Structure.png')}}" class="mb-3" alt="lock">
                </div>
            <div class="container pb-5 px-3">
                <div class="py-5">
                    <div class="h1 mb-3" style="text-align: center;"><strong>Our Mission</strong></div>
                    <div class="d-flex justify-content-center">
                        <div class="w-100">
                            <h5 class="mt-0 text-secondary">
                                {!! nl2br($homepage['our_mission']) !!}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="w-100 py-5 bg-dark">
        <div class="container">
            <div class="w-100">
                <h2 class="text-center text-warning"><strong>Don't leave risks unchecked – navigate the future confidently with RaiDOT!</strong></h2>
                <div class="text-center mt-5">
                    <a class="btn btn-lg btn-outline-warning px-5 py-3 rounded-pill" href="{{route('front.manage.ai.risk')}}"> <strong>Try Now</strong> </a>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 d-inline-block py-5 border-bottom bg-light" id="how-it-works">
        <div class="w-100 d-inline-block py-5 mt-5">
            <div class="container text-dark px-3">
                <div class="h1 mb-4 text-center"><strong>{!! nl2br($homepage['about_project_title']) !!}</strong></div>
                <div class="d-flex justify-content-center">
                    <div class="w-100">
                        <h5 class="mt-0 text-secondary text-center">
                            {!! nl2br($homepage['about_project']) !!}
                        </h5>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="w-100 mt-5 how-it-works-circle-parent">
                    <div class="row">
                        <div class="col-lg-4 ">
                            <div class="w-100 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 px-3">
                                        <div class="about-box-opposite d-flex align-items-center bg-white border mb-4 shadow" style="height: 400px">
                                            <div class="w-100 text-center">
                                                <img src="{{asset('img/icons/why/0.png')}}" class="mb-3" alt="lock">
                                                <div class="h4 mb-3">
                                                    <strong>{{$homepage['about_project_details'][0]['title']}}</strong>
                                                </div>
                                                <div class="text-secondary px-3">
                                                    {!! nl2br($homepage['about_project_details'][0]['details']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="w-100 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 px-3">
                                        <div class="about-box-opposite d-flex align-items-center bg-white border mb-4 shadow" style="height: 400px">
                                            <div class="w-100 text-center">
                                                <img src="{{asset('img/icons/why/1.png')}}" class="mb-3" alt="lock">
                                                <div class="h4 mb-3">
                                                    <strong>{{$homepage['about_project_details'][1]['title']}}</strong>
                                                </div>
                                                <div class="text-secondary px-3">
                                                    {!! nl2br($homepage['about_project_details'][1]['details']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="w-100 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 px-3">
                                        <div class="about-box-opposite d-flex align-items-center bg-white border mb-4 shadow" style="height: 400px">
                                            <div class="w-100 text-center">
                                                <img src="{{asset('img/icons/why/2.png')}}" class="mb-3" alt="lock">
                                                <div class="h4 mb-3">
                                                    <strong>{{$homepage['about_project_details'][2]['title']}}</strong>
                                                </div>
                                                <div class="text-secondary px-3">
                                                    {!! nl2br($homepage['about_project_details'][2]['details']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="w-100 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 px-3">
                                        <div class="about-box-opposite d-flex align-items-center bg-white border mb-4 shadow" style="height: 400px">
                                            <div class="w-100 text-center">
                                                <img src="{{asset('img/icons/why/3.png')}}" class="mb-3" alt="lock">
                                                <div class="h4 mb-3">
                                                    <strong>{{$homepage['about_project_details'][3]['title']}}</strong>
                                                </div>
                                                <div class="text-secondary px-3">
                                                    {!! nl2br($homepage['about_project_details'][3]['details']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 px-3 d-flex justify-content-center align-items-center">
                            <div class="how-it-works-circle shadow-lg"
                                 style="background-image: url('{{asset('img/banners/home-about.jpg')}}')"></div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="w-100 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 px-3">
                                        <div class="about-box-opposite d-flex align-items-center bg-white border mb-4 shadow" style="height: 400px">
                                            <div class="w-100 text-center">
                                                <img src="{{asset('img/icons/why/4.png')}}" class="mb-3" alt="lock">
                                                <div class="h4 mb-3">
                                                    <strong>{{$homepage['about_project_details'][4]['title']}}</strong>
                                                </div>
                                                <div class="text-secondary px-3">
                                                    {!! nl2br($homepage['about_project_details'][4]['details']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 px-3">
                                        <div class="about-box-opposite d-flex align-items-center bg-white border mb-4 shadow" style="height: 400px">
                                            <div class="w-100 text-center">
                                                <img src="{{asset('img/icons/why/5.png')}}" class="mb-3" alt="lock">
                                                <div class="h4 mb-3">
                                                    <strong>{{$homepage['about_project_details'][5]['title']}}</strong>
                                                </div>
                                                <div class="text-secondary px-3">
                                                    {!! nl2br($homepage['about_project_details'][5]['details']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="w-100 mt-4">
                                <div class="row">
                                    <div class="col-lg-12 px-3">
                                        <div class="about-box-opposite d-flex align-items-center bg-white border mb-4 shadow" style="height: 400px">
                                            <div class="w-100 text-center">
                                                <img src="{{asset('img/icons/why/6.png')}}" class="mb-3" alt="lock">
                                                <div class="h4 mb-3">
                                                    <strong>{{$homepage['about_project_details'][6]['title']}}</strong>
                                                </div>
                                                <div class="text-secondary px-3">
                                                    {!! nl2br($homepage['about_project_details'][6]['details']) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100">
        <iframe style="display: block;" width="100%" height="600" src="https://www.youtube.com/embed/{{\App\Helpers::parseYoutubeVideoId($homepage['homepage_video_preview'])}}?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    </div>

    {{--@include('Front.layouts.components.contact')--}}
    @include('Front.layouts.components.news')

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 4500,
                responsive: {
                    0:{
                        items: 1
                    },
                    600:{
                        items: 2
                    },
                    1000:{
                        items: 3
                    },
                    1300:{
                        items: 4
                    },
                    2000:{
                        items: 6
                    },
                },
                nav: false,
                rewind: true,
                margin: 10,
                lazyLoad: true,
            });
        });
    </script>
@endsection
