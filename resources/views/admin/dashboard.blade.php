@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h3 class="page-header" style="margin-top: 0; border-bottom: 2px solid #edf2f7; padding-bottom: 10px;">
                <i class="fa fa-dashboard"></i> Dashboard Ringkasan Data
            </h3>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #eff6ff; color: #2563eb;">
                    <i class="fa fa-users"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Users</div>
                    <div class="stat-value" id="count-users">-</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #f0fdf4; color: #16a34a;">
                    <i class="fa fa-book"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Total Buku</div>
                    <div class="stat-value" id="count-books">-</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon" style="background: #fff7ed; color: #ea580c;">
                    <i class="fa fa-tags"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-label">Kategori</div>
                    <div class="stat-value" id="count-categories">-</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart"></i> Grafik Buku per Kategori
                </div>
                <div class="panel-body">
                    <div style="height:350px;">
                        <canvas id="booksChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-pie-chart"></i> Distribusi Kategori
                </div>
                <div class="panel-body">
                    <div style="height:350px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list"></i> Daftar Buku Terbaru
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="books-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul</th>
                                    <th>Author</th>
                                    <th>Kategori</th>
                                    <th>Publisher</th>
                                    <th>Tahun</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.dashboard.data') }}",
                columns: [{
                        data: 'DT_Row_Index',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'author'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'publisher'
                    },
                    {
                        data: 'release_year'
                    },
                    {
                        data: 'stock'
                    }
                ]
            });

            fetch('/admin/dashboard/chart-data')
                .then(res => res.json())
                .then(res => {
                    $('#count-users').text(res.summary.users);
                    $('#count-books').text(res.summary.books);
                    $('#count-categories').text(res.summary.categories);

                    new Chart(document.getElementById('booksChart'), {
                        type: 'bar',
                        data: {
                            labels: res.books_per_category.map(i => i.name),
                            datasets: [{
                                label: 'Buku',
                                data: res.books_per_category.map(i => i.total),
                                backgroundColor: [
                                    '#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'
                                ],
                                borderRadius: 4,
                                barThickness: 25
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                x: { grid: { display: false } },
                                y: { beginAtZero: true, grid: { color: '#f1f5f9' } }
                            }
                        }
                    });

                    new Chart(document.getElementById('categoryChart'), {
                        type: 'doughnut',
                        data: {
                            labels: res.books_per_category.map(i => i.name),
                            datasets: [{
                                data: res.books_per_category.map(i => i.total),
                                backgroundColor: [
                                    '#4f46e5', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#06b6d4'
                                ],
                                borderWidth: 3,
                                borderColor: '#ffffff'
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        padding: 20,
                                        font: { size: 11 }
                                    }
                                }
                            },
                            cutout: '70%'
                        }
                    });
                });
        });
    </script>
@endsection
