@extends('Front.layouts.front')
@section('title', 'Evaluation & Visualization')
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>


    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white py-5">

                <div class="w-100">
                    <div class="card border p-5" style="min-height: 80vh">
                        <h4 class="text-center mt-5">
                            @if(auth()->user()->avatar == null)
                                <img class="profile-avatar" src="{{asset('img/user.png')}}" alt="">
                            @else
                                <img class="profile-avatar" src="{{asset('storage/media/image/'.auth()->user()->avatar)}}" alt="">
                            @endif
                        </h4>
                        <table class="table table-borderless">
                            <tr>
                                <td style="width: 50%" class="text-end"><strong>Name:</strong></td>
                                <td>{{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"><strong>Email Address:</strong></td>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"><strong>Phone:</strong></td>
                                <td>{{ auth()->user()->phone }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"><strong>Company:</strong></td>
                                <td>{{ auth()->user()->company }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"><strong>Website:</strong></td>
                                <td>{{ auth()->user()->website }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"><a href="{{route('front.user.profile.update')}}" class="btn btn-sm btn-primary rounded-pill px-4">Update Profile</a></td>
                                <td><a href="{{route('front.user.profile.update.password')}}" class="btn btn-sm btn-warning rounded-pill px-4">Change Password</a></td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
