@extends('Front.layouts.front')
@section('title', 'Training')
@section('content')

    <div class="home-banner" style="background-image: url('{{$training['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100">
                                <h1 class="title text-center">{{$training['banner_title']}}</h1>
                                <p class="slogan text-center">{{$training['banner_intro']}}</p>
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
                    <iframe style="display: block;" width="100%" height="600" src="https://www.youtube.com/embed/{{\App\Helpers::parseYoutubeVideoId($training['video_preview'])}}?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>


                <div class="w-100 mt-5">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card shadow mb-3">
                                <div class="card-body px-2 py-5">
                                    <div class="w-100 text-center mb-3">
                                        <img src="{{asset('img/icons/abc_ai.png')}}" alt="">
                                    </div>
                                    <h4 class="text-center m-0 p-0"><strong>Fundamentals of AI</strong></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card shadow mb-3">
                                <div class="card-body px-2 py-5">
                                    <div class="w-100 text-center mb-3">
                                        <img src="{{asset('img/icons/risk.png')}}" alt="">
                                    </div>
                                    <h4 class="text-center m-0 p-0"><strong>Manage AI Risk</strong></h4>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card shadow mb-3">
                                <div class="card-body px-2 py-5">
                                    <div class="w-100 text-center mb-3">
                                        <img src="{{asset('img/icons/decision.png')}}" alt="">
                                    </div>
                                    <h4 class="text-center m-0 p-0"><strong>Fair Decision AI</strong></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="w-100 px-3" style="text-align: center;">
                    <br>
                    <br>
                    <br>
                    <p class="fw-bold fs-3 mb-0">Professional Training Program</p>
                    <p class="fw-bold fs-3 mb-0">Work-Integrated Project-Based Training</p>
                    <p class="fw-bold fs-3 mb-0">Professional Project Development Skills on</p>
                    <h1 class="fw-bold fs-1 h1 mb-3">AI-Powered Digital Transformation</h1>
                    <p class="fs-3 mb-0"><strong>Upcoming Session:</strong> Sept-Nov 2024</p>
                    <p class="fs-3 mb-0"><strong>Session in Progress:</strong> June-Aug 2024</p>
                    <p class="fs-3 mb-0"><strong>Duration:</strong> 7 weeks (14 contact hours + self-learning)</p>
                    <p class="fs-3 mb-0"><strong>Limited Seats For Each Program:</strong> Only 15 participants and 5 projects will be selected</p>
                    <p class="fs-3 mb-0"><strong>Course Leader:</strong></p>
                    <p class="fs-3 mb-0">Professor Alamgir Hossain</p>
                    <p class="fs-3 mb-0">CEO, Digital Readiness & Intelligence Ltd, Durham</p>
                    <p class="fs-3 mb-0">Former Professor of AI & Lead of Research Centres/Institutes in several UK universities</p>
                    <br>
                    <br>
                    <p class="fs-4 mb-5">For further information, please visit our website by clicking the button below:</p>

                    <a href="https://www.d-ready.co.uk/training" class="btn btn-lg rounded-pill btn-warning shadow py-3 px-5 mt-3 mt-sm-0">
                        Learn More and Join Training
                    </a>
                </div>

                

                <div class="w-100 d-inline-block ql-editor">
                    {!! nl2br($training['training_content']) !!}
                </div>

            </div>
        </div>
    </div>


    <!---Training Modal start--->
    <div class="modal fade" id="trainingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="trainingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <form class="w-100" action="{{route('front.training.attendees.action')}}" method="post">
                    {{csrf_field()}}
                    <div class="modal-header">
                        <h1 class="modal-title fs-4 text-center" id="trainingModalLabel">Are you interested in attending this training?</h1>
                    </div>
                    <div class="modal-body">
                        <div class="w-100 p-3">
                            <div class="form-group mb-3">
                                <label for="full-name" class="form-label ms-2">Full Name</label>
                                <input type="text" class="form-control form-control-lg rounded-pill" placeholder="Full Name"
                                       name="name" id="full-name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="email" class="form-label ms-2">Email Address</label>
                                <input type="text" class="form-control form-control-lg rounded-pill"
                                       placeholder="Email Address" name="email" id="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="phone" class="form-label ms-2">Phone Number</label>
                                <input type="number" class="form-control form-control-lg rounded-pill"
                                       placeholder="Phone Number" name="phone" id="phone" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary rounded-pill btn-lg" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success rounded-pill btn-lg px-4">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!---Training Modal end  --->

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if($errors->has('success'))
        <script>
            Swal.fire({
                title: "Thank You!",
                html: "<strong>Your submission has been sent to RaiDOT.</strong> <br> <strong>The Training Team will contact you very soon.</strong>",
                icon: "success",
                confirmButtonText: "Close"
            });
        </script>
    @endif
@endsection
