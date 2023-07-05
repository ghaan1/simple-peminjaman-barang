<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Cetak Data Peminjaman</title>
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
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Pemilik Barang</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Quantity</th>
                <th>Tanggal Pinjam</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataPeminjaman as $key => $itemPeminjaman)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $itemPeminjaman->name }}</td>
                    <td>{{ $itemPeminjaman->nama_petugas }}</td>
                    <td>{{ $itemPeminjaman->jenis_barang }}</td>
                    <td>{{ $itemPeminjaman->nama_barang }}</td>
                    <td>{{ $itemPeminjaman->quantity }}</td>
                    <td>{{ $itemPeminjaman->tanggal_pinjam }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        window.print();
    </script>
</body>

</html>
