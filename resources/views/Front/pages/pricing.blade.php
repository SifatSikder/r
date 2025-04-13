@extends('Front.layouts.front')
@section('title', 'Pricing')
@section('content')

    <div class="home-banner" style="background-image: url('{{$training['banner_full']}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100 py-5">
                                <div class="w-100 py-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="eachPrice bg-light shadow-lg py-5 px-5 border border-5 border-white mb-4">
                                                <div class="w-100">
                                                    <div class="plan">Free</div>
                                                    <div class="price text-secondary">£0 <small> / Month</small></div>
                                                </div>
                                                <div class="w-100">
                                                    <div class="short_details">


                                                    </div>
                                                </div>
                                                <div class="w-100">
                                                    <div class="features">
                                                        <ul>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Limited access to risk assessment tools.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Access to basic AI training materials.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-times-circle text-danger"></i> Full access to risk assessment tools.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-times-circle text-danger"></i> Advanced AI training and certification.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-times-circle text-danger"></i> Access to AI user support.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-times-circle text-danger"></i> Priority email support.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-times-circle text-danger"></i> Explainable AI.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-times-circle text-danger"></i> Mitigation Strategies.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="w-100">
                                                    @if($user === null)
                                                        <a href="{{route('front.subscribe.make', ['free'])}}" class="w-100 rounded-pill btn btn-lg btn-outline-success">Choose Plan</a>
                                                    @elseif($user->subscription == null)
                                                        <div class="active_status">Current Plan</div>
                                                        <a class="w-100 btn btn-lg pointer-event-none" style="opacity: 0">Current Plan</a>
                                                    @else
                                                        <a class="w-100 btn btn-lg pointer-event-none" style="opacity: 0">Not Available</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="eachPrice bg-light shadow-lg py-5 px-5 border border-5 border-success mb-4">
                                                <div class="w-100">
                                                    <div class="plan">Premium</div>
                                                    <div class="price text-secondary">£29 <small> / Month</small></div>
                                                </div>
                                                <div class="w-100">
                                                    <div class="features">
                                                        <ul>
                                                            {{--                                        <li class="text-start"><i class="fa fa-fw fa-check-circle text-danger"></i> Limited access to risk assessment tools.</li>--}}
                                                            {{--                                        <li class="text-start"><i class="fa fa-fw fa-check-circle text-danger"></i> Access to basic AI training materials.</li>--}}
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Full access to risk assessment tools.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Advanced AI training and certification.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Access to AI user support.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Priority email support.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Explainable AI.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Mitigation Strategies.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="w-100">
                                                    @if($user === null)
                                                        <a href="{{route('front.subscribe.make', ['premium'])}}" class="w-100 rounded-pill btn btn-lg btn-outline-success">Choose Plan</a>
                                                    @elseif($user->subscription == null)
                                                        <a href="{{route('front.subscribe.make', ['premium'])}}" class="w-100 rounded-pill btn btn-lg btn-outline-success">Choose Plan</a>
                                                    @elseif($user->subscription != null && $user->subscription['status'] == 'active')
                                                        <div class="active_status">Current Plan</div>
                                                        <a href="{{route('front.subscribe.make', ['cancel'])}}" class="w-100 rounded-pill btn btn-lg btn-outline-danger">Cancel Plan</a>
                                                    @elseif($user->subscription != null && $user->subscription['status'] == 'canceled')
                                                        <div class="active_status canceled_status">Canceled</div>
                                                        <a href="{{route('front.subscribe.make', ['premium'])}}" class="w-100 rounded-pill btn btn-lg btn-outline-success">Reactivate Plan</a>
                                                    @else
                                                        <a href="{{route('front.subscribe.make', ['premium'])}}" class="w-100 rounded-pill btn btn-lg btn-outline-success">Choose Plan</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="eachPrice bg-light shadow-lg py-5 px-5 border border-5 border-secondary mb-4">
                                                <div class="w-100">
                                                    <div class="plan">Enterprise</div>
                                                    <div class="price"><small> / Custom Plan</small></div>
                                                </div>
                                                <div class="w-100">
                                                    <div class="features">
                                                        <ul>
                                                            {{--                                        <li class="text-start"><i class="fa fa-fw fa-check-circle text-danger"></i> Limited access to risk assessment tools.</li>--}}
                                                            {{--                                        <li class="text-start"><i class="fa fa-fw fa-check-circle text-danger"></i> Access to basic AI training materials.</li>--}}
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Full access to risk assessment tools.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Advanced AI training and certification.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Access to AI user support.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Priority email support.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Explainable AI.</li>
                                                            <li class="text-start"><i class="fa fa-fw fa-check-circle text-success"></i> Mitigation Strategies.</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="w-100">
                                                    <a href="#" class="w-100 rounded-pill btn btn-lg btn-secondary">Call Us</a>
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
    </div>

@endsection
@section('scripts')
    <script>

    </script>
@endsection
