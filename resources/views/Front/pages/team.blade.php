@extends('Front.layouts.front')
@section('title', 'Our Team')
@section('content')

    <div class="home-banner" style="background-image: url('{{$team['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100">
                                <div class="w-100">
                                    <h1 class="title text-center">{{$team['banner_title']}}</h1>
                                    <p class="slogan text-center">{{$team['banner_intro']}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="safety-forms">
        <div class="container">
            <div class="safety-forms-content transparent">

                <div class="w-100">
                    <div class="row">
                        @foreach($team['members'] as $member)
                        <div class="col-lg-6">
                            <div class="eachTeam card shadow mb-3">
                                <div class="card-body py-5 px-3">
                                    <div class="w-100 text-center mb-3">
                                        <img class="team_avatar border border-secondary" src="{{$member['avatar_full']}}" alt="">
                                    </div>
                                    <h3 class="text-center m-0 p-0"><strong>{{$member['name']}}</strong></h3>
                                    <h5 class="text-center m-0 p-0 text-secondary"><strong>{{$member['designation']}}</strong></h5>
                                    <p class="text-center m-0 p-0 mt-3">
                                        {!! nl2br($member['details']) !!}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>


@endsection
