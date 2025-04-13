@extends('Front.layouts.front')
@section('title', 'News')
@section('stylesheets')
@endsection
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>

    <div class="w-100 py-5">
        <div class="container">
            <div class="w-100 pt-5">
                <img class="img-fluid w-100" src="{{ asset($blog->banner_full_path) }}" alt="Banner"
                     style="object-fit: cover; height: 55vh;object-position: center center;">
            </div>

            <div class="card shadow rounded-0 rounded-bottom">
                <div class="card-body p-3 p-lg-5">
                    <div class="w-100">
                        <h1 class="m-0 py-3">{{ $blog->title }}</h1>
                    </div>
                    <div class="w-100 py-3">
                        {!! nl2br($blog->content) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
@endsection
