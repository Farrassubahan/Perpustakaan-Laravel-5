@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">

                    <div class="panel-heading">
                        Dashboard
                    </div>

                    <div class="panel-body">

                        <div class="mb-3">
                            <h4>Selamat Datang, {{ Auth::user()->name }}!</h4>
                            <p>Ini adalah halaman dashboard untuk pengguna biasa.</p>
                        </div>

                        <table class="table table-bordered" id="books-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">ID</th>
                                    <th>Kategori</th>
                                    <th>Judul</th>
                                    <th>Author</th>
                                    <th>Publisher</th>
                                    <th>Tahun</th>
                                    <th>Stock</th>
                                    <th width="120">Action</th>
                                </tr>
                            </thead>
                        </table>

                    </div>

                </div>

            </div>
        </div>
    </div>


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

                        Swal.fire({
                            icon: 'error',
                            title: 'Waduh...',
                            text: 'Terjadi kesalahan saat memproses peminjaman.'
                        });

                        console.log(xhr.responseText);

                    }

                });

            });

        });
    </script>
@endsection
