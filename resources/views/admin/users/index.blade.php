@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>List Users</h3>

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
@endsection

@section('scripts')
    <script>
        $(function() {

            $('#users-table').DataTable({
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
                    }
                ]
            });

        });
    </script>
@endsection
