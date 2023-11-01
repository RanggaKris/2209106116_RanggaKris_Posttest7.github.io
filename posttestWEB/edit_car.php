<?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $car_id = $_GET["id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_mobil";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $car_id);

        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $model = $row["model"];
                $harga = $row["harga"];
                $photoUrl = $row["photo_url"];
            } else {
                echo "Mobil tidak ditemukan.";
                exit();
            }

            $stmt->close();
        } else {
            echo "Error: " . $stmt->error;
            exit();
        }
    } else {
        echo "Error: " . $conn->error;
        exit();
    }

    $conn->close();
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST["id"];
    $model = $_POST["model"];
    $harga = $_POST["harga"];

    $uploadDirectory = "uploads/";
    $newPhotoUrl = $photoUrl; 

    if (isset($_FILES["file"]) && $_FILES["file"]["error"] === UPLOAD_ERR_OK) {
        $uploadedFile = $_FILES["file"]["name"];
        $targetFile = $uploadDirectory . basename($uploadedFile);

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $newPhotoUrl = $targetFile;
        } else {
            echo "Error saat mengunggah gambar.";
        }
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_mobil";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    $sql = "UPDATE cars SET model = ?, harga = ?, photo_url = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssi", $model, $harga, $newPhotoUrl, $car_id);

        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: listdatabase.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mobil</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f14e95;
    color: #fff;
    text-align: center;
    margin: 0;
    padding: 0;
}

h1 {
    background-color: #f14e95;
    color: #ffff;
    padding: 10px;
}

a {
    color: #fff;
    text-decoration: none;
}

a:hover {
    color: #ffc0cb;
}

form {
    background-color: #fff;
    padding: 30px;
    width: 300px;
    margin: 20px auto;
    border-radius: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

form input[type="text"],
form input[type="number"] {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
}

form input[type="file"] {
    width: 100%;
    border: none;
    margin-bottom: 10px;
}

button {
    background-color: #a325dd;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #ffc0cb;
}

    </style>
</head>
<body>
    <h1>Edit Mobil</h1>
    <a href="listdatabase.php">Kembali ke Daftar Mobil</a>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $car_id; ?>">
        <div>
            <label for="model">Model Mobil:</label>
            <input type="text" id="model" name="model" value="<?php echo $model; ?>" required>
        </div>
        <div>
            <label for="harga">Harga Mobil (Rp):</label>
            <input type="number" id="harga" name="harga" value="<?php echo $harga; ?>" required>
        </div>
        <div>
            <label for="file">Foto Mobil (Biarkan kosong jika tidak ingin mengubah):</label>
            <input type="file" id="file" name="file" accept="image/*">
        </div>
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>
