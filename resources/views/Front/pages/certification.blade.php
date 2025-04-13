@extends('Front.layouts.front')
@section('title', 'Certification')
@section('content')

    <div class="home-banner" style="background-image: url('{{$certification['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100">
                                <div class="w-100">
                                    <h1 class="title text-center">{{$certification['banner_title']}}</h1>
                                    <p class="slogan text-center">{{$certification['banner_intro']}}</p>
                                </div>
                                <div class="w-100 pt-5">
                                    <div class="w-100 text-center">
                                        <a data-bs-toggle="modal" data-bs-target="#basic_cert_modal" style="width: 250px"
                                           class="btn rounded-pill btn-primary py-3 me-md-3 shadow">
                                            <strong>Basic Certification</strong>
                                        </a>
                                        <a data-bs-toggle="modal" data-bs-target="#advance_cert_modal" style="width: 250px"
                                           class="btn rounded-pill btn-warning shadow py-3 mt-3 mt-sm-0">
                                            <strong>Advance Certification</strong>
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

    <div class="modal fade" id="basic_cert_modal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-3 p-lg-5">

                    <div class="w-100 mt-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="eachPrice bg-light shadow-lg py-3 py-lg-5 px-5 border border-5 border-success mb-4">
                                    <div class="w-100">
                                        <div class="plan">Basic <br> Evaluation </div>
                                        <div class="price text-secondary">Certificate</div>
                                    </div>
                                    <div class="w-100">
                                        <div class="features">
                                            <ul>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Start a New Risk Evaluation</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Answer Evaluation Questions</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Generate Risk Level</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Ask for mitigation strategies</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Resolve all mitigation strategies</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Make your system as No Risk</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Certify yourself</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Download Evaluation Certificate</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <a href="{{route('front.risk.evaluation', ['join-now'])}}" class="w-100 rounded-pill btn btn-outline-success">Start AI Risk Evaluation</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="eachPrice bg-light shadow-lg py-5 px-5 border border-5 border-primary">
                                    <div class="w-100">
                                        <div class="plan">Workshop <br> Participation </div>
                                        <div class="price text-secondary">Certificate</div>
                                    </div>
                                    <div class="w-100">
                                        <div class="features">
                                            <ul>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-primary"></i> Participate workshop programs</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-primary"></i> Train yourself</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-primary"></i> Collect Information</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-primary"></i> Request for your certificate</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-primary"></i> RaiDOT will send your certificate</li>
                                                <li class="text-start"><i class="fa fa-fw fa-check-circle text-primary"></i> Download Evaluation Certificate</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <a href="{{route('front.certification.workshops')}}" class="w-100 rounded-pill btn btn-outline-primary">Request Certificate</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="w-100 text-center mt-5">
                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="advance_cert_modal">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5">

                    <div class="w-100 mt-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card shadow mb-3">
                                    <div class="card-body px-2 py-5">
                                        <div class="w-100 text-center mb-3">
                                            <img style="height: 100px" src="{{asset('img/certificate/Badge-Raidot.png')}}" alt="">
                                        </div>
                                        <h5 class="text-center m-0 p-0"><strong>RaiDOT <br> Certification</strong></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card shadow mb-3">
                                    <div class="card-body px-2 py-5">
                                        <div class="w-100 text-center mb-3">
                                            <img style="height: 100px" src="{{asset('img/certificate/atc.png')}}" alt="">
                                        </div>
                                        <h5 class="text-center m-0 p-0"><strong>Advance Training <br> Courses Certification</strong></h5>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="w-100 text-center mt-3">
                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
