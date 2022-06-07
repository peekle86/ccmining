@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Dashboard
                </div>

                @if( auth()->user()->roles()->whereId(1)->count() )
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <canvas id="reg_chart" width="400" height="250"></canvas>
                            </div>
                            <table class="table">
                                <tr>
                                    <td>24 hours</td>
                                    <td class="text-right">{{ $count_register['day'] }}</td>
                                </tr>
                                <tr>
                                    <td>7 days</td>
                                    <td class="text-right">{{ $count_register['week'] }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <canvas id="contr_chart" width="400" height="250"></canvas>
                            </div>
                            <table class="table">
                                <tr>
                                    <td>24 hours</td>
                                    <td class="text-right">{{ $count_contract['day'] }}</td>
                                </tr>
                                <tr>
                                    <td>7 days</td>
                                    <td class="text-right">{{ $count_contract['week'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <canvas id="deposit_chart" width="400" height="250"></canvas>
                            </div>
                            <table class="table">
                                <tr>
                                    <td>24 hours</td>
                                    <td class="text-right">${{ $sum_deposit['day'] }}</td>
                                </tr>
                                <tr>
                                    <td>7 days</td>
                                    <td class="text-right">${{ $sum_deposit['week'] }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-4">
                                <canvas id="earn_chart" width="400" height="250"></canvas>
                            </div>
                            <table class="table">
                                <tr>
                                    <td>24 hours</td>
                                    <td class="text-right">${{ $sum_earn['day'] }}</td>
                                </tr>
                                <tr>
                                    <td>7 days</td>
                                    <td class="text-right">${{ $sum_earn['week'] }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            Latest hardware parsing: {{ optional($last_parsing_time)->updated_at }}
                        </div>
                        <div class="col-md-6">
                            Cron last started: {{ \App\Models\Setting::first()->updated_at }}
                        </div>
                        <div class="col-md-6">

                        </div>
                    </div>

                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.2/dist/chart.min.js"></script>
<script>
    let graph_register = {!! json_encode($graph_register) !!}
    let graph_contract = {!! json_encode($graph_contract) !!}
    let graph_deposit = {!! json_encode($graph_deposit) !!}
    let graph_earn = {!! json_encode($graph_earn) !!}
    console.log(graph_register);
    graphInit('reg_chart', graph_register,'Registrations');
    graphInit('contr_chart', graph_contract,'Miners Buy');
    graphInit('deposit_chart', graph_deposit,'Deposits($)');
    graphInit('earn_chart', graph_earn,'Earn($)');

    function graphInit(id, graph_data, title="") {
        const ctx = document.getElementById(id).getContext('2d');
        const labels = graph_data['labels'];
        const data = {
            labels: labels,
            datasets: [{
                label: title,
                backgroundColor: '#cdff93',
                borderColor: 'green',
                data: graph_data['data'],
            }]
        };
        const config = {
            type: 'line',
            data: data,
            options: {}
        };
        const chart = new Chart(
            ctx,
            config
        );
    }

    // function daysInThisMonth() {
    //     var now = new Date();
    //     return new Date(now.getFullYear(), now.getMonth()+1, 0).getDate();
    // }



</script>

@parent

@endsection
