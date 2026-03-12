@extends('layouts.app')



@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Kelola Kategori</h3>
                <button class="btn btn-primary" id="btn-add">
                    <i class="fa fa-plus"></i> Tambah Kategori
                </button>
                <br><br>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-bordered table-striped" id="categories-table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama Kategori</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL FORM --}}
    <div class="modal fade" id="modal-category">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 id="modal-title">Tambah Kategori</h4>
                </div>
                <div class="modal-body">
                    <form id="form-category">
                        <input type="hidden" id="category_id">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" class="form-control" id="name"
                                placeholder="Masukkan nama kategori..." required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="btn-save">
                        <i class="fa fa-save"></i> Simpan
                    </button>
                    <button class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <script>
        $(function() {
            // 1. Inisialisasi DataTable
            var table = $('#categories-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.categories.datatable') }}",
                columns: [{
                        data: 'DT_Row_Index',
                        name: 'DT_Row_Index',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // 2. Tombol Tambah
            $('#btn-add').click(function() {
                $('#form-category')[0].reset();
                $('#category_id').val('');
                $('#modal-title').text('Tambah Kategori');
                $('#modal-category').modal('show');
            });

            // 3. Simpan & Update
            $('#btn-save').click(function() {
                var id = $('#category_id').val();
                var url = id ? "{{ url('admin/categories/update') }}/" + id :
                    "{{ route('admin.categories.store') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: $('#name').val()
                    },
                    success: function(res) {
                        $('#modal-category').modal('hide');
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menyimpan data.'
                        });
                    }
                });
            });

            // 4. Edit
            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/categories') }}/" + id, function(data) {
                    $('#modal-title').text('Edit Kategori');
                    $('#category_id').val(data.id);
                    $('#name').val(data.name);
                    $('#modal-category').modal('show');
                });
            });

            // 5. Delete dengan Konfirmasi SweetAlert
            $('body').on('click', '.delete', function() {
                var id = $(this).data('id');

                Swal.fire({
                    title: 'Hapus Kategori?',
                    text: "Data yang dihapus tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('admin/categories/delete') }}/" + id,
                            type: "DELETE",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(res) {
                                table.ajax.reload();
                                Swal.fire('Terhapus!', res.message, 'success');
                            },
                            error: function(xhr) {
                                // Menangani pesan error jika kategori masih dipakai oleh buku
                                var errorMsg = xhr.responseJSON ? xhr.responseJSON
                                    .message : 'Gagal menghapus data.';
                                Swal.fire('Gagal!', errorMsg, 'error');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
