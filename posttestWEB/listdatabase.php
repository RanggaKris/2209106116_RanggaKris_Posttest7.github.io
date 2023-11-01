<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Request Mobil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h3 {
            background-color: #fff;
            color: #f14e95;
            padding: 10px;
        }

        a.btn {
            display: inline-block;
            background-color: #a325dd;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a.btn:hover {
            background-color: #f14e95;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4b056b;
            color: #f14e95;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn.edit {
            background-color: #28a745;
        }

        .btn.edit:hover {
            background-color: #218838;
        }

        .btn.delete {
            background-color: #dc3545;
        }

        .btn.delete:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <h3>INI ADALAH LIST REQUEST MOBIL DARI USER</h3>
    <a href="Web2.php" class="btn">Kembali</a> 
    <table>
        <tr>
            <th>Model</th>
            <th>Harga</th>
            <th>Foto</th>
            <th>Action</th>
        </tr>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "db_mobil";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Koneksi database gagal: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM cars";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $row["model"] . '</td>';
                echo '<td>Rp ' . number_format($row["harga"], 0, ',', '.') . '</td>';
                echo '<td><img src="' . $row["photo_url"] . '" width="100" alt="Foto Mobil"></td>';
                echo '<td>';
                echo '<a href="edit_car.php?id=' . $row["id"] . '" class="btn edit">Edit</a>';
                echo '<a href="delete_car.php?id=' . $row["id"] . '" class="btn delete">Hapus</a>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="4">Tidak ada mobil dalam database.</td></tr>';
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
