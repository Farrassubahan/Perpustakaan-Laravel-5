<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Buku</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            padding: 0;
        }

        .header p {
            margin: 2px;
            font-size: 11px;
        }

        .info {
            margin-bottom: 10px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead th {
            background: #f2f2f2;
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        table tbody td {
            border: 1px solid #000;
            padding: 6px;
        }

        .no {
            width: 40px;
            text-align: center;
        }

        .footer {
            margin-top: 20px;
            font-size: 11px;
        }

        .right {
            text-align: right;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Laporan Data Buku</h2>
        <p>Sistem Manajemen Perpustakaan</p>
    </div>

    <div class="info">
        <strong>Tanggal Cetak :</strong> {{ date('d-m-Y') }}
    </div>

    <table>
        <thead>
            <tr>
                <th class="no">No</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>Tahun</th>
                <th>Penerbit</th>
            </tr>
        </thead>

        <tbody>

            @php $no = 1; @endphp

            @foreach ($data as $buku)
                <tr>
                    <td class="no">{{ $no++ }}</td>
                    <td>{{ $buku->title }}</td>
                    <td>{{ $buku->author }}</td>
                    <td>{{ $buku->release_year }}</td>
                    <td>{{ $buku->publisher }}</td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <div class="footer right">
        Dicetak oleh sistem
    </div>

</body>

</html>
