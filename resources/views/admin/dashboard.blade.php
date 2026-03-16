@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Dashboard Data Buku</h3>
        <hr>

   

   

        <table class="table table-bordered table-striped" id="books-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th>Judul</th>
                    <th>Author</th>
                    <th>Kategori</th>
                    <th>Publisher</th>
                    <th>Tahun</th>
                    <th>Stock</th>
                </tr>
            </thead>
        </table>


      

    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#books-table').DataTable({
                processing: true,
                serverSide: true,
                // Mengarah ke route data dashboard Anda
                ajax: "{{ route('admin.dashboard.data') }}",
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
                    }
                ]
            });
        });
    </script>
@endsection
