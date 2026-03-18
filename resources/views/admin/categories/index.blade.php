@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="display: flex; justify-content: space-between; align-items: center;">
                    <span><i class="fa fa-tags"></i> Manajemen Kategori Buku</span>
                    <button class="btn btn-primary" id="btn-add">
                        <i class="fa fa-plus"></i> Tambah Kategori
                    </button>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="categories-table">
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

    <div class="modal fade" id="modal-category" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 8px 8px 0 0;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="modal-title" style="font-weight: 700; color: #1e293b;">Tambah Kategori</h4>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <form id="form-category">
                        <input type="hidden" id="category_id">
                        <div class="form-group">
                            <label style="font-weight: 600; color: #475569;">Nama Kategori</label>
                            <input type="text" class="form-control" id="name"
                                placeholder="Contoh: Sains, Novel, dll" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" style="background: #f8fafc; border-radius: 0 0 8px 8px;">
                    <button class="btn btn-primary btn-block" id="btn-save">
                        <i class="fa fa-save"></i> Simpan Kategori
                    </button>
                    <button class="btn btn-link btn-block" data-dismiss="modal" style="color: #64748b;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(function() {
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

            $('#btn-add').click(function() {
                $('#form-category')[0].reset();
                $('#category_id').val('');
                $('#modal-title').text('Tambah Kategori');
                $('#modal-category').modal('show');
            });

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

            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');
                $.get("{{ url('admin/categories') }}/" + id, function(data) {
                    $('#modal-title').text('Edit Kategori');
                    $('#category_id').val(data.id);
                    $('#name').val(data.name);
                    $('#modal-category').modal('show');
                });
            });

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
