@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Kelola Buku</h3>
        <button class="btn btn-primary" id="btn-add">Tambah Buku</button>
        <br><br>

        <table class="table table-bordered" id="books-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Judul</th>
                    <th>Author</th>
                    <th>Kategori</th>
                    <th>Publisher</th>
                    <th>Tahun</th>
                    <th>Stock</th>
                    <th width="150">Action</th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- MODAL FORM --}}
    <div class="modal fade" id="modal-book">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title">Tambah Buku</h4>
                </div>
                <div class="modal-body">
                    <form id="form-book">
                        <input type="hidden" id="book_id">

                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control" id="category_id">
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" id="title">
                        </div>

                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" class="form-control" id="author">
                        </div>

                        <div class="form-group">
                            <label>Publisher</label>
                            <input type="text" class="form-control" id="publisher">
                        </div>

                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" class="form-control" id="release_year">
                        </div>

                        <div class="form-group">
                            <label>Stock</label>
                            <input type="number" class="form-control" id="stock">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btn-save">Simpan</button>
                    <button class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {
            // 1. Inisialisasi DataTable
            var table = $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.books.datatable') }}",
                columns: [
                    { data: 'DT_Row_Index', name: 'DT_Row_Index', orderable: false, searchable: false },
                    { data: 'title', name: 'books.title' },
                    { data: 'author', name: 'books.author' },
                    { data: 'category', name: 'categories.name' },
                    { data: 'publisher', name: 'books.publisher' },
                    { data: 'release_year', name: 'books.release_year' },
                    { data: 'stock', name: 'books.stock' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // 2. Tombol Tambah (Reset Form & Buka Modal)
            $('#btn-add').click(function() {
                $('#form-book')[0].reset();
                $('#book_id').val('');
                $('#modal-title').text('Tambah Buku');
                $('#modal-book').modal('show');
            });

            // 3. Simpan (Store atau Update)
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

                        // NOTIFIKASI SUKSES
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        // NOTIFIKASI ERROR
                        Swal.fire({
                            icon: 'error',
                            title: 'Waduh...',
                            text: 'Terjadi kesalahan sistem saat menyimpan data.',
                        });
                    }
                });
            });

            // 4. Tombol Edit (Ambil Data ke Modal)
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

            // 5. Tombol Delete (Konfirmasi SweetAlert)
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
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                table.ajax.reload();
                                Swal.fire(
                                    'Terhapus!',
                                    res.message,
                                    'success'
                                );
                            },
                            error: function() {
                                Swal.fire('Error', 'Gagal menghapus data.', 'error');
                            }
                        });
                    }
                });
            });
        }); // Penutup function utama
    </script>
@endsection
