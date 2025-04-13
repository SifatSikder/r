@extends('Front.layouts.front')
@section('title', 'Dashboard')
@section('content')

    <div class="dashboard-header" style="background-image: url('{{asset('img/banners/2.jpg')}}')"></div>

    <div class="w-100">
        <div class="container">
            <div class="w-100 bg-white py-5">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="w-100">
                            <div class="card shadow">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h5 class="m-0"><strong>Project Details</strong></h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row d-flex align-items-center">
                                        <div class="col-lg-3">
                                            <div class="w-100 p-3 bg-light border">
                                                <div class="w-100 mb-3">
                                                    <span class="badge bg-success rounded-pill px-4 py-2">{{ ucfirst($evaluation['evaluation_sector']) }}</span>
                                                    <p class="m-0 p-0 text-secondary"><strong>Evaluation Domain</strong></p>
                                                </div>
                                                <div class="w-100">
                                                    <span class="badge bg-primary rounded-pill px-4 py-2">{{ ucfirst('ChatGPT') }}</span>
                                                    <p class="m-0 p-0 text-secondary"><strong>AI System Type</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="w-100 mb-3">
                                                <h1 class="text-dark text-center m-0"><strong>{{$evaluation['project']['name']}}</strong></h1>
                                            </div>
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
                                                    <tr>
                                                        <th class="p-0">Unacceptable</th>
                                                        <td class="p-0 text-end"><span class="badge bg-unacceptable" style="width: 95px">Unacceptable</span></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row d-none">
                                        @if(isset($evaluation))
                                            <div class="col-lg-12 mt-3">
                                                <div class="row">
                                                    <div class="col-lg-12">

                                                        <div class="text-center">
                                                            <h4><strong>Risk Level:</strong></h4>
                                                            <strong>Software <span class="badge bg-{{strtolower($final_result['software'])}} text-white">{{$final_result['software']}}</span></strong>
                                                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                                                            <strong>Hardware <span class="badge bg-{{strtolower($final_result['hardware'])}} text-white">{{$final_result['hardware']}}</span></strong>
                                                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                                                            <strong>Hardware <span class="badge bg-{{strtolower($final_result['ethical'])}} text-white">{{$final_result['ethical']}}</span></strong>
                                                            &nbsp;&nbsp;&nbsp; . &nbsp;&nbsp;&nbsp;
                                                            <strong>Hardware <span class="badge bg-{{strtolower($final_result['legal'])}} text-white">{{$final_result['legal']}}</span></strong>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(isset($final_result))
                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-xl-3 mb-4">
                                    <div class="shadow p-4 border d-flex align-items-end border-1 border-{{strtolower($final_result['software'])}}">
                                        <div class="d-inline-block text-start"><i class="text-{{strtolower($final_result['software'])}} fa fa-2x fa-desktop"></i><br><small>Risk Evaluation</small></div>
                                        <div class="flex-fill text-end">
                                            <h4 class="text-{{strtolower($final_result['software'])}} m-0 p-0">SOFTWARE</h4>
                                            <div class="d-inline-block">
                                                <span class="badge bg-{{strtolower($final_result['software'])}} text-white">{{$final_result['software']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 mb-4">
                                    <div class="shadow p-4 border d-flex align-items-end border-1 border-{{strtolower($final_result['hardware'])}}">
                                        <div class="d-inline-block text-start"><i class="text-{{strtolower($final_result['hardware'])}} fa fa-2x fa-cogs"></i><br><small>Risk Evaluation</small></div>
                                        <div class="flex-fill text-end">
                                            <h4 class="text-{{strtolower($final_result['hardware'])}} m-0 p-0">HARDWARE</h4>
                                            <div class="d-inline-block">
                                                <span class="badge bg-{{strtolower($final_result['hardware'])}} text-white">{{$final_result['hardware']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 mb-4">
                                    <div class="shadow p-4 border d-flex align-items-end border-1 border-{{strtolower($final_result['ethical'])}}">
                                        <div class="d-inline-block text-start"><i class="text-{{strtolower($final_result['ethical'])}} fa fa-2x fa-user-secret"></i><br><small>Risk Evaluation</small></div>
                                        <div class="flex-fill text-end">
                                            <h4 class="text-{{strtolower($final_result['ethical'])}} m-0 p-0">ETHICAL</h4>
                                            <div class="d-inline-block">
                                                <span class="badge bg-{{strtolower($final_result['ethical'])}} text-white">{{$final_result['ethical']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 mb-4">
                                    <div class="shadow p-4 border d-flex align-items-end border-1 border-{{strtolower($final_result['legal'])}}">
                                        <div class="d-inline-block text-start"><i class="text-{{strtolower($final_result['legal'])}} fa fa-2x fa-file-archive-o"></i><br><small>Evaluation</small></div>
                                        <div class="flex-fill text-end">
                                            <h4 class="text-{{strtolower($final_result['legal'])}} m-0 p-0">LEGAL</h4>
                                            <div class="d-inline-block">
                                                <span class="badge bg-{{strtolower($final_result['legal'])}} text-white">{{$final_result['legal']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card shadow">
                                <div class="card-header py-3">
                                    <h5 class="m-0">Risk Evaluation</h5>
                                </div>
                                <div class="card-body">
                                    <div class="w-100">
                                        <table class="table table-bordered">
                                            <tr class="bg-light">
                                                <th class="fs-4">Risk</th>
                                                @foreach($risk_martix as $botName => $m)
                                                    <th class="text-center fs-5">{{$botName}}</th>
                                                @endforeach
                                            </tr>
                                            @foreach($risk_factors as $k => $factor)
                                                <tr>
                                                    <th>{{$factor['title']}}</th>
                                                    @foreach($risk_martix as $risk)
                                                        <td class="text-center">
                                                            <span class="badge bg-{{strtolower($risk['risk_factors'][$k]['risk'])}} text-white">{{$risk['risk_factors'][$k]['risk']}}</span>
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                @if(isset($evaluation['strategy']))
                    <div class="w-100 mt-4">
                        <div class="card shadow">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h5 class="m-0"><strong>Project Strategy</strong></h5>
                            </div>
                            <div class="card-body">

                                <table class="table table-borderless">
                                    <tr>
                                        <td style="width: 50px"><h4>01.</h4></td>
                                        <td>
                                            <h5>How do you currently manage and mitigate the identified risks in your technology usage?</h5>
                                            <p><span class="badge bg-success fs-6">{{$evaluation['strategy']['mitigate_strategy']}}</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50px"><h4>02.</h4></td>
                                        <td>
                                            <h5>Are you implementing any ethical considerations and fairness measures in your technology usage?</h5>
                                            <p><span class="badge bg-success fs-6">{{$evaluation['strategy']['ethical_measures']}}</span></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50px"><h4>03.</h4></td>
                                        <td>
                                            <h5>What strategies do you have in place to address unforeseen challenges that might impact your technology usage's performance?</h5>
                                            <p><span class="badge bg-success fs-6">{{$evaluation['strategy']['performance_strategy']}}</span></p>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @if(isset($final_result))
        <!-- Specific Library Uses -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
        <script>
            $(function () {
                localStorage.removeItem('mot4ai_guest_id');

                // Software chart
                new Chart(document.getElementById("software-risk-evaluation-chart"), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($risk_percentages['software_risks']['label']) !!},
                        datasets: [
                            {
                                backgroundColor: ['#198754', '#0D6EFD', '#FFC107', '#DC3545'],
                                data: {!! json_encode($risk_percentages['software_risks']['data']) !!}
                            }
                        ]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            position: 'bottom',
                            display: true,
                            text: 'Risk Evaluation (Software)'
                        }
                    }
                });
                // Hardware chart
                new Chart(document.getElementById("hardware-risk-evaluation-chart"), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($risk_percentages['hardware_risks']['label']) !!},
                        datasets: [
                            {
                                backgroundColor: ['#198754', '#0D6EFD', '#FFC107', '#DC3545'],
                                data: {!! json_encode($risk_percentages['hardware_risks']['data']) !!}
                            }
                        ]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            position: 'bottom',
                            display: true,
                            text: 'Risk Evaluation (Hardware)'
                        }
                    }
                });
                // Ethical chart
                new Chart(document.getElementById("ethical-risk-evaluation-chart"), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($risk_percentages['ethical_risks']['label']) !!},
                        datasets: [
                            {
                                backgroundColor: ['#198754', '#0D6EFD', '#FFC107', '#DC3545'],
                                data: {!! json_encode($risk_percentages['ethical_risks']['data']) !!}
                            }
                        ]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            position: 'bottom',
                            display: true,
                            text: 'Risk Evaluation (Ethical)'
                        }
                    }
                });
                // Legal chart
                new Chart(document.getElementById("legal-risk-evaluation-chart"), {
                    type: 'pie',
                    data: {
                        labels: {!! json_encode($risk_percentages['legal_risks']['label']) !!},
                        datasets: [
                            {
                                backgroundColor: ['#198754', '#0D6EFD', '#FFC107', '#DC3545'],
                                data: {!! json_encode($risk_percentages['legal_risks']['data']) !!}
                            }
                        ]
                    },
                    options: {
                        legend: {display: false},
                        title: {
                            position: 'bottom',
                            display: true,
                            text: 'Risk Evaluation (Legal)'
                        }
                    }
                });
            })
        </script>
    @endif
    <script>
        function changeProject() {
            const changeProjectForm = document.getElementById('changeProjectForm');
            changeProjectForm.submit();
        }
    </script>
@endsection
