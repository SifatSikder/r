@extends('Front.layouts.front')
@section('title', 'Evaluation Tool')

@section('stylesheets')
    @vite('resources/css/multi-step-form.css')
@endsection
@section('content')

    <div class="home-banner" style="background-image: url('{{asset('img/banners/3.jpg')}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="text-content">
                            <div class="w-100">
                                <h1 class="title">Evaluation & Visualization</h1>
                                <p class="slogan">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                                <div class="d-inline-block d-sm-flex align-items-center mt-5">
                                    @if(auth()->check())
                                        <a href="{{route('front.register')}}"
                                           class="btn rounded-pill btn-warning py-3 px-5 me-3 shadow">
                                            <strong>Go to Dashboard</strong>
                                        </a>
                                    @else
                                        <a href="{{route('front.register')}}"
                                           class="btn rounded-pill btn-warning py-3 px-5 me-3 shadow">
                                            <strong>Create New Account</strong>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="multi_step_form">
        <form id="msform" class="py-3">
            <!-- Tittle -->
            <div class="tittle">
                <h1>Evaluation Process</h1>
                <p class="fs-4">Please complete the form below to help us understand your requirements.</p>
            </div>
            <hr>
            <!-- progressbar -->

            <!--
            <ul id="progressbar">
                <li class="active">Verify Phone</li>
                <li>Upload Documents</li>
                <li>Security Questions</li>
            </ul>
            -->
            <!-- fieldsets -->
            <fieldset id="fs-account-details">
                <div class="row">
                    <div class="offset-md-2 col-md-8 text-center">
                        <h3>Your Details</h3>
                        {{--                <h6>We will send you a SMS. Input the code to verify.</h6>--}}
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group offset-md-4 col-md-4 mb-2">
                        <input type="text" name="full_name" id="full_name" class="form-control form-control-lg" placeholder="Full Name">
                    </div>
                    <div class="form-group offset-md-4 col-md-4 mb-2">
                        <input type="text" name="email" id="email" class="form-control form-control-lg" placeholder="Company Email">
                    </div>
                    <div class="form-group offset-md-4 col-md-4 mb-2">
                        <input type="text" name="job_title" id="job_title" class="form-control form-control-lg" placeholder="Job Title">
                    </div>
                    <div class="form-group offset-md-4 col-md-4 mb-2">
                        <input type="text" name="phone_number" id="phone_number" class="form-control form-control-lg" placeholder="Phone Number">
                    </div>
                    <div class="form-group offset-md-4 col-md-4 mb-2">
                        <textarea name="expectation" id="expectation" cols="30" rows="5" placeholder="Your Expectation"
                        class="form-control form-control-lg"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <button type="button" class="next action-button btn btn-success btn-lg float-end"
                                data-fs="fs-is-using-ai">Continue</button>
                    </div>
                </div>
            </fieldset>

            <fieldset id="fs-is-using-ai">
                <div class="row">
                    <div class="offset-md-2 col-md-8 text-center">
                        <h3>Evaluation Questions</h3>
                        {{--                <h6>We will send you a SMS. Input the code to verify.</h6>--}}
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mb-2">
                        <label for="is-using-ai" class="form-label fs-4">Are you using any AI systems right now?</label>
                        <div class="form-check">
                            <input class="form-check-input radio-selection" type="radio" name="flexRadioDefault"
                                   id="use-ai-yes" data-fs="fs-using-ai-yes">
                            <label class="form-check-label" for="use-ai-yes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input radio-selection" type="radio" name="flexRadioDefault"
                                   id="use-ai-no" data-fs="fs-using-ai-no">
                            <label class="form-check-label" for="use-ai-no">
                                No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-md-4 col-md-2">
                        <button type="button" class="action-button previous previous_button btn btn-light btn-lg"
                                data-fs="fs-account-details">Back</button>
                    </div>
                </div>
            </fieldset>

            <fieldset id="fs-using-ai-no">
                <div class="row">
                    <div class="offset-md-2 col-md-8 text-center">
                        <h3>So, you are not using any AI systems right now-</h3>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mb-2">
                        <label for="is-using-ai" class="form-label fs-4">Are you planning to use AI?</label>
                        <div class="form-check">
                            <input class="form-check-input radio-selection" type="radio" name="flexRadioDefault" id="planning-ai-yes" data-fs="fs-planning-yes">
                            <label class="form-check-label" for="planning-ai-yes">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input radio-selection" type="radio" name="flexRadioDefault" id="planning-ai-no" data-fs="fs-planning-no">
                            <label class="form-check-label" for="planning-ai-no">
                                No
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-md-4 col-md-2">
                        <button type="button" class="action-button previous previous_button btn btn-light btn-lg"
                                data-fs="fs-is-using-ai">Back</button>
                    </div>
                </div>
            </fieldset>

            <fieldset id="fs-using-ai-yes">
                <div class="row">
                    <div class="offset-md-2 col-md-8 text-center">
                        <h3>You are using AI systems-</h3>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mb-2">
                        <label for="is-using-ai" class="form-label fs-4">Please select one sector to evaluate safety & risks from below-</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="sector-industry">
                            <label class="form-check-label" for="sector-industry">
                                Industry
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="sector-health">
                            <label class="form-check-label" for="sector-health">
                                Health
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="sector-engineering">
                            <label class="form-check-label" for="sector-engineering">
                                Engineering
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="sector-agriculture">
                            <label class="form-check-label" for="sector-agriculture">
                                Agriculture
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="sector-finance">
                            <label class="form-check-label" for="sector-finance">
                                Business & Finance
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="sector-education">
                            <label class="form-check-label" for="sector-education">
                                Education
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="sector-art">
                            <label class="form-check-label" for="sector-art">
                                Art
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-md-4 col-md-2">
                        <button type="button" class="action-button previous previous_button btn btn-light btn-lg"
                                data-fs="fs-is-using-ai">Back</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="next action-button btn btn-success btn-lg float-end">Continue</button>
                    </div>
                </div>
            </fieldset>

            <fieldset id="fs-planning-yes">
                <div class="row">
                    <div class="offset-md-2 col-md-8 text-center">
                        <h3>So, you are planning to use AI-</h3>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mb-2">
                        <label for="is-using-ai" class="form-label fs-4">Training/Video on which AI tools are suitable for you</label>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-md-4 col-md-2">
                        <button type="button" class="action-button previous previous_button btn btn-light btn-lg"
                                data-fs="fs-using-ai-no">Back</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="next action-button btn btn-success btn-lg float-end"
                                data-fs="fs-fin">Finish</button>
                    </div>
                </div>
            </fieldset>

            <fieldset id="fs-planning-no">
                <div class="row">
                    <div class="offset-md-2 col-md-8 text-center">
                        <h3>So, you are not even planning to use AI systems-</h3>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mb-2">
                        <label for="is-using-ai" class="form-label fs-4">Here are some benefit of using AI-</label>
                    </div>
                </div>

                <div class="row">
                    <div class="offset-md-4 col-md-2">
                        <button type="button" class="action-button previous previous_button btn btn-light btn-lg"
                                data-fs="fs-using-ai-no">Back</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="next action-button btn btn-success btn-lg float-end"
                                data-fs="fs-fin">Finish</button>
                    </div>
                </div>
            </fieldset>

            <fieldset id="fs-fin">
                <div class="row">
                    <div class="offset-md-4 col-md-2">
                        <button type="button" class="action-button previous previous_button btn btn-light btn-lg">Back</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="next action-button btn btn-success btn-lg float-end">Finish</button>
                    </div>
                </div>
            </fieldset>
