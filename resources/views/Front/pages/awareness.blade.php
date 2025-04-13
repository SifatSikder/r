@extends('Front.layouts.front')
@section('title', 'Awareness')
@section('content')

    <div class="home-banner" style="background-image: url('{{$awareness['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100">
                                <h1 class="title text-center">{{$awareness['banner_title']}}</h1>
                                <p class="slogan text-center">{{$awareness['banner_intro']}}</p>
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
                    <iframe style="display: block;" width="100%" height="600" src="https://www.youtube.com/embed/{{\App\Helpers::parseYoutubeVideoId($awareness['video_preview'])}}?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>


                <div class="w-100 mt-5">
                    <div class="row">
                        @foreach($courses as $course)
                        <div class="col-lg-4">
                            <a href="" class="card shadow hover-opacity mb-3 text-decoration-none">
                                <div class="card-body px-2 py-5">
                                    <div class="w-100 text-center mb-3">
                                        <img src="{{$course['banner_full_path']}}" alt="">
                                    </div>
                                    <h4 class="text-center m-0 p-0 text-dark"><strong>{{$course['title']}}</strong></h4>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="w-100 d-inline-block ql-editor">
                    {!! nl2br($awareness['awareness_content']) !!}
                </div>

            </div>
        </div>
    </div>


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
