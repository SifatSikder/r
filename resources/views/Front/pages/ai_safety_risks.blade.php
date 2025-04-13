@extends('Front.layouts.front')
@section('title', 'Safety & Assurance')
@section('stylesheets')
@endsection
@section('content')

    <div class="home-banner" style="background-image: url('{{$safety['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100">
                                <h1 class="title text-center">{{$safety['banner_title']}}</h1>
                                <p class="slogan text-center">{{$safety['banner_intro']}}</p>

                                <div class="w-100 pt-5">
                                    <div class="w-100 text-center">
                                        <a href="{{route('front.awareness')}}" style="width: 250px"
                                           class="btn rounded-pill btn-primary py-3 me-md-3 shadow">
                                            <strong>Awareness</strong>
                                        </a>
                                        <a href="{{route('front.training')}}" style="width: 250px"
                                           class="btn rounded-pill btn-primary py-3 me-md-3 shadow">
                                            <strong>Training</strong>
                                        </a>
                                        <a href="{{route('front.certification')}}" style="width: 250px"
                                           class="btn rounded-pill btn-warning shadow py-3 mt-3 mt-sm-0">
                                            <strong>Certification</strong>
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


    <div class="w-100 py-5 bg-white">
        <div class="container">
            <div class="w-100 py-5 d-inline-block">
                <h4 class="text-center">
                    {!! nl2br($safety['pre_risk']) !!}
                </h4>
            </div>
            <div class="w-100 py-5 d-inline-block">
                <h1 class="h1 mb-3 text-center"><strong>The Risks and Uncertainty of <br> Application of AI</strong></h1>
            </div>
            <div class="w-100 pb-5 d-inline-block">

                <div class="row">

                    <div class="col-lg-6 mb-4">
                        <div class="w-100 card shadow px-md-5 px-3 py-3" style="height: 450px">
                            <div class="py-5">
                                <h1 class="mb-3"><img style="width: 60px" src="{{asset('img/icons/software.png')}}" alt=""></h1>
                                <h2 class="mb-3"><strong>Software Risks</strong></h2>
                                <div class="mt-4 d-flex justify-content-center">
                                    <div class="w-100">
                                        <h5 class="mt-0 text-secondary">
                                            <ul>
                                                @foreach($safety['risk']['software'] as $soft)
                                                    <li>{{$soft}}</li>
                                                @endforeach
                                            </ul>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="w-100 card shadow px-md-5 px-3 py-3" style="height: 450px">
                            <div class="py-5">
                                <h1 class="mb-3"><img style="width: 60px" src="{{asset('img/icons/hardware.png')}}" alt=""></h1>
                                <h2 class="mb-3"><strong>Hardware Risks</strong></h2>
                                <div class="mt-4 d-flex justify-content-center">
                                    <div class="w-100">
                                        <h5 class="mt-0 text-secondary">
                                            <ul>
                                                @foreach($safety['risk']['hardware'] as $soft)
                                                    <li>{{$soft}}</li>
                                                @endforeach
                                            </ul>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="w-100 card shadow px-md-5 px-3 py-3" style="height: 450px">
                            <div class="py-5">
                                <h1 class="mb-3"><img style="width: 60px" src="{{asset('img/icons/ethical.png')}}" alt=""></h1>
                                <h2 class="mb-3"><strong>Ethical Issues</strong></h2>
                                <div class="mt-4 d-flex justify-content-center">
                                    <div class="w-100">
                                        <h5 class="mt-0 text-secondary">
                                            <ul>
                                                @foreach($safety['risk']['ethical'] as $soft)
                                                    <li>{{$soft}}</li>
                                                @endforeach
                                            </ul>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="w-100 card shadow px-md-5 px-3 py-3" style="height: 450px">
                            <div class="py-5">
                                <h1 class="mb-3"><img style="width: 60px" src="{{asset('img/icons/legal.png')}}" alt=""></h1>
                                <h2 class="mb-3"><strong>Legal Compliance</strong></h2>
                                <div class="mt-4 d-flex justify-content-center">
                                    <div class="w-100">
                                        <h5 class="mt-0 text-secondary">
                                            <ul>
                                                @foreach($safety['risk']['legal'] as $soft)
                                                    <li>{{$soft}}</li>
                                                @endforeach
                                            </ul>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            <div class="w-100 d-inline-block ql-editor">
                {!! nl2br($safety['mot_role']) !!}
            </div>
            <div class="w-100">
                <a href="{{route('front.risk.evaluation', ['join-now'])}}"
                   class="btn rounded-pill btn-warning shadow py-3 px-5 mt-3 mt-sm-0">
                    <strong>Start your AI Risk Evaluation</strong>
                </a>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
@endsection
