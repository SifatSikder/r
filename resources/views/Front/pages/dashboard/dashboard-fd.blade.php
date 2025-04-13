@extends('Front.layouts.front')
@section('title', 'Dashboard')
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>

    <div class="w-100 py-5">
        <div class="container">

            <div class="w-100">
                <div class="row">
                    <div class="col-lg-9">
                        <h2 class="text-dark m-0"><strong>{{ $evaluation['project']['name'] }}</strong></h2>
                        <p class="text-dark m-0"><strong>{{ $evaluation['project']['website'] }}</strong></p>
                        <p class="text-dark m-0"><strong>{{ $evaluation['project']['desc'] }}</strong></p>
                    </div>
                    <div class="col-lg-3">
                        <div class="w-100 p-3 bg-light border">
                            <table class="table table-borderless">
                                <tr>
                                    <th class="p-0">No Risk</th>
                                    <td class="p-0 text-end"><span class="badge bg-white border border-dark text-dark" style="width: 95px">No Risk</span></td>
                                </tr>
                                <tr>
                                    <th class="p-0">Low Risk</th>
                                    <td class="p-0 text-end"><span class="badge bg-low" style="width: 95px">Low Risk</span></td>
                                </tr>
                                <tr>
                                    <th class="p-0">Limited Risk</th>
                                    <td class="p-0 text-end"><span class="badge bg-limited" style="width: 95px">Limited Risk</span></td>
                                </tr>
                                <tr>
                                    <th class="p-0">High Risk</th>
                                    <td class="p-0 text-end"><span class="badge bg-high" style="width: 95px">High Risk</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center mt-3 mb-3">

                        <div class="w-100 bg-light border p-3 text-center">
                            <h4 class="d-inline-block px-5 pb-3 border-bottom border-dark"><strong>Risk Level</strong></h4>
                            <br><br>
                            <strong>No Risk <span class="badge bg-white border border-dark text-dark">{{$riskPercentage['No']}}%</span></strong>
                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                            <strong>Low Risk <span class="badge bg-low text-white">{{$riskPercentage['Low']}}%</span></strong>
                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                            <strong>Limited Risk <span class="badge bg-limited text-white">{{$riskPercentage['Limited']}}%</span></strong>
                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                            <strong>High Risk <span class="badge bg-high text-white">{{$riskPercentage['High']}}%</span></strong>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="w-100">
                            <div class="card mb-4">
                                <div class="card-header py-3">
                                    <h4 class="m-0 p-0 text-center"><strong>Risk Evaluation</strong></h4>
                                </div>
                                <div class="card-body">
                                    <div class="w-100">
                                        <div class="w-100 text-center">
                                            @foreach($risk_report['questionRiskLevel'] as $q => $risk)
                                                <div class="d-inline-block">
                                                    <div class="bg-{{strtolower($risk)}} border-{{strtolower($risk)}} rounded-pill cursor_pointer border shadow hover-opacity d-flex align-items-center justify-content-center position-relative m-1 "
                                                         style="height: 75px;width: 75px;float: left">
                                                        <strong class="text-uppercase">{{strtoupper($q)}}</strong>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-lg-6">
                        <div class="w-100 bg-white border p-5" style="height: 500px;overflow-y: auto; overflow-x: hidden;display: inline-block">
                            <h3 class="mb-4"><strong>Risk Level & Mitigation Strategies</strong></h3>
                            <h5 class="alert alert-warning">
                                To have a real Evaluation Report with Mitigation Strategies please
                                <a href="{{route('front.risk.evaluation', ['join-now'])}}">Start Your AI Risk Evaluation</a>
                            </h5>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="w-100 bg-white border p-3 text-center" style="height: 500px;overflow: hidden;display: inline-block">
                            <canvas id="evaluation-chart" class="d-inline-block"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(function () {
            new Chart(document.getElementById("evaluation-chart"), {
                type: 'pie',
                data: {
                    labels: ['Low Risk', 'Limited Risk', 'High Risk', 'No Risk'],
                    datasets: [
                        {
                            backgroundColor: ['#44BD32', '#778CA3', '#EB3B5A', '#ffffff'],
                            borderColor: ['#44BD32', '#778CA3', '#EB3B5A', '#e6e6e6'],
                            borderWidth: [5, 5, 5, 5],
                            data: [{{$riskPercentage['Low']}}, {{$riskPercentage['Limited']}}, {{$riskPercentage['High']}}, {{$riskPercentage['No']}}]
                        }
                    ]
                },
                options: {
                    legend: {display: false},
                    title: {
                        position: 'bottom',
                        display: true,
                        text: 'Risk Evaluation (Fair Decision)'
                    }
                }
            });
        })
    </script>
@endsection
