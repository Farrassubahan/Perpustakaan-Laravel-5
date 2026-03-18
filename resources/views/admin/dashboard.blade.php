@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Dashboard Data Buku</h3>


        <div class="row mb-4">
            <div class="col-md-6">
                <div style="height:300px;">
                    <canvas id="booksChart"></canvas>
                </div>
            </div>

            <div class="col-md-3">
                <div style="height:300px;">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <div class="col-md-3">
                <div style="height:300px;">
                    <canvas id="userChart"></canvas>
                </div>
            </div>
        </div>

        <hr>





        <table class="table table-bordered table-striped" id="books-table">
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
@endsection
@section('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <script>
        $(function() {

            // 🔥 DATATABLE
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

            //FETCH DATA
            fetch('/admin/dashboard/chart-data')
                .then(res => res.json())
                .then(res => {


                    new Chart(document.getElementById('booksChart'), {
                        type: 'bar',
                        data: {
                            labels: res.books_per_category.map(i => i.name),
                            datasets: [{
                                label: 'Books per Category',
                                data: res.books_per_category.map(i => i.total),

                                // 🔥 WARNA WARNA (AUTO LOOP)
                                backgroundColor: [
                                    '#4e73df',
                                    '#1cc88a',
                                    '#36b9cc',
                                    '#f6c23e',
                                    '#e74a3b',
                                    '#858796'
                                ],

                               
                                borderRadius: 10, 
                                borderSkipped: false,
                                barThickness: 30
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,

                            plugins: {
                                legend: {
                                    display: false
                                }
                            },

                            scales: {
                                x: {
                                    grid: {
                                        display: false
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#eee'
                                    }
                                }
                            }
                        }
                    });

                    new Chart(document.getElementById('categoryChart'), {
                        type: 'polarArea',
                        data: {
                            labels: res.books_per_category.map(i => i.name),
                            datasets: [{
                                data: res.books_per_category.map(i => i.total),
                                backgroundColor: [
                                    '#1cc88a',
                                    '#36b9cc',
                                    '#f6c23e',
                                    '#e74a3b',
                                    '#858796'
                                ]
                            }]
                        },
                        options: {
                            maintainAspectRatio: false
                        }
                    });


                    new Chart(document.getElementById('userChart'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Users', 'Books', 'Categories'],
                            datasets: [{
                                data: [
                                    res.summary.users,
                                    res.summary.books,
                                    res.summary.categories
                                ],
                                backgroundColor: [
                                    '#6f42c1',
                                    '#20c997',
                                    '#fd7e14'
                                ]
                            }]
                        },
                        options: {
                            maintainAspectRatio: false
                        }
                    });

                });

        });
    </script>
@endsection
