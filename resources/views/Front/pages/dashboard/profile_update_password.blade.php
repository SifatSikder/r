@extends('Front.layouts.front')
@section('title', 'Evaluation & Visualization')
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>

    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white py-5">

                <div class="w-100">
                    <div class="card border p-5" style="min-height: 80vh">
                        <form class="w-100" method="post" action="{{route('front.user.profile.update.password.action')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            @if($errors->has('success'))
                                <p class="alert alert-success">{{$errors->first('success')}}</p>
                            @endif
                            <table class="table table-borderless">
                                <tr>
                                    <td style="width: 40%" class="text-end"><strong>Current Password:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="password" class="form-control" name="current_password">
                                        @if($errors->has('current_password'))<small class="text-danger">{{$errors->first('current_password')}}</small>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40%" class="text-end"><strong>New Password:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="password" class="form-control" name="password">
                                        @if($errors->has('password'))<small class="text-danger">{{$errors->first('password')}}</small>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 40%" class="text-end"><strong>Re-type New Password:</strong></td>
                                    <td>
                                        <input style="max-width: 250px" type="password" class="form-control" name="password_confirmation">
                                        @if($errors->has('password_confirmation'))<small class="text-danger">{{$errors->first('password_confirmation')}}</small>@endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end"></td>
                                    <td>
                                        <button style="max-width: 250px" class="w-100 btn btn-sm btn-warning rounded-pill px-4">Update Password</button>
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
