<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang Perbaikan</title>
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
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <center>
        <h1>Data Barang Perbaikang</h1>
    </center>
    <br>
    <p>Pemberitahuan untuk Barang Perbaikan yang masuk dalam list data perbaikan : </p>
    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Perbaikan</th>
                <th>Nama User</th>
                <th>Nama Barang</th>
                <th>Status</th>
                <th>Quantity Diperbaiki</th>
                <th>Bukti Perbaikan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataPerbaikan as $key => $itemPerbaikan)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $itemPerbaikan->tanggal_perbaikan }}</td>
                    <td>{{ $itemPerbaikan->name }}</td>
                    <td>{{ $itemPerbaikan->nama_barang }}</td>
                    <td>{{ $itemPerbaikan->status_rusak }}</td>
                    <td>{{ $itemPerbaikan->quantity_rusak }}</td>
                    <td>{{ $itemPerbaikan->bukti_perbaikan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <p>Mohon agar peminjam dapat menjaga barang yang dipinjam dan memperbaiki tepat waktu.</p>
    <p>Terima kasih.</p>
    </br>
    <p>{{ $users->name }}</p>
</body>

</html>
