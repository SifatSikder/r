@extends('Front.layouts.front')
@section('title', 'Project Strategy')
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>

    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white py-5">

                <div class="row">
                    <div class="col-lg-12">
                        <form class="w-100 py-5" action="{{route('front.user.project.strategies.update')}}" method="post">
                            {{csrf_field()}}
                            <div class="w-100">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="m-0"><strong>01. How do you currently manage and mitigate the identified risks in your technology usage?</strong></h5>
                                    </div>
                                    <div class="card-body p-5">

                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Comprehensive Risk Mitigation Strategies"
                                                       name="mitigate_strategy"
                                                       id="mitigate_strategy_1">
                                                <label class="form-check-label fs-4" for="mitigate_strategy_1">
                                                    Comprehensive Risk Mitigation Strategies
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Moderate Risk Mitigation Measures"
                                                       name="mitigate_strategy"
                                                       id="mitigate_strategy_2">
                                                <label class="form-check-label fs-4" for="mitigate_strategy_2">
                                                    Moderate Risk Mitigation Measures
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Basic Risk Mitigation Practices"
                                                       name="mitigate_strategy"
                                                       id="mitigate_strategy_3">
                                                <label class="form-check-label fs-4" for="mitigate_strategy_3">
                                                    Basic Risk Mitigation Practices
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input checked class="form-check-input me-3" type="radio" value="No Specific Risk Mitigation in Place"
                                                       name="mitigate_strategy"
                                                       id="mitigate_strategy_4">
                                                <label class="form-check-label fs-4" for="mitigate_strategy_4">
                                                    No Specific Risk Mitigation in Place
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="m-0"><strong>02. Are you implementing any ethical considerations and fairness measures in your technology usage?</strong></h5>
                                    </div>
                                    <div class="card-body p-5">

                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Yes, Extensively"
                                                       name="ethical_measures"
                                                       id="ethical_measures_1">
                                                <label class="form-check-label fs-4" for="ethical_measures_1">
                                                    Yes, Extensively
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Yes, to Some Extent"
                                                       name="ethical_measures"
                                                       id="ethical_measures_2">
                                                <label class="form-check-label fs-4" for="ethical_measures_2">
                                                    Yes, to Some Extent
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Not Yet, But Planning To"
                                                       name="ethical_measures"
                                                       id="ethical_measures_3">
                                                <label class="form-check-label fs-4" for="ethical_measures_3">
                                                    Not Yet, But Planning To
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input checked class="form-check-input me-3" type="radio" value="No"
                                                       name="ethical_measures"
                                                       id="ethical_measures_4">
                                                <label class="form-check-label fs-4" for="ethical_measures_4">
                                                    No
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                        <h5 class="m-0"><strong>03. What strategies do you have in place to address unforeseen challenges that might impact your technology usage's performance?</strong></h5>
                                    </div>
                                    <div class="card-body p-5">

                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Proactive Adaptation Strategies"
                                                       name="performance_strategy"
                                                       id="performance_strategy_1">
                                                <label class="form-check-label fs-4" for="performance_strategy_1">
                                                    Proactive Adaptation Strategies
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Reactive Problem Solving"
                                                       name="performance_strategy"
                                                       id="performance_strategy_2">
                                                <label class="form-check-label fs-4" for="performance_strategy_2">
                                                    Reactive Problem Solving
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input class="form-check-input me-3" type="radio" value="Limited Contingency Planning"
                                                       name="performance_strategy"
                                                       id="performance_strategy_3">
                                                <label class="form-check-label fs-4" for="performance_strategy_3">
                                                    Limited Contingency Planning
                                                </label>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="form-check d-flex justify-content-start align-items-center">
                                                <input checked class="form-check-input me-3" type="radio" value="No Specific Strategies"
                                                       name="performance_strategy"
                                                       id="performance_strategy_4">
                                                <label class="form-check-label fs-4" for="performance_strategy_4">
                                                    No Specific Strategies
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="w-100 text-end">
                                <input type="hidden" name="evaluation_id" value="{{$evaluation_id}}">
                                <button class="btn btn-lg btn-danger rounded-pill py-3 px-5">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $(function () {
            localStorage.removeItem('mot4ai_guest_id');
        })

        function changeProject() {
            const changeProjectForm = document.getElementById('changeProjectForm');
            changeProjectForm.submit();
        }
    </script>
@endsection
