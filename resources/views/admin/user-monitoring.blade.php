@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Monitoring User Login</h3>
        <hr>

        <table class="table table-bordered table-striped" id="user-monitoring-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Last Login</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {

            $('#user-monitoring-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.user.monitoring.data') }}",

                columns: [{
                        data: 'DT_Row_Index',
                        orderable: false,
                        searchable: false
                    },

                    {
                        data: 'name'
                    },

                    {
                        data: 'email'
                    },

                    {
                        data: 'last_login_at',
                        orderable: false,
                        render: function(data) {
                            if (!data || data === 'Belum login') {
                                return '<span class="text-muted">Belum login</span>';
                            }
                            return data;
                        }
                    },

                    {
                        data: 'status',
                        orderable: false,
                        searchable: false,
                        render: function(data) {
                            if (data === 'online') {
                                return '<span class="badge badge-success">Online</span>';
                            }
                            return '<span class="badge badge-secondary">Offline</span>';
                        }
                    }
                ]
            });

        });
    </script>
@endsection
