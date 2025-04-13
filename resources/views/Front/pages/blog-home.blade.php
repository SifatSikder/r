@extends('Front.layouts.front')
@section('title', 'News')
@section('stylesheets')
@endsection
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>

    <div class="w-100 py-5">
        <div class="w-100 py-5">
            <div class="container">
                <div class="row">
                    @foreach($blog as $dt)
                        <div class="col-xl-3 col-lg-4 col-md-6" v-for="(dt, index) in blog">
                            <div class="eachBlog w-100 bg-white p-2 shadow mb-4">
                                <img src="{{ asset($dt->banner_full_path) }}" alt="">
                                <h5 class="py-2"><a href="{{ route('front.blog', ['id' => $dt->_id]) }}" class="text-secondary text-decoration-none"><strong>{{ $dt->title }}</strong></a></h5>
                                <p class="text-secondary">{{$dt->content}}</p>
                                <p class="m-0 p-0">
                                    <a class="btn btn-sm btn-primary py-1 rounded-pill" href="{{ route('front.blog', ['id' => $dt->_id]) }}">Read More</a>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
@endsection
