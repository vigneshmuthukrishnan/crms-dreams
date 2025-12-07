<x-app-layout>
    <div class="content pb-0">
        <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
            <div>
                <h4 class="mb-1">Dashboard</h4>
            </div>
        </div>                

        <div class="row row-gap-3 mb-4">
            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill mb-0 position-relative overflow-hidden">
                    <div class="card-body position-relative z-1">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fs-14 mb-1">Total Companies</p>
                                    <h2 class="mb-1 fs-16">{{$countComp}}</h2>
                                    <p class="text-success mb-0 fs-13">{{$percentageChangeComp}} %<span class="text-body ms-1">from last month</span></p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="avatar avatar-md rounded-circle bg-soft-primary border border-primary">
                                    <i class="ti ti-building fs-16 text-primary"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <img src="assets/img/icons/elemnt-01.svg" alt="elemnt-04" class="img-fluid position-absolute top-0 Start-0">
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill mb-0 position-relative overflow-hidden">
                    <div class="card-body position-relative z-1">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fs-14 mb-1">Total Leads</p>
                                    <h2 class="mb-1 fs-16">{{$countLead}}</h2>
                                    <p class="text-success mb-0 fs-13"> {{$percentageChangeLead}} %<span class="text-body ms-1">from last month</span></p>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="avatar avatar-md rounded-circle bg-soft-success border border-success">
                                    <i class="ti ti-carousel-vertical fs-16 text-success"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <img src="assets/img/icons/elemnt-02.svg" alt="elemnt-04" class="img-fluid position-absolute top-0 Start-0">
                </div>
            </div>

            <div class="col-xl-3 col-sm-6 d-flex">
                <div class="card flex-fill mb-0 position-relative overflow-hidden">
                    <div class="card-body position-relative z-1">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <p class="fs-14 mb-1">Total User</p>
                                    <h2 class="mb-1 fs-16">{{$countUser}}</h2>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="avatar avatar-md rounded-circle bg-soft-warning border border-warning">
                                    <i class="ti ti-chalkboard-off fs-16 text-warning"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <img src="assets/img/icons/elemnt-03.svg" alt="elemnt-04" class="img-fluid position-absolute top-0 Start-0">
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-6 d-flex">
                <div class="card flex-fill">
                    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <h6 class="mb-0">2025 Lead</h6>
                        <div class="dropdown">
                            <!-- <a class="dropdown-toggle btn btn-outline-light shadow p-2" data-bs-toggle="dropdown" href="javascript:void(0);">
                                <i class="ti ti-calendar me-1"></i>2025
                            </a> -->
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:void(0);" class="dropdown-item">
                                    2025
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    2024
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item">
                                    2023
                                </a>
                            </div>
                        </div>							
                    </div>
                    <div class="card-body pb-0">
                        <!-- <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
                            <div class="mb-1">
                                <h5 class="mb-2 fs-16 fw-bold">{{$currentYearLead}}</h5>
                                <p class="mb-0 fs-13"><span class="text-success fw-normal me-1"><i class="ti ti-arrow-bar-up me-1"></i>40%</span>increased from last year</p>
                            </div>
                            <p class="fs-14 text-dark d-flex align-items-center mb-1"><i class="ti ti-circle-filled me-1 fs-6 text-teal"></i>Leads</p>
                        </div> -->
                        <div id="revenue-income"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script src="{{ asset('assets/plugins/apexchart/apexcharts.min.js') }}"></script>
<script>
    $(document).ready(function () {
        var monthlyLeadData = @json($leadData);
        if ($('#revenue-income').length > 0) {
            var sColStacked = {
                chart: {
                    height: 260,
                    type: 'bar',
                    stacked: true,
                    toolbar: {
                        show: false,
                    }
                },
                colors: ['#0E9384', '#E8E8E8'], // Progress then background
                plotOptions: {
                    bar: {
                        borderRadius: 5,
                        borderRadiusWhenStacked: 'all',
                        horizontal: false,
                        endingShape: 'rounded',
                        columnWidth: '24px',
                    },
                },
                series: [
                    {
                        name: 'Lead Count',
                        data: monthlyLeadData
                    },
                    {
                        name: 'Traget',
                        data: [100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100, 100]
                    }
                ],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct','Nov', 'Dec'],
                    labels: {
                        style: {
                            colors: '#0E9384',
                            fontSize: '13px',
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    labels: {
                            offsetX: -15,
                            style: {
                            colors: '#6B7280',
                            fontSize: '13px',
                        },
                        formatter: function (value) {
                            return value;
                        }
                    }
                },
                grid: {
                    borderColor: 'transparent',
                    strokeDashArray: 5,
                    padding: {
                        left: -8,
                    },
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    enabled: false
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val;
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }]
            }
            var chart = new ApexCharts(
                document.querySelector("#revenue-income"),
                sColStacked
            );
            chart.render();
        }
    });    
</script>