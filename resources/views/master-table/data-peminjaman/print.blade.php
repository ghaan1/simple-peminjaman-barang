<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Barang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <center>
        <h1>Peminjaman Barang</h1>
    </center>
    <br>
    <p>Pemberitahuan Warga Barang yang masuk dalam list data peminjaman : </p>
    <br>

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
                <th>Tanggal Kembali</th>
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
                    <td>{{ $itemPeminjaman->tanggal_kembali }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <p>Mohon agar peminjam dapat menjaga barang yang dipinjam dan mengembalikannya tepat waktu.</p>
    <p>Terima kasih.</p>
    </br>
    <p>{{ $users->name }}</p>
</body>

</html>
