<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Print Data Peminjaman</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        @media print {

            /* Hide non-printable elements */
            .card-header-action,
            .btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <h1>Data Peminjaman</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Peminjam</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Quantity</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $dataPeminjaman->id }}</td>
                <td>{{ $dataPeminjaman->name }}</td>
                <td>{{ $dataPeminjaman->jenis_barang }}</td>
                <td>{{ $dataPeminjaman->nama_barang }}</td>
                <td>{{ $dataPeminjaman->quantity }}</td>
                <td>{{ $dataPeminjaman->tanggal_pinjam }}</td>
                <td>{{ $dataPeminjaman->status }}</td>
            </tr>
        </tbody>
    </table>
    <script>
        window.print();
    </script>
</body>

</html>
