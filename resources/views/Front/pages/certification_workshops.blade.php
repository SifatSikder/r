@extends('Front.layouts.front')
@section('title', 'Certification')
@section('content')

    <div class="home-banner" style="background-image: url('{{$certification['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3">
                        <div class="text-content">
                            <div class="w-100 py-5">
                                <form action="{{route('front.certification.workshops.download')}}" method="post" class="w-100 py-5">
                                    {{csrf_field()}}
                                    <div class="eachPrice bg-light shadow-lg py-5 px-5 border border-5 border-primary">
                                        <div class="w-100">
                                            <div class="plan">Workshop Participation </div>
                                            <div class="price text-secondary">Certificate</div>
                                        </div>
                                        <div class="w-100 mt-5">
                                            @if($errors->has('success'))
                                                <div class="form-group mb-3">
                                                    <p class="alert alert-success"><strong>{{$errors->first('success')}}</strong></p>
                                                    @if($errors->has('file'))
                                                        <p class="alert alert-primary"><strong>You can also download your certificate from here: <a target="_blank" href="{{$errors->first('file')}}">Download</a></strong></p>
                                                    @endif
                                                </div>
                                            @endif
                                            @if($errors->has('warning'))
                                                <div class="form-group mb-3">
                                                    <p class="alert alert-warning"><strong>{{$errors->first('warning')}}</strong></p>
                                                    @if($errors->has('file'))
                                                        <p class="alert alert-primary"><strong>Download your certificate from here: <a target="_blank" href="{{$errors->first('file')}}">Download</a></strong></p>
                                                    @endif
                                                </div>
                                            @endif
                                            @if($errors->has('error'))
                                                <div class="form-group mb-3">
                                                    <p class="alert alert-danger"><strong>{{$errors->first('error')}}</strong></p>
                                                </div>
                                            @endif
                                            <div class="form-group mb-3">
                                                <label class="form-label text-secondary"><strong>Your Full Name</strong></label>
                                                <input type="text" class="form-control form-control-lg" name="full_name" placeholder="Your Full Name" value="{{old('full_name')}}" required>
                                                @if($errors->has('full_name'))<span class="text-danger">{{$errors->first('full_name')}}</span> @endif
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label text-secondary"><strong>Your Email Address</strong></label>
                                                <input type="email" class="form-control form-control-lg" name="email" placeholder="Your Email Address" value="{{old('email')}}" required>
                                                @if($errors->has('email'))<span class="text-danger">{{$errors->first('email')}}</span> @endif
                                            </div>
                                            <div class="form-group mb-3">
                                                <label class="form-label text-secondary"><strong>Workshop Code</strong></label>
                                                <input type="text" class="form-control form-control-lg" name="code" placeholder="Workshop Code" value="{{old('code')}}" required>
                                                @if($errors->has('code'))<span class="text-danger">{{$errors->first('code')}}</span> @endif
                                            </div>
                                            <div class="form-group text-end">
                                                <button type="submit" class="btn btn-lg btn-primary">Request Certificate</button>
                                            </div>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
