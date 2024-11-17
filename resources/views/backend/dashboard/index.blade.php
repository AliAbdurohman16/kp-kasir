@extends('layouts.backend.main')

@section('title', 'Dashboard')

@section('css')
<!-- Apex Chart css -->
<link rel="stylesheet" href="{{ asset('backend') }}/assets/css/lib/apexcharts.css">
@endsection

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Dashboard</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-xxl-12">
        <div class="row gy-4">

            <div class="col-xxl-4 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-1">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-primary-600 flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6 mb-0">
                                    <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Pendapatan Hari Ini</span>
                                    <h6 class="fw-semibold">Rp {{ number_format($daily_income, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-2">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-success-main flex-shrink-0 text-white d-flex justify-content-center align-items-center rounded-circle h6">
                                    <iconify-icon icon="mingcute:user-follow-fill" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Pendapatan Bulan Ini</span>
                                    <h6 class="fw-semibold">Rp {{ number_format($monthly_income, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xxl-4 col-sm-6">
                <div class="card p-3 shadow-2 radius-8 border input-form-light h-100 bg-gradient-end-6">
                    <div class="card-body p-0">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-1 mb-8">

                            <div class="d-flex align-items-center gap-2">
                                <span class="mb-0 w-48-px h-48-px bg-cyan text-white flex-shrink-0 d-flex justify-content-center align-items-center rounded-circle h6">
                                    <iconify-icon icon="streamline:bag-dollar-solid" class="icon"></iconify-icon>
                                </span>
                                <div>
                                    <span class="mb-2 fw-medium text-secondary-light text-sm">Pendapatan Tahun Ini</span>
                                    <h6 class="fw-semibold">Rp {{ number_format($yearly_income, 0, ',', '.') }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Chart Bar start -->
    <div class="col-xxl-12">
        <div class="card h-100 radius-8 border-0">
            <div class="card-body p-24">
                <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
                    <div>
                        <h6 class="mb-2 fw-bold text-lg">Bar Chart Tahun {{ date('Y') }}</h6>
                    </div>
                </div>

                <div id="barChart"></div>
            </div>
        </div>
    </div>
    <!-- Chart Bar End -->

    <!-- Log Activity Start -->
    <div class="col-xxl-12">
        <div class="card h-100">
            <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center justify-content-between">
                <h6 class="text-lg fw-semibold mb-0">Log Aktivitas</h6>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Aktivitas</th>
                                <th>Tanggal & Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activities as $activity)
                                @if ($activity->causer_id)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            </span><span class="package-name">
                                                {{ optional($activity->causer)->name }}
                                            </span>
                                        </td>
                                        <td>{{ $activity->description }}</td>
                                        <td>{{ date('d-m-Y H:i:s', strtotime($activity->created_at)) }}</td>
                                    </tr>
                                @elseif($activity->causer_id)
                                    <tr>
                                        <td colspan="4">Akun sudah dihapus.</td>
                                    </tr>
                                @endif
                            @empty
                            @endforelse 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Log Activity End -->
</div>
@endsection

@section('js')
<!-- Apex Chart js -->
<script src="{{ asset('backend') }}/assets/js/lib/apexcharts.min.js"></script>
<script>
    var monthlyData = @json($chartMonthly).map(value => parseFloat(value));

    var options = {
    series: [{
        name: "Sales",
        data: [{
            x: 'Jan',
            y: monthlyData[0],
        }, {
            x: 'Feb',
            y: monthlyData[1],
        }, {
            x: 'Mar',
            y: monthlyData[2],
        }, {
            x: 'Apr',
            y: monthlyData[3],
        }, {
            x: 'Mei',
            y: monthlyData[4],
        }, {
            x: 'Jun',
            y: monthlyData[5],
        }, {
            x: 'Jul',
            y: monthlyData[6],
        }, {
            x: 'Agu',
            y: monthlyData[7],
        }, {
            x: 'Sep',
            y: monthlyData[8],
        }, {
            x: 'Okt',
            y: monthlyData[9],
        }, {
            x: 'Nov',
            y: monthlyData[10],
        }, {
            x: 'Des',
            y: monthlyData[11],
        }]
    }],
    chart: {
        type: 'bar',
        height: 310,
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            borderRadius: 4,
            horizontal: false,
            columnWidth: '23%',
            endingShape: 'rounded',
        }
    },
    dataLabels: {
        enabled: false
    },
    fill: {
        type: 'gradient',
        colors: ['#487FFF'], // Set the starting color (top color) here
        gradient: {
            shade: 'light', // Gradient shading type
            type: 'vertical',  // Gradient direction (vertical)
            shadeIntensity: 0.5, // Intensity of the gradient shading
            gradientToColors: ['#487FFF'], // Bottom gradient color (with transparency)
            inverseColors: false, // Do not invert colors
            opacityFrom: 1, // Starting opacity
            opacityTo: 1,  // Ending opacity
            stops: [0, 100],
        },
    },
    grid: {
        show: true,
        borderColor: '#D1D5DB',
        strokeDashArray: 4, // Use a number for dashed style
        position: 'back',
    },
    xaxis: {
        type: 'category',
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des']
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return (value / 1000).toFixed(0) + 'k';
            }
        }
    },
    tooltip: {
        y: {
            formatter: function (value) {
                return value / 1000 + 'k';
            }
        }
    }
  };

  var chart = new ApexCharts(document.querySelector("#barChart"), options);
  chart.render();
</script>
@endsection