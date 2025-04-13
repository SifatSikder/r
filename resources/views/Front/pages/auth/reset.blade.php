@extends('Front.layouts.front')
@section('title', 'Reset Password')
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
                                        <form class="w-100 py-3" method="post"
                                              action="{{route('front.reset.action', [$reset_code])}}">
                                            {{csrf_field()}}
                                            <div class="form-group mb-5 text-center">
                                                <h1><strong>Forgot Password</strong></h1>
                                            </div>

{{--                                            <div class="col-lg-12">--}}
{{--                                                <div class="form-group mb-3">--}}
{{--                                                    <input type="password" autocomplete="new-password" class="form-control form-control-lg rounded-pill"--}}
{{--                                                           name="current_password" placeholder="Current Password *" required>--}}
{{--                                                    @if($errors->has('current_password')) <small class="text-danger">{{$errors->first('current_password')}}</small> @endif--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <hr>--}}

                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <input type="password" autocomplete="new-password" class="form-control form-control-lg rounded-pill"
                                                           name="password" placeholder="New Password *" required>
                                                    @if($errors->has('password')) <small class="text-danger">{{$errors->first('password')}}</small> @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group mb-3">
                                                    <input type="password" autocomplete="new-password" class="form-control form-control-lg rounded-pill"
                                                           name="password_confirmation" placeholder="Re-type New Password *" required>
                                                    @if($errors->has('password_confirmation')) <small class="text-danger">{{$errors->first('password_confirmation')}}</small> @endif
                                                </div>
                                            </div>

                                            <div
                                                class="form-group mb-3 d-flex justify-content-between align-items-center">
                                                <button class="w-100 btn btn-lg btn-primary rounded-pill m-0">Reset Password</button>
                                            </div>
                                            <div class="form-group mb-3 text-center text-secondary">
                                                <strong>Remember Password?</strong>
                                                <a class="text-secondary" href="{{route('front.login')}}"><strong>Login Now</strong></a>
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

@endsection
