@extends('layouts.app')

@section('content')
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-warning text-center">
                <div class="panel-body">
                    <i class="fa fa-exchange fa-2x"></i>
                    <h4>Buku Dipinjam</h4>
                    <h2>{{ $borrowedBooks }}</h2>
                </div>
            </div>
        </div>


        <div class="col-md-12">

            <div class="panel panel-default">

                <div class="panel-heading">
                    <i class="fa fa-bookmark"></i> Daftar Pinjaman Buku Anda
                </div>


                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-hover" id="my-loans-table" width="100%">

                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Judul Buku</th>
                                    <th>Author</th>
                                    <th width="60">Qty</th>
                                    <th width="120">Tgl Pinjam</th>
                                    <th width="120">Tgl Kembali</th>
                                    <th width="100">Status</th>
                                    <th width="100">Action</th>
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
        $(document).ready(function() {

            var table = $('#my-loans-table').DataTable({

                processing: true,
                serverSide: true,

                ajax: "{{ url('user/books/my-loans/datatable') }}",

                columns: [

                    {
                        data: 'loan_id',
                        name: 'loans.id',
                        orderable: false,
                        searchable: false
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
                        data: 'qty',
                        name: 'loan_details.qty'
                    },

                    {
                        data: 'loan_date',
                        name: 'loans.loan_date'
                    },

                    {
                        data: 'return_date',
                        name: 'loans.return_date'
                    },

                    {
                        data: 'status_label',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }

                ]

            });


            /* RETURN BOOK */

            $(document).on('click', '.btn-return', function() {

                var id = $(this).data('id');

                Swal.fire({

                    title: 'Kembalikan Buku?',
                    text: "Buku akan dikembalikan ke perpustakaan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, kembalikan!',
                    cancelButtonText: 'Batal'

                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({

                            url: "{{ url('user/books/return') }}/" + id,
                            type: "POST",

                            data: {
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },

                            success: function(res) {

                                table.ajax.reload(null, false);

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Buku berhasil dikembalikan',
                                    timer: 1500,
                                    showConfirmButton: false
                                });

                            },

                            error: function() {

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan saat mengembalikan buku'
                                });

                            }

                        });

                    }

                });

            });

        });
    </script>
@endsection
