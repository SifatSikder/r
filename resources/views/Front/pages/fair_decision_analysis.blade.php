@extends('Front.layouts.front')
@section('title', 'Evaluation & Visualization')
@section('content')

    <div class="home-banner" style="background-image: url('{{$fair_decision['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100">
                                <h1 class="title text-center">{{$fair_decision['banner_title']}}</h1>
                                <p class="slogan text-center">{{$fair_decision['banner_intro']}}</p>
                                <div class="w-100 text-center mt-5">
                                    <div class="w-100">
                                        <a href="{{route('front.risk.evaluation', ['join-fair-analysis'])}}"
                                           class="btn rounded-pill btn-warning py-3 px-5 me-3 shadow">
                                            <strong>Start Your Fair Decision Analysis</strong>
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
                <div class="w-100 px-5 shadow">
                    <div class="w-100 d-inline-block ql-editor">
                        {!! nl2br($fair_decision['content']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        localStorage.clear();
    </script>
@endsection
