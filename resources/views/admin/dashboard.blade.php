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
    <script>
        $(function() {
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

            $('#btn-add').click(function() {
                $('#form-book')[0].reset();
                $('#book_id').val('');
                $('#modal-title').text('Tambah Buku');
                $('#modal-book').modal('show');
            });

            $('#btn-save').click(function() {
                var id = $('#book_id').val();
                var url = id ? "/admin/books/update/" + id : "/admin/books/store";
                
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
                    success: function() {
                        $('#modal-book').modal('hide');
                        table.ajax.reload();
                    }
                });
            });

            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("/admin/books/" + id, function(data) {
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
                if (confirm("Hapus buku ini?")) {
                    $.ajax({
                        url: "/admin/books/delete/" + id,
                        type: "DELETE",
                        data: { _token: "{{ csrf_token() }}" },
                        success: function() {
                            table.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endsection