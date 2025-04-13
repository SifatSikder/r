@extends('Front.layouts.front')
@section('title', 'Login')
@section('content')

    <div class="home-banner" style="background-image: url('{{asset('img/banners/1.jpg')}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-4 offset-lg-4">
                        <div class="text-content">
                            <div class="w-100">
                                <div class="card p-3 shadow">
                                    <div class="card-body">
                                        <form id="recaptchaForm" class="w-100 py-3" method="post" onsubmit="recaptchaAndSubmit(event)" action="{{route('front.login.action')}}">
                                            {{csrf_field()}}
                                            <div class="form-group mb-5 text-center">
                                                <h1><strong>Login</strong></h1>
                                            </div>
                                            @if($errors->has('success'))
                                                <p class="alert alert-success">{{$errors->first('success')}}</p>
                                            @endif
                                            @if($errors->has('error'))
                                                <p class="alert alert-danger">{{$errors->first('error')}}</p>
                                            @endif
                                            <div class="form-group mt-3 mb-3">
                                                <input type="email" class="form-control form-control-lg rounded-pill" name="email" placeholder="Email Address" value="{{old('email')}}">
                                                @if($errors->has('email')) <small class="text-danger">{{$errors->first('email')}}</small> @endif
                                            </div>
                                            <div class="form-group mb-3">
                                                <input type="password" autocomplete="new-password" name="password" class="form-control form-control-lg rounded-pill" placeholder="Password">
                                                @if($errors->has('password')) <small class="text-danger">{{$errors->first('password')}}</small> @endif
                                            </div>
                                            <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="1" name="remember" id="rememberMe">
                                                    <label class="form-check-label" for="rememberMe">
                                                        Remember Me
                                                    </label>
                                                </div>
                                                <a class="text-decoration-none text-secondary" href="{{route('front.forgot')}}"><strong>Forgot Password?</strong></a>
                                            </div>
                                            <div class="form-group mb-3 d-flex justify-content-between align-items-center">
                                                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-v3">
                                                <button class="w-100 btn btn-primary btn-lg rounded-pill m-0">Login Now</button>
                                            </div>
                                            <div class="form-group mb-3 text-center text-secondary">
                                                <strong>--- OR ---</strong>
                                                <br>
                                                <a class="text-secondary" href="{{route('front.register')}}"><strong>Create New Account</strong></a>
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
