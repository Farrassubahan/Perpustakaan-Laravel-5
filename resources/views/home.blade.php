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


    <!-- MODAL DETAIL -->
    <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal">
                        &times;
                    </button>

                    <h4 class="modal-title">Detail Buku</h4>

                </div>

                <div class="modal-body">

                    <table class="table table-bordered">

                        <tr>
                            <th width="150">Kategori</th>
                            <td id="detail_category"></td>
                        </tr>

                        <tr>
                            <th>Judul</th>
                            <td id="detail_title"></td>
                        </tr>

                        <tr>
                            <th>Author</th>
                            <td id="detail_author"></td>
                        </tr>

                        <tr>
                            <th>Publisher</th>
                            <td id="detail_publisher"></td>
                        </tr>

                        <tr>
                            <th>Tahun</th>
                            <td id="detail_year"></td>
                        </tr>

                        <tr>
                            <th>Stock</th>
                            <td id="detail_stock"></td>
                        </tr>

                    </table>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
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

                        $('#modalDetail').modal('show');

                    },

                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }

                });

            });

        });
    </script>
@endsection
