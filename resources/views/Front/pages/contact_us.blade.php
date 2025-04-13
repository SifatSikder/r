@extends('Front.layouts.front')
@section('title', 'Privacy Policy')
@section('content')

    <div class="home-banner" style="background-image: url('{{asset('img/banners/2.jpg')}}')">
        <div class="container">
            <div class="home-banner-content banner-50">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content banner-50">
                            <div class="w-100">
                                <h1 class="title text-center">CONTACT US</h1>
                                <p class="slogan text-center">
                                    If you’d like to find out more about what we can offer and how we innovate,
                                    <br>
                                    please feel free to get in touch using the contact form below.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-100 py-5">
        <div class="container">
            <div class="w-100 py-5">
                <div class="w-100">
                    <div class="row">
                        <div class="col-lg-8 p-3">
                            <a id="contactForm"></a>
                            <div class="w-100 p-3 p-md-5 border h-100 bg-white shadow">
                                <h1 class="mb-5"><strong>Leave us a message</strong></h1>
                                <div class="w-100 mt-5">
                                    <form class="w-100 d-inline-block mt-5" method="post" action="{{route('front.contact.us.action')}}">
                                        {{csrf_field()}}

                                        @if($errors->has('success'))
                                            <p class="alert alert-success">{{$errors->first('success')}}</p>
                                        @endif
                                        <div class="row">
                                            <div class="mb-3 col-sm-6">
                                                <input type="text" name="name" placeholder="Your Name" required
                                                       class="form-control rounded-pill py-3 px-4">
                                            </div>
                                            <div class="mb-3 col-sm-6">
                                                <input type="text" name="email" placeholder="E-mail" required
                                                       class="form-control rounded-pill py-3 px-4">
                                            </div>
                                            <div class="mb-3 col-sm-12">
                                                <input type="text" name="subject" placeholder="Subject" required
                                                       class="form-control rounded-pill py-3 px-4">
                                            </div>
                                            <div class="mb-3 col-12">
                                        <textarea name="message" cols="30" rows="5" placeholder="Message" required
                                                  class="form-control p-3" style="border-radius: 20px"></textarea>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <button type="submit" class="w-100 btn btn-warning rounded-pill py-3 px-5">
                                                    <strong>Send Message</strong></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 p-3">
                            <div class="w-100 p-3 p-md-5 border h-100 bg-white shadow">
                                <div class="w-100 text-center">
                                    <h4 class="mb-5"><Strong>Digital Readiness and Intelligence Ltd</Strong></h4>
                                    <p class="mb-5">
                                        <i class="fa fa-fw fa-3x fa-map-marker text-danger"></i>
                                        <br>
                                        <strong>{{$contact['address']}}</strong>
                                    </p>
                                    <p class="mb-5">
                                        <i class="fa fa-fw fa-3x fa-envelope text-info"></i>
                                        <br>
                                        <a class="text-decoration-none text-info" href="mailto:{{$contact['email']}}"><strong>{{$contact['email']}}</strong></a>
                                    </p>
                                    <p class="mb-5">
                                        <i class="fa fa-fw fa-3x fa-link text-danger"></i>
                                        <br>
                                        <a class="text-decoration-none text-danger" href="{{$contact['website']}}">{{$contact['website']}}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
