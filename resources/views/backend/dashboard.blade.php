{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Dashboard')

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/dashboard.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="section">
    <!--card stats start-->
    <div id="card-stats" class="pt-0">
        <div class="row">
            <div class="col s12 m6 l6 xl3">
                <div
                    class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text animate fadeLeft">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">add_shopping_cart</i>
                                <p>Orders</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{ $ordersCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl3">
                <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text animate fadeLeft">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">group</i>
                                <p>Clients</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{ $clientsCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl3">
                <div
                    class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text animate fadeRight">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">record_voice_over</i>
                                <p>Artists</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{ $artistsCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s12 m6 l6 xl3">
                <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text animate fadeRight">
                    <div class="padding-4">
                        <div class="row">
                            <div class="col s7 m7">
                                <i class="material-icons background-round mt-5">ondemand_video</i>
                                <p>Courses</p>
                            </div>
                            <div class="col s5 m5 right-align">
                                <h5 class="mb-0 white-text">{{ $coursesCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--card stats end-->
    <!--yearly & weekly revenue chart start-->
    <div id="sales-chart">
        <div class="row">
            <div class="col s12">
                <div id="revenue-chart" class="card animate fadeUp">
                    <div class="card-content">
                        <h4 class="header mt-0">
                            REVENUE FOR {{ Carbon\Carbon::now()->format('Y') }}
                        </h4>
                        <div class="row">
                            <div class="col s12">
                                <div class="yearly-revenue-chart">
                                    <canvas id="thisYearRevenue" class="firstShadow" height="500"></canvas>
                                    <canvas id="lastYearRevenue" height="500"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s6">
                <div id="weekly-earning" class="card animate fadeUp">
                    <div class="card-content">
                        <h4 class="header m-0">Earning
                        </h4>
                        <h3 class="header">{{ $weekTotal }} <i
                                class="material-icons deep-orange-text text-accent-2">arrow_upward</i>
                        </h3>
                        <canvas id="monthlyEarning" class="" height="150"></canvas>
                        <div class="center-align">
                            <p class="lighten-3">Total Weekly Earning</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col s6">
                <div class="card animate fadeUp">
                    <div class="dashboard-revenue-wrapper padding-2 ml-2">
                        <p class="mt-2 mb-0">Today's Revenue</p>
                        <h5>{{ $todayTotal }}</h5>
                    </div>
                    <div class="sample-chart-wrapper">
                        <canvas id="custom-line-chart-sample-one" class="center"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/chartjs/chart.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script>
    (function (window, document, $) {
        // Line chart with color shadow: Revenue for this year Chart
        var thisYearctx = document
            .getElementById("thisYearRevenue")
            .getContext("2d");
        var lastYearctx = document
            .getElementById("lastYearRevenue")
            .getContext("2d");

        // Chart shadow LineAlt
        Chart.defaults.LineAlt = Chart.defaults.line;
        var draw =
            Chart.controllers.line.prototype.draw;
        var custom = Chart.controllers.line.extend({
            draw: function () {
                draw.apply(this, arguments);
                var ctx = this.chart.chart.ctx;
                var _stroke = ctx.stroke;
                ctx.stroke = function () {
                    ctx.save();
                    ctx.shadowColor =
                        "rgba(156, 46, 157,0.5)";
                    ctx.shadowBlur = 20;
                    ctx.shadowOffsetX = 2;
                    ctx.shadowOffsetY = 20;
                    _stroke.apply(this, arguments);
                    ctx.restore();
                };
            }
        });
        Chart.controllers.LineAlt = custom;

        // Chart shadow LineAlt2
        Chart.defaults.LineAlt2 =
            Chart.defaults.line;
        var draw =
            Chart.controllers.line.prototype.draw;
        var custom = Chart.controllers.line.extend({
            draw: function () {
                draw.apply(this, arguments);
                var ctx = this.chart.chart.ctx;
                var _stroke = ctx.stroke;
                ctx.stroke = function () {
                    ctx.save();
                    _stroke.apply(this, arguments);
                    ctx.restore();
                };
            }
        });

        Chart.controllers.LineAlt2 = custom;

        var thisYearRevenueData = @json($thisYearRevenueData);
        var lastYearRevenueData = @json($lastYearRevenueData);

        var thisYearData = {
            labels: Object.keys(thisYearRevenueData),
            datasets: [
                {
                    label: "This month revenue: ",
                    data: Object.values(thisYearRevenueData),
                    fill: false,
                    pointRadius: 2.2,
                    pointBorderWidth: 1,
                    borderColor: "#9C2E9D",
                    borderWidth: 5,
                    pointBorderColor: "#9C2E9D",
                    pointHighlightFill: "#9C2E9D",
                    pointHoverBackgroundColor:
                        "#9C2E9D",
                    pointHoverBorderWidth: 2
                }
            ]
        };

        var lastYearData = {
            labels: Object.keys(lastYearRevenueData),
            datasets: [
                {
                    label: "Last year dataset",
                    data: Object.values(lastYearRevenueData),
                    borderDash: [15, 5],
                    fill: false,
                    pointRadius: 0,
                    pointBorderWidth: 0,
                    borderColor: "#E4E4E4",
                    borderWidth: 5
                }
            ]
        };

        var thisYearOption = {
            responsive: true,
            maintainAspectRatio: true,
            datasetStrokeWidth: 3,
            pointDotStrokeWidth: 4,
            tooltipFillColor: "rgba(0,0,0,0.6)",
            legend: {
                display: false,
                position: "bottom"
            },
            hover: {
                mode: "label"
            },
            scales: {
                xAxes: [
                    {
                        display: false
                    }
                ],
                yAxes: [
                    {
                        ticks: {
                            padding: 20,
                            stepSize: 1000,
                            max: 10000,
                            min: 0,
                            fontColor: "#9e9e9e"
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false,
                            lineWidth: 1,
                            zeroLineColor: "#e5e5e5"
                        }
                    }
                ]
            },
            title: {
                display: false,
                fontColor: "#FFF",
                fullWidth: false,
                fontSize: 40,
                text: "82%"
            }
        };
        var lastYearOption = {
            responsive: true,
            maintainAspectRatio: true,
            datasetStrokeWidth: 3,
            pointDotStrokeWidth: 4,
            tooltipFillColor: "rgba(0,0,0,0.6)",
            legend: {
                display: false,
                position: "bottom"
            },
            hover: {
                mode: "label"
            },
            scales: {
                xAxes: [
                    {
                        display: false
                    }
                ],
                yAxes: [
                    {
                        ticks: {
                            padding: 20,
                            stepSize: 1000,
                            max: 10000,
                            min: 0
                        },
                        gridLines: {
                            display: true,
                            drawBorder: false,
                            lineWidth: 1
                        }
                    }
                ]
            },
            title: {
                display: false,
                fontColor: "#FFF",
                fullWidth: false,
                fontSize: 40,
                text: "82%"
            }
        };

        var thisYearChart = new Chart(thisYearctx, {
            type: "LineAlt",
            data: thisYearData,
            options: thisYearOption
        });

        var lastYearChart = new Chart(lastYearctx, {
            type: "LineAlt2",
            data: lastYearData,
            options: lastYearOption
        });

        //  Monthly Earning Chart : Line chart with shadow
        //---------------------------------------------------

        // Chart shadow
        Chart.defaults.earnningLineShadow =
            Chart.defaults.line;
        var draw =
            Chart.controllers.line.prototype.draw;
        var custom = Chart.controllers.line.extend({
            draw: function () {
                draw.apply(this, arguments);
                var ctx = this.chart.chart.ctx;
                var _stroke = ctx.stroke;
                ctx.stroke = function () {
                    ctx.save();
                    ctx.shadowColor =
                        "rgba(255, 111, 0, 0.3";
                    ctx.shadowBlur = 14;
                    ctx.shadowOffsetX = 2;
                    ctx.shadowOffsetY = 16;
                    _stroke.apply(this, arguments);
                    ctx.restore();
                };
            }
        });
        Chart.controllers.earnningLineShadow = custom;

        var weekRevenueDataIndex = @json($weekRevenueDataIndex);
        var weekRevenueDataValue = @json($weekRevenueDataValue);


        //Chart gradient strock
        var Earningctx = document
            .getElementById("monthlyEarning")
            .getContext("2d");
        var gradientStroke = Earningctx.createLinearGradient(
            500,
            0,
            0,
            200
        );
        gradientStroke.addColorStop(0, "#ffca28");
        gradientStroke.addColorStop(1, "#ff6f00");
        //Chart data
        var earningChartData = {
            labels: Object.values(weekRevenueDataIndex),
            datasets: [
                {
                    label: "This year dataset",
                    lineTension: 0,
                    fill: false,
                    pointRadius: 0,
                    pointBorderWidth: 0,
                    borderColor: gradientStroke,
                    borderWidth: 3,
                    data: Object.values(weekRevenueDataValue),
                }
            ]
        };

        var earningChartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            datasetStrokeWidth: 3,
            pointDotStrokeWidth: 4,
            tooltipFillColor: "rgba(0,0,0,0.6)",
            layout: {
                padding: {
                    left: 50,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            },
            legend: {
                display: false,
                position: "bottom"
            },
            hover: {
                mode: "label"
            },
            scales: {
                xAxes: [
                    {
                        display: false
                    }
                ],
                yAxes: [
                    {
                        display: false
                    }
                ]
            },
            title: {
                display: false,
                fontColor: "#FFF",
                fullWidth: false,
                fontSize: 40,
                text: "82%"
            }
        };

        var MonthlyEarningChart = new Chart(
            Earningctx,
            {
                type: "earnningLineShadow",
                data: earningChartData,
                options: earningChartOptions
            }
        );

        var todayRevenueDataIndex = @json($todayRevenueDataIndex);
        var todayRevenueDataValue = @json($todayRevenueDataValue);

        // Sampel Line Chart One
        // --------------------------

        // Options
        var SLOption = {
            responsive: true,
            maintainAspectRatio: true,
            datasetStrokeWidth: 3,
            pointDotStrokeWidth: 4,
            tooltipFillColor: "rgba(0,0,0,0.6)",
            legend: {
                display: false,
                position: "bottom"
            },
            hover: {
                mode: "label"
            },
            scales: {
                xAxes: [
                    {
                        display: false
                    }
                ],
                yAxes: [
                    {
                        display: false
                    }
                ]
            },
            title: {
                display: false,
                fontColor: "#FFF",
                fullWidth: false,
                fontSize: 40,
                text: "82%"
            }
        };
        var SLlabels = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June"
        ];

        var LineSL1ctx = document
            .getElementById(
                "custom-line-chart-sample-one"
            )
            .getContext("2d");

        var gradientStroke = LineSL1ctx.createLinearGradient(
            300,
            0,
            0,
            300
        );
        gradientStroke.addColorStop(0, "#0288d1");
        gradientStroke.addColorStop(1, "#26c6da");

        var gradientFill = LineSL1ctx.createLinearGradient(
            300,
            0,
            0,
            300
        );
        gradientFill.addColorStop(0, "#0288d1");
        gradientFill.addColorStop(1, "#26c6da");

        var SL1Chart = new Chart(LineSL1ctx, {
            type: "line",
            data: {
                labels: Object.values(todayRevenueDataIndex),
                datasets: [
                    {
                        label: "Total cost: ",
                        borderColor: gradientStroke,
                        pointColor: "#fff",
                        pointBorderColor: gradientStroke,
                        pointBackgroundColor: "#fff",
                        pointHoverBackgroundColor: gradientStroke,
                        pointHoverBorderColor: gradientStroke,
                        pointRadius: 4,
                        pointBorderWidth: 1,
                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 1,
                        fill: true,
                        backgroundColor: gradientFill,
                        borderWidth: 1,
                        data: Object.values(todayRevenueDataValue),
                    }
                ]
            },
            options: SLOption
        });
    })(window, document, jQuery);
</script>
@endsection
