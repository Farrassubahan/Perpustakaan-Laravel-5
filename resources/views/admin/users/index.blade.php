@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>List Users</h3>

        <button class="btn btn-primary mb-3" id="btnCreateUser">
            Tambah User
        </button>

        <table class="table table-bordered" id="users-table">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
        </table>

    </div>

    @include('admin.users.modal')
@endsection

@section('scripts')
    <script>
        $(function() {

            var table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.users.data-user') }}",
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
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'role',
                        name: 'roles.display_name'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


            $('#btnCreateUser').click(function() {

                $('#userForm')[0].reset();

                $('#user_id').val('');
                $('#userModalLabel').text('Tambah User');

                $('#userModal').modal('show');

            });


            $('body').on('click', '.btn-edit', function() {

                var id = $(this).data('id');

                $.get("/admin/users/" + id + "/edit", function(data) {

                    $('#userModal').modal('show');

                    $('#userModalLabel').text('Edit User');

                    $('#user_id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#role_id').val(data.role_id);

                    $('#password').val('');

                });

            });


            $('#userForm').submit(function(e) {

                e.preventDefault();

                var id = $('#user_id').val();
                var url = id ? "/admin/users/" + id + "/update" : "{{ route('admin.users.store') }}";

                $.ajax({
                    url: url,
                    type: "POST",
                    data: $(this).serialize(),

                    success: function() {

                        $('#userModal').modal('hide');

                        table.ajax.reload();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data user berhasil disimpan',
                            timer: 2000,
                            showConfirmButton: false
                        });

                    },

                    error: function() {

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan'
                        });

                    }

                });

            });


            // delete user
            $('body').on('click', '.btn-delete', function() {

                var id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin hapus user?',
                    text: "Data tidak bisa dikembalikan",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {

                    if (result.isConfirmed) {

                        $.ajax({
                            url: "/admin/users/" + id,
                            type: "POST",
                            data: {
                                _method: "DELETE",
                                _token: "{{ csrf_token() }}"
                            },

                            success: function(response) {

                                if (response.success) {

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message,
                                        timer: 2000,
                                        showConfirmButton: false
                                    });

                                    table.ajax.reload();

                                } else {

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message
                                    });

                                }

                            },

                            error: function(xhr) {

                                if (xhr.status === 500) {

                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Akses ditolak',
                                        text: 'Anda tidak memiliki akses untuk menghapus user'
                                    });

                                } else {

                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: 'Terjadi kesalahan saat menghapus data'
                                    });

                                }

                            }

                        });

                    }

                });

            });

            // buat nambah role dinamis
            $('#addRole').click(function() {

                var roleSelect = `
                    <div class="role-item mb-2 d-flex">
                        <select name="role_id[]" class="form-control mr-2">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="button" class="btn btn-danger btn-remove-role">
                            x
                        </button>
                    </div>
                `;

                $('#roles-wrapper').append(roleSelect);

            });


            $('body').on('click', '.btn-remove-role', function() {

                $(this).closest('.role-item').remove();

            });


        });
    </script>
@endsection
