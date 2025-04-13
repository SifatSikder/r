@extends('Front.layouts.front')
@section('title', 'Create Account')
@section('content')

    <div class="home-banner" style="background-image: url('{{asset('img/banners/1.jpg')}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-6 offset-lg-3">
                        <div class="text-content">
                            <div class="w-100">
                                <div class="card p-3 shadow">
                                    <div class="card-body">
                                        <form class="w-100 py-3" method="post" action="{{route('front.register.action')}}">
                                            {{csrf_field()}}
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group mb-5 text-center">
                                                        <h1 class="text-dark"><strong>Rai<span class="text-danger">DOT</span></strong></h1>
                                                        <h3 class="text-dark"><strong>Let's Create Your Account</strong></h3>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control form-control-lg rounded-pill"
                                                               name="first_name" placeholder="First Name *" required value="{{old('first_name')}}">
                                                        @if($errors->has('first_name')) <small class="text-danger">{{$errors->first('first_name')}}</small> @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control form-control-lg rounded-pill"
                                                               name="last_name" placeholder="Last Name *" required value="{{old('last_name')}}">
                                                        @if($errors->has('last_name')) <small class="text-danger">{{$errors->first('last_name')}}</small> @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <input type="email" class="form-control form-control-lg rounded-pill"
                                                               name="email" placeholder="Email Address *" required  value="{{old('email')}}">
                                                        @if($errors->has('email')) <small class="text-danger">{{$errors->first('email')}}</small> @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <input type="tel" class="form-control form-control-lg rounded-pill"
                                                               name="phone" placeholder="Phone" value="{{old('phone')}}">
                                                        @if($errors->has('phone')) <small class="text-danger">{{$errors->first('phone')}}</small> @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control form-control-lg rounded-pill"
                                                               name="company" placeholder="Company Name" value="{{old('company')}}">
                                                        @if($errors->has('company')) <small class="text-danger">{{$errors->first('company')}}</small> @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <input type="text" class="form-control form-control-lg rounded-pill"
                                                               name="website" placeholder="Website URL" value="{{old('website')}}">
                                                        @if($errors->has('website')) <small class="text-danger">{{$errors->first('website')}}</small> @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <input type="password" autocomplete="new-password" class="form-control form-control-lg rounded-pill"
                                                               name="password" placeholder="Password *" required>
                                                        @if($errors->has('password')) <small class="text-danger">{{$errors->first('password')}}</small> @endif
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group mb-3">
                                                        <input type="password" autocomplete="new-password" class="form-control form-control-lg rounded-pill"
                                                               name="password_confirmation" placeholder="Re-type Password *" required>
                                                        @if($errors->has('password_confirmation')) <small class="text-danger">{{$errors->first('password_confirmation')}}</small> @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-v3">
                                                <button class="w-100 btn btn-lg btn-primary rounded-pill m-0">Create Account</button>
                                            </div>
                                            <div class="form-group mb-3 text-center text-secondary">
                                                <strong>Already have an account?</strong>
                                                <a class="text-secondary" href="{{route('front.login')}}"><strong>Login Now</strong></a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <!-- Google Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js?render={{env('RECAPTCHA_SITE_KEY')}}"></script>
    <!-- Google Recaptcha -->

    <script>
        // Execute the following code when the window has finished loading
        window.onload = function () {
            // Use the reCAPTCHA API ready function
            grecaptcha.ready(function () {
                // Execute reCAPTCHA with the site key and the specified action 'submit'
                grecaptcha.execute('{{env('RECAPTCHA_SITE_KEY')}}', { action: 'submit' }).then(
                    function (token) {
                        // Log the obtained reCAPTCHA token to the console
                        console.log(token);

                        // Get the target element with the ID 'g-recaptcha-response-v3'
                        const target = document.getElementById('g-recaptcha-response-v3');

                        // Set the obtained token as the value of the target element
                        target.value = token;
                    }
                );
            });
        };
    </script>
@endsection
