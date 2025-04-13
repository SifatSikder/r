@extends('Front.layouts.front')
@section('title', 'Dashboard')
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>

    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white py-5">

                <div class="row d-flex align-items-center py-3">
                    <div class="col-lg-12">
                        <h2 class="text-center text-secondary m-0"><strong>{{ $evaluation['project']['name'] }}</strong></h2>
                    </div>
                </div>
                <div class="row py-3">
                    <div class="col-lg-12 text-center">
                        <a href="javascript:void(0)" class="btn btn-info text-uppercase px-5 me-5">{{ $evaluation['evaluation_sector'] }}</a>
                        <a href="javascript:void(0)" class="btn btn-warning text-uppercase px-5">{{ $evaluation['ai_system_type'] }}</a>
                    </div>
                    <div class="col-lg-12 text-center mt-5">
                        <h4 class="alert alert-primary">
                            Based on your answers, your technology usage in the
                            <span class="badge bg-warning text-uppercase">{{ $evaluation['ai_system_type'] }}</span>
                            falls under the
                            <span class="badge bg-{{strtolower($evaluation['risk_level'])}}">{{ $evaluation['risk_level'] }}</span>
                            Risk level
                        </h4>
                    </div>
                </div>
                <div class="row">
                    @foreach($report as $r)
                        <div class="col-lg-6">
                            <div class="w-100">
                                <div class="card shadow mb-4">
                                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                                        <h4 class="m-0 p-0">{{ $r['title'] }}</h4>
                                        <span class="badge bg-{{strtolower($evaluation['risk_level'])}}">{{ $r['risks_percentage'] }}%</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="w-100">
                                            <table class="table table-text-small">
                                                <thead>
                                                <tr>
                                                    <th>Risk Factor</th>
                                                    @foreach($evaluation['chatbots'] as $chatbot)
                                                        <th class="text-center">{{ $chatbot }}</th>
                                                    @endforeach
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($r['risk_factors'] as $factor)
                                                    <tr v-for="factor in $r['risk_factors']">
                                                        <td>{{ $factor['title'] }}</td>
                                                        @if($factor['report'] === null)
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                            <td class="text-center">-</td>
                                                        @endif
                                                        @if($factor['report'] !== null)
                                                            @foreach($factor['report'] as $risk)
                                                            <td class="text-center">
                                                                <span class="badge bg-{{strtolower($risk)}}">{{ $risk }}</span>
                                                            </td>
                                                            @endforeach
                                                        @endif
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row py-3">
                    <div class="col-lg-7">
                        <div class="w-100 h-100 bg-white shadow border p-5">
                            <h2 class="text-secondary mb-4"><strong>Heading</strong></h2>
                            <p class="m-0 p-0">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                <br><br>
                                aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur
                                adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="w-100 h-100 bg-white shadow border p-5">
                            <canvas id="risk-evaluation-chart" style="width: 100%;display: inline-block;height: 400px"></canvas>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <!-- Specific Library Uses -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
        $(function () {
            // Software chart
            new Chart(document.getElementById("risk-evaluation-chart"), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($chart['label']) !!},
                    datasets: [
                        {
                            backgroundColor: ['#198754', '#0D6EFD', '#FFC107', '#DC3545'],
                            data: {!! json_encode($chart['data']) !!}
                        }
                    ]
                },
                options: {
                    legend: {display: true},
                    title: {
                        position: 'bottom',
                        display: true,
                        text: 'Risk Evaluation'
                    }
                }
            });
        })
    </script>
@endsection
