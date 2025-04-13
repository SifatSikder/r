@extends('Front.layouts.front')
@section('title', 'Evaluation & Visualization')
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>

    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white py-5">

                <div class="w-100">
                    <div class="card border p-5" style="min-height: 80vh">
                        <form class="w-100" method="post" action="{{route('front.user.profile.update.action')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @if($errors->has('success'))
                                <p class="alert alert-success">{{$errors->first('success')}}</p>
                            @endif
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-end"></td>
                                    <td>
                                        <h4 class="w-100 mt-5">
                                            @if(auth()->user()->avatar == null)
                                                <img class="profile-avatar" src="{{asset('img/user.png')}}" alt="">
                                            @else
                                                <img class="profile-avatar" src="{{asset('storage/media/image/'.auth()->user()->avatar)}}" alt="">
                                            @endif
                                            <label for="changeProfileAvatar" class="cursor_pointer"><small class="badge bg-danger rounded-pill">Change Avatar</small></label>
                                            <input type="file" class="d-none" id="changeProfileAvatar" name="file">
                                        </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40%" class="text-end"><strong>First Name:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="text" class="form-control" value="{{ auth()->user()->first_name }}" name="first_name">
                                        @if($errors->has('first_name'))
                                            <small class="text-danger">{{$errors->first('first_name')}}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40%" class="text-end"><strong>Last Name:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="text" class="form-control" value="{{ auth()->user()->last_name }}" name="last_name">
                                        @if($errors->has('last_name'))
                                            <small class="text-danger">{{$errors->first('last_name')}}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end"><strong>Email Address:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="email" class="form-control" value="{{ auth()->user()->email }}" name="email">
                                        @if($errors->has('email'))
                                            <small class="text-danger">{{$errors->first('email')}}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end"><strong>Phone:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="tel" class="form-control" value="{{ auth()->user()->phone }}" name="phone">
                                        @if($errors->has('phone'))
                                            <small class="text-danger">{{$errors->first('phone')}}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end"><strong>Company:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="text" class="form-control" value="{{ auth()->user()->company }}" name="company">
                                        @if($errors->has('company'))
                                            <small class="text-danger">{{$errors->first('company')}}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end"><strong>Website:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="text" class="form-control" value="{{ auth()->user()->website }}" name="website">
                                        @if($errors->has('website'))
                                            <small class="text-danger">{{$errors->first('website')}}</small>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end"></td>
                                    <td>
                                        <button style="max-width: 250px" class="w-100 btn btn-sm btn-warning rounded-pill px-4">Update Profile</button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
