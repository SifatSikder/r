@extends('Front.layouts.front')
@section('title', 'Forgot Password')
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
                                              action="{{route('front.forgot.action')}}">
                                            {{csrf_field()}}
                                            <div class="form-group mb-5 text-center">
                                                <h1><strong>Forgot Password</strong></h1>
                                            </div>
                                            @if($errors->has('success'))
                                                <p class="alert alert-success">{{$errors->first('success')}}</p>
                                            @endif
                                            <div class="form-group mt-3 mb-3">
                                                <input type="email" class="form-control form-control-lg rounded-pill"
                                                       name="email" placeholder="Email Address"
                                                       value="{{old('email')}}">
                                                @if($errors->has('email'))
                                                    <small class="text-danger">{{$errors->first('email')}}</small>
                                                @endif
                                            </div>
                                            <div
                                                class="form-group mb-3 d-flex justify-content-between align-items-center">
                                                <button class="w-100 btn btn-lg btn-primary rounded-pill m-0">Send
                                                    Request
                                                </button>
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
