@extends('auth.layouts.master')

@section('title', 'Анализ продаж')

@section('content')

    <div class="d-none">
        <ul>
            @foreach($Agenres as $Agenre)
                <li class="agenre">{{$Agenre->genres}}:{{$Agenre->count}}</li>
            @endforeach
        </ul>
    </div>
    <div class="d-none">
        <ul>
            @foreach($Ayears as $year)
                <li class="ayear">{{$year->year}}:{{$year->count}}</li>
            @endforeach
        </ul>
    </div>
    <div class="d-none">
        <ul>
            @foreach($Aprices as $prices)
                <li class="aprice">{{$prices->price}}:{{$prices->count}}</li>
            @endforeach
        </ul>
    </div>

    <div>
        <h3>Разрез по жанрам</h3>
        <div class="row">
            <div class="col-lg-12">
                <canvas id="chartGenres" width="800" height="400"></canvas>
            </div>

        </div>

        <h3>Разрез по годам</h3>
        <div class="row">
            <div class="col-lg-12">
                <canvas id="chartYears" width="800" height="400"></canvas>
            </div>

        </div>

        <h3>Разрез по ценам</h3>
        <div class="row">
            <div class="col-lg-12">
                <canvas id="chartPrices" width="800" height="400"></canvas>
            </div>
        </div>
    </div>

    <script src="/js/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"></script>
    <script>
        $(function () {

            function buildChartGenres() {
                var arrX = [];
                var arrY = [];


                var i = 0;
                $(".agenre").each(function () {
                    var arr = $(this).text().split(":");
                    arrX[i] = arr[0];
                    arrY[i] = arr[1];
                    i++;
                })


                const ctx = document.getElementById('chartGenres');
                const labels = arrX;
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Разрез по жанру',
                        data: arrY,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(201, 203, 207, 0.2)'
                        ],
                        borderColor: [
                            'rgb(255, 99, 132)',
                            'rgb(255, 159, 64)',
                            'rgb(255, 205, 86)',
                            'rgb(75, 192, 192)',
                            'rgb(54, 162, 235)',
                            'rgb(153, 102, 255)',
                            'rgb(201, 203, 207)'
                        ],
                        borderWidth: 1
                    }]
                };
                const config = {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    },
                };
                const myChart = new Chart(ctx, config);
            }

            function buildChartYears() {
                var arrX = [];
                var arrY = [];


                var i = 0;
                $(".ayear").each(function () {
                    var arr = $(this).text().split(":");
                    arrX[i] = arr[0];
                    arrY[i] = arr[1];
                    i++;
                })


                const ctx = document.getElementById('chartYears');
                const labels = arrX;
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Разрез по годам',
                        data: arrY,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                };
                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    },
                };
                const myChart = new Chart(ctx, config);
            }

            function buildChartPrices() {
                var arrX = [];
                var arrY = [];


                var i = 0;
                $(".aprice").each(function () {
                    var arr = $(this).text().split(":");
                    arrX[i] = arr[0];
                    arrY[i] = arr[1];
                    i++;
                })


                const ctx = document.getElementById('chartPrices');
                const labels = arrX;
                const data = {
                    labels: labels,
                    datasets: [{
                        label: 'Разрез по ценам',
                        data: arrY,
                        fill: false,
                        borderColor: 'rgb(255,0,0)',
                        tension: 0.1
                    }]
                };
                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                    },
                };
                const myChart = new Chart(ctx, config);
            }

            buildChartGenres();
            buildChartYears();
            buildChartPrices();

        })


    </script>
@endsection
