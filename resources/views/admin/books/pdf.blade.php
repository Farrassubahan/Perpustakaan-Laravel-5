<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Buku - Corporate Style</title>

    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #1e293b;
            line-height: 1.4;
        }

        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header table {
            width: 100%;
            border: none;
        }

        .brand-name {
            font-size: 18px;
            font-weight: bold;
            color: #1e293b;
            margin: 0;
        }

        .report-title {
            font-size: 14px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 5px 0 0 0;
        }

        .meta-info {
            text-align: right;
            font-size: 10px;
            color: #64748b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table thead th {
            background: #f8fafc;
            color: #1e293b;
            border: 1px solid #cbd5e1;
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
        }

        table tbody td {
            border: 1px solid #cbd5e1;
            padding: 8px;
            color: #334155;
        }

        table tbody tr:nth-child(even) {
            background-color: #f1f5f9;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            border-top: 1px solid #cbd5e1;
            padding-top: 5px;
            font-size: 9px;
            color: #9403b8;
        }
    </style>
</head>

<body>

    <div class="header">
        <table>
            <tr>
                <td>
                    <h1 class="brand-name">L-FARPUS LIBRARY</h1>
                    <h2 class="report-title">LAPORAN DATA KOLEKSI BUKU</h2>
                </td>
                <td class="meta-info">
                    <strong>Tanggal Cetak:</strong> {{ date('d F Y') }}<br>
                    <strong>Waktu:</strong> {{ date('H:i') }}
                </td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="30">NO</th>
                <th>JUDUL BUKU</th>
                <th>PENULIS</th>
                <th class="text-center" width="50">TAHUN</th>
                <th>PENERBIT</th>
            </tr>
        </thead>

        <tbody>
            @php $no = 1; @endphp
            @foreach ($data as $buku)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td><strong>{{ $buku->title }}</strong></td>
                    <td>{{ $buku->author }}</td>
                    <td class="text-center">{{ $buku->release_year }}</td>
                    <td>{{ $buku->publisher }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <table>
            <tr>
                <td>Sistem Manajemen Perpustakaan &copy; {{ date('Y') }}</td>
                <td class="text-right">Dokumen ini dihasilkan secara otomatis oleh sistem.</td>
            </tr>
        </table>
    </div>

</body>

</html>

