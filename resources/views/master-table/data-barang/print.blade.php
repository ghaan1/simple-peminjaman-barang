<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
        border: 1px solid black;
    }

    th, td {
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
        <h1>Data Barang</h1>
    </center>
    <br>
    <p>Data Barang yang baru masuk kedalam list yaitu : </p>
    <br>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penginputan Data</th>
                <th>Jenis Barang</th>
                <th>Nama Barang</th>
                <th>Harga Barang</th>
                <th>Jumlah </th>
                <th>Tersediaan / Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataBarangs as $key => $itemBarang)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $itemBarang->name }}</td>
                    <td>{{ $itemBarang->jenis_barang }}</td>
                    <td>{{ $itemBarang->nama_barang }}</td>
                    <td>{{ $itemBarang->harga_barang }}</td>
                    <td>{{ $itemBarang->quantity }}</td>
                    <td>{{ $itemBarang->tersedia }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <p>Mohon agar data barang selalu update pada saat mengeprint dikarenakan penanggungjawaban para user inputan </p>
    <p>Terima kasih.</p>
</br>
    <p>{{$users->name}}</p>
</body>
</html>


