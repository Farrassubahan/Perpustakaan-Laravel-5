@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">

            <div class="hero-card shadow-sm mb-5">
                <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p>Temukan dan pinjam koleksi buku terbaik kami secara online dengan mudah.</p>
            </div>

            <div class="row mb-4">

                <div class="col-md-4">
                    <div class="panel panel-info text-center">
                        <div class="panel-body">
                            <i class="fa fa-book fa-2x"></i>
                            <h4>Total Judul Buku</h4>
                            <h2>{{ $totalBooks }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-success text-center">
                        <div class="panel-body">
                            <i class="fa fa-archive fa-2x"></i>
                            <h4>Total Stok Buku</h4>
                            <h2>{{ $totalStock }}</h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-warning text-center">
                        <div class="panel-body">
                            <i class="fa fa-exchange fa-2x"></i>
                            <h4>Buku Dipinjam</h4>
                            <h2>{{ $borrowedBooks }}</h2>
                        </div>
                    </div>
                </div>

            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-list-alt"></i> Daftar Koleksi Buku
                </div>

                <div class="panel-body" style="padding-top: 10px; padding-bottom: 0;">
                    <button id="openModalBooks" class="btn btn-primary"
                        style="margin-bottom: 15px; box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);">
                        <i class="fa fa-search"></i> Cari & Lihat Koleksi Buku
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" id="books-table" width="100%">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th>Kategori</th>
                                <th>Judul</th>
                                <th>Author</th>
                                <th>Publisher</th>
                                <th>Tahun</th>
                                <th>Stock</th>
                                <th width="100">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
    </div>


    @include('modals._modals-buku')
    @include('modals.book-detail')
    @include('modals.loan-form')
@endsection


@section('scripts')
    <script>
        $(document).ready(function() {

            /* DATA TABLE */
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('user/home/datatable') }}",
                columns: [{
                        data: 'id',
                        name: 'books.id'
                    },
                    {
                        data: 'category',
                        name: 'categories.name'
                    },
                    {
                        data: 'title',
                        name: 'books.title'
                    },
                    {
                        data: 'author',
                        name: 'books.author'
                    },
                    {
                        data: 'publisher',
                        name: 'books.publisher'
                    },
                    {
                        data: 'release_year',
                        name: 'books.release_year'
                    },
                    {
                        data: 'stock',
                        name: 'books.stock'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            /* DETAIL MODAL */
            $(document).on('click', '.btn-detail', function() {

                var id = $(this).data('id');

                $.ajax({
                    url: "{{ url('user/home/books/detail') }}/" + id,
                    type: "GET",
                    dataType: "json",

                    success: function(data) {

                        $('#detail_category').text(data.category);
                        $('#detail_title').text(data.title);
                        $('#detail_author').text(data.author);
                        $('#detail_publisher').text(data.publisher);
                        $('#detail_year').text(data.release_year);
                        $('#detail_stock').text(data.stock);

                        $('#loan_book_id').val(data.id);
                        $('#loan_book_title').val(data.title);

                        $('#modalDetail').modal('show');

                    },

                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }

                });

            });


            // modal pinjaman buku
            $('#btnOpenLoanModal').click(function() {

                $('#modalDetail').modal('hide');

                let today = new Date();
                today.setDate(today.getDate() + 7);

                $('#return_date').val(
                    today.toISOString().split('T')[0]
                );


                setTimeout(function() {
                    $('#modalLoan').modal('show');
                }, 300);

            });

            // submit peminjaman buku
            $('#btnSubmitLoan').click(function() {

                var book_id = $('#loan_book_id').val();
                var qty = $('#loan_qty').val();
                var return_date = $('#return_date').val();


                if (qty > 5) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Batas Maksimal',
                        text: 'Maksimal peminjaman buku adalah 5.'
                    });

                    return;
                }

                if (qty < 1) {

                    Swal.fire({
                        icon: 'warning',
                        title: 'Jumlah tidak valid',
                        text: 'Minimal peminjaman adalah 1 buku.'
                    });

                    return;
                }

                $.ajax({

                    url: "{{ url('user/home/loans/store') }}",
                    type: "POST",

                    data: {
                        book_id: book_id,
                        qty: qty,
                        return_date: return_date,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(res) {

                        $('#modalLoan').modal('hide');

                        // reload datatable jika perlu
                        $('#books-table').DataTable().ajax.reload(null, false);

                        // SWEET ALERT SUCCESS
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Peminjaman buku berhasil diajukan',
                            timer: 1500,
                            showConfirmButton: false
                        });

                    },

                    error: function(xhr) {

                        let res = xhr.responseJSON;

                        Swal.fire({
                            icon: 'warning',
                            title: 'Tidak Bisa Meminjam',
                            text: res.message
                        });

                    }

                });

            });


            $(document).ready(function() {

                let tableBooks = null;

                function initTable() {
                    tableBooks = $('#tableBooks').DataTable({
                        processing: true,
                        serverSide: true,
                        searching: true,
                        ajax: function(data, callback, settings) {

                            let keyword = data.search.value;

                            if (!keyword || keyword.length < 1) {
                                callback({
                                    data: [],
                                    recordsTotal: 0,
                                    recordsFiltered: 0
                                });
                                return;
                            }

                            $.ajax({
                                url: '/user/home/datatable',
                                type: 'GET',
                                data: data,
                                success: function(res) {
                                    callback(res);
                                }
                            });
                        },
                        columns: [{
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row, meta) {
                                    return meta.row + 1;
                                }
                            },
                            {
                                data: 'title',
                                name: 'books.title'
                            },
                            {
                                data: 'author',
                                name: 'books.author'
                            },
                            {
                                data: 'category',
                                name: 'categories.name'
                            },
                            {
                                data: 'id',
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    return `
                <button class="btn-detail" data-id="${data}" data-title="${row.title}" data-author="${row.author}" data-category="${row.category}">
                    Detail
                </button>
            `;
                                }
                            }
                        ]
                    });
                }

                $('#openModalBooks').on('click', function() {
                    $('#modalBooks').modal('show');

                    if (tableBooks === null) {
                        initTable();
                    }
                });

                $('#closeModalBooks').on('click', function() {
                    $('#modalBooks').hide();
                });

            });

        });
    </script>
@endsection