<!--
            <fieldset id="fs-2">
                <h3>Verify Your Identity</h3>
                <h6>Please upload any of these documents to verify your Identity.</h6>
                <div class="passport">
                    <h4>Govt. ID card <br>PassPort <br>Driving License.</h4>
                    <a href="#" class="don_icon"><i class="ion-android-done"></i></a>
                </div>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="upload">
                        <label class="custom-file-label" for="upload"><i class="ion-android-cloud-outline"></i>Choose file</label>
                    </div>
                </div>
                <ul class="file_added">
                    <li>File Added:</li>
                    <li><a href="#"><i class="ion-paperclip"></i>national_id_card.png</a></li>
                    <li><a href="#"><i class="ion-paperclip"></i>national_id_card_back.png</a></li>
                </ul>
                <button type="button" class="action-button previous previous_button btn btn-light btn-lg">Back</button>
                <button type="button" class="next action-button btn btn-success btn-lg">Continue</button>
            </fieldset>
            <fieldset id="fs-3">
                <h3>Create Security Questions</h3>
                <h6>Please update your account with security questions</h6>
                <div class="form-group">
                    <select class="product_select">
                        <option data-display="1. Choose A Question">1. Choose A Question</option>
                        <option>2. Choose A Question</option>
                        <option>3. Choose A Question</option>
                    </select>
                </div>
                <div class="form-group fg_2">
                    <input type="text" class="form-control" placeholder="Anwser here:">
                </div>
                <div class="form-group">
                    <select class="product_select">
                        <option data-display="1. Choose A Question">1. Choose A Question</option>
                        <option>2. Choose A Question</option>
                        <option>3. Choose A Question</option>
                    </select>
                </div>
                <div class="form-group fg_3">
                    <input type="text" class="form-control" placeholder="Anwser here:">
                </div>
                <button type="button" class="action-button previous previous_button btn btn-light btn-lg">Back</button>
                <a href="#" class="action-button btn btn-success btn-lg">Finish</a>
            </fieldset>
            -->
        </form>
    </section>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.1.2/js/intlTelInput.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js'></script>
    @vite('resources/js/front/multi-step-form.js')
@endsection
