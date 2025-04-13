@extends('Front.layouts.front')
@section('title', 'Evaluation & Visualization')
@section('content')

    <div class="home-banner" style="background-image: url('{{$evaluation['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100">
                                <h1 class="title text-center">{{$evaluation['banner_title']}}</h1>
                                <p class="slogan text-center">{{$evaluation['banner_intro']}}</p>
                                <div class="w-100 text-center mt-5">
                                    <div class="w-100">
                                        <a href="{{route('front.risk.evaluation', ['join-now'])}}"
                                           class="btn rounded-pill btn-warning py-3 px-5 me-3 shadow">
                                            <strong>Start Your AI Risk Evaluation</strong>
                                        </a>
                                    </div>
                                    <div class="w-100 mt-3">
                                        <a href="{{route('front.bot.evaluation', ['demo-start'])}}"
                                           class="btn rounded-pill btn-info px-4 shadow">
                                            Demo Evaluation
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="safety-forms">
        <div class="container">
            <div class="safety-forms-content">
                <div class="w-100">
                    <iframe style="display: block;" width="100%" height="600" src="https://www.youtube.com/embed/{{\App\Helpers::parseYoutubeVideoId($evaluation['video_preview'])}}?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
                <div class="w-100">
                    <div class="w-100 d-inline-block ql-editor">
                        {!! nl2br($evaluation['top_content']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 py-5 bg-dark" style="margin-top: -12vh">
        <div class="container">
            <div class="w-100">
                <h2 class="text-center text-warning"><strong>Build your confidence in the use of Responsible AI</strong></h2>
                <div class="text-center mt-3">
                    <a class="btn btn-lg btn-danger px-5 py-3 rounded-pill" href="{{route('front.risk.evaluation', ['join-now'])}}"> <strong>Try Now</strong> </a>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 py-5">
        <div class="container">
            <div class="w-100">
                <div class="w-100 d-inline-block ql-editor">
                    {!! nl2br($evaluation['bottom_content']) !!}
                </div>
            </div>
            <div class="w-100">
                <a href="{{route('front.risk.evaluation', ['join-now'])}}"
                   class="btn btn-lg rounded-pill btn-warning shadow py-3 px-5 mt-3 mt-sm-0">
                    Start Your AI Risk Evaluation
                </a>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        localStorage.clear();
    </script>
@endsection
