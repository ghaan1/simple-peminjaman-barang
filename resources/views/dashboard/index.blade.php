@extends('layouts.app')
@section('content')
    <section class="section">
        @role('admin-kelurahan|admin-rt')
            <div class="row">
                <div class="col-6 col-md-6 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Barang</h4>
                            </div>
                            <div class="card-body">
                                <h4>{{ $countBarang }}</h4>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-6 col-md-6 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="far fa-user"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Peminjaman</h4>
                            </div>
                            <div class="card-body">
                                <h4>{{ $countPeminjaman }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jumlah Barang</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jumlah Peminjaman Per-Warga</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Status Barang</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartTotal"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endrole
        @role('warga-rt|warga')
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Peminjaman Per-Warga</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="chartPeminjaman"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        @endrole

    </section>
@endsection
@push('customStyle')
    <link rel="stylesheet" href="/assets/css/select2.min.css">
@endpush
@push('customScript')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        var ctx = document.getElementById('myChart').getContext('2d');
        var chartData = {!! json_encode($chartData) !!};
        var uniqueNames = Array.from(new Set(chartData.map(data => data.name)));
        var uniqueBarang = Array.from(new Set(chartData.map(data => data.nama_barang)));
        var datasets = [];

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
        uniqueNames.forEach((name) => {
            var quantities = [];

            uniqueBarang.forEach((barang) => {
                var adminData = chartData.filter(data => data.name === name && data.nama_barang === barang);
                var totalQuantity = adminData.reduce((sum, data) => sum + data.quantity, 0);
                quantities.push(totalQuantity);
            });

            var randomColor = getRandomColor();
            console.log(quantities);
            datasets.push({
                label: name,
                backgroundColor: randomColor,
                borderWidth: 1,
                data: quantities,
            });
        });

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: uniqueBarang,
                datasets: datasets,
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    },
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Quantity: ' + context.parsed.y;
                            }
                        }
                    }
                }
            },
        });
    </script>
    <script>
        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var chartData2 = {!! json_encode($chartData2) !!};
        var uniqueUsers = Array.from(new Set(chartData2.map(data => data.user_name)));
        var totalPeminjaman = chartData2.map(data => data.total_peminjaman);
        var datasets1 = [];
        var totalPeminjamanByUser = {};

        chartData2.forEach((data) => {
            if (!totalPeminjamanByUser[data.user_name]) {
                totalPeminjamanByUser[data.user_name] = new Array(chartData2.length).fill(0);
            }
            var index = uniqueUsers.indexOf(data.user_name);
            totalPeminjamanByUser[data.user_name][index] = data.total_peminjaman;
        });


        uniqueUsers.forEach((user_name) => {
            var randomColor = getRandomColor();
            var totalPeminjamanValue = totalPeminjamanByUser[user_name];
            console.log(totalPeminjamanValue)
            datasets1.push({
                label: user_name,
                backgroundColor: randomColor,
                borderWidth: 1,
                data: totalPeminjamanValue,
            });
        });

        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: uniqueUsers,
                datasets: datasets1,
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true,
                    },
                    y: {
                        stacked: true,
                    },
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Total: ' + context.parsed.y;
                            },
                        },
                    },
                },
            },
        });
    </script>
    <script>
        var peminjamanBarang = {!! json_encode($peminjamanBarang) !!};

        var namaBarang = peminjamanBarang.map(function(item) {
            return item.nama_barang;
        });

        var jumlahPeminjaman = peminjamanBarang.map(function(item) {
            return item.quantity;
        });

        var randomColors = [];
        for (var i = 0; i < peminjamanBarang.length; i++) {
            var color = getRandomColor();
            randomColors.push(color);
        }

        var ctx = document.getElementById('chartPeminjaman').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: namaBarang,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: jumlahPeminjaman,
                    backgroundColor: randomColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.label || '';
                                var value = context.parsed.y || 0;
                                return label + ': ' + value;
                            }
                        }
                    }
                }
            }
        });

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
            var color = '#';
            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }
    </script>
    <script>
        // Data total barang, total rusak, dan total perbaikan
        var totalBarang = {!! json_encode($totalBarang[0]->total_barang) !!};
        var totalRusak = {!! json_encode($totalRusak[0]->total_rusak) !!};
        var totalPerbaikan = {!! json_encode($totalPerbaikan[0]->total_perbaikan) !!};
        var totalBaik = {!! json_encode($totalBaik[0]->total_baik) !!};

        // Menginisialisasi chart
        var ctx = document.getElementById('chartTotal').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Barang', 'Total Rusak', 'Total Perbaikan', 'Total Baik'],
                datasets: [{
                    label: 'Jumlah',
                    data: [totalBarang, totalRusak, totalPerbaikan, totalBaik],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(75, 192, 192, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var label = context.dataset.label || '';
                                var value = context.parsed.y || 0;
                                return label + ': ' + value;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush