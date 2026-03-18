@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                    <span><i class="fa fa-book"></i> Katalog Koleksi Buku</span>
                    <div class="btn-group">
                        <button class="btn btn-primary" id="btn-add">
                            <i class="fa fa-plus"></i> Tambah Buku
                        </button>
                        <button class="btn btn-info shadow-sm" data-toggle="modal" data-target="#importModal">
                            <i class="fa fa-upload"></i> Import
                        </button>
                        <a href="{{ route('admin.buku.export.excel') }}" class="btn btn-success shadow-sm">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <a href="{{ route('admin.buku.export.pdf') }}" class="btn btn-danger shadow-sm">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="books-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul Buku</th>
                                    <th>Penulis</th>
                                    <th>Kategori</th>
                                    <th>Penerbit</th>
                                    <th>Tahun</th>
                                    <th>Stok</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal-book" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 8px 8px 0 0;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title" style="font-weight: 700; color: #1e293b;">
                        <i class="fa fa-book"></i> Form Data Buku
                    </h4>
                </div>
                <div class="modal-body" style="padding: 25px;">
                    <form id="form-book">
                        <input type="hidden" id="book_id">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label style="font-weight: 600; color: #475569;">Judul Buku</label>
                                    <input type="text" class="form-control" id="title" placeholder="Masukkan judul buku...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label style="font-weight: 600; color: #475569;">Kategori</label>
                                    <select class="form-control" id="category_id">
                                        @foreach ($categories as $c)
                                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label style="font-weight: 600; color: #475569;">Penulis / Author</label>
                                    <input type="text" class="form-control" id="author" placeholder="Nama penulis...">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label style="font-weight: 600; color: #475569;">Penerbit / Publisher</label>
                                    <input type="text" class="form-control" id="publisher" placeholder="Nama penerbit...">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label style="font-weight: 600; color: #475569;">Tahun Terbit</label>
                                    <input type="number" class="form-control" id="release_year" placeholder="YYYY">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label style="font-weight: 600; color: #475569;">Jumlah Stok</label>
                                    <input type="number" class="form-control" id="stock" placeholder="0">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-radius: 0 0 8px 8px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" id="btn-save" style="min-width: 120px;">
                        <i class="fa fa-save"></i> Simpan Data
                    </button>
                </div>
            </div>
        </div>
    </div>


    @include('admin.books.modal-excel')
@endsection

@section('scripts')
    <script>
        $(function() {
            var table = $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.datatable') }}",
                columns: [{
                        data: 'DT_Row_Index',
                        name: 'DT_Row_Index',
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
                        data: 'category',
                        name: 'categories.name'
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

            $('#btn-add').click(function() {
                $('#form-book')[0].reset();
                $('#book_id').val('');
                $('#modal-title').text('Tambah Buku');
                $('#modal-book').modal('show');
            });

            $('#btn-save').click(function() {
                var id = $('#book_id').val();
                var url = id ? "{{ url('admin/books/update') }}/" + id : "{{ route('admin.books.store') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        category_id: $('#category_id').val(),
                        title: $('#title').val(),
                        author: $('#author').val(),
                        publisher: $('#publisher').val(),
                        release_year: $('#release_year').val(),
                        stock: $('#stock').val()
                    },
                    success: function(res) {
                        $('#modal-book').modal('hide');
                        table.ajax.reload();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let res = xhr.responseJSON;
                        Swal.fire(
                            'Tidak Bisa Mengubah!',
                            res.message,
                            'warning'
                        );
                    }
                });
            });

            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/books') }}/" + id, function(data) {
                    $('#modal-title').text('Edit Buku');
                    $('#book_id').val(data.id);
                    $('#category_id').val(data.category_id);
                    $('#title').val(data.title);
                    $('#author').val(data.author);
                    $('#publisher').val(data.publisher);
                    $('#release_year').val(data.release_year);
                    $('#stock').val(data.stock);
                    $('#modal-book').modal('show');
                });
            });

            $('body').on('click', '.delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data buku ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/books/delete') }}/" + id,
                            type: "DELETE",
                            dataType: "json",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                if (!res.status) {
                                    Swal.fire(
                                        'Tidak Bisa Menghapus!',
                                        res.message,
                                        'warning'
                                    );
                                    return;
                                }
                                table.ajax.reload();
                                Swal.fire(
                                    'Terhapus!',
                                    res.message,
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error',
                                    'Terjadi kesalahan sistem.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
