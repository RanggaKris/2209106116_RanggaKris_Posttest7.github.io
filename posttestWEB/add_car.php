<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST["model"];
    $harga = $_POST["harga"];

    $uploadDirectory = "uploads/";

    if (!file_exists($uploadDirectory)) {
        if (!mkdir($uploadDirectory, 0755, true)) {
            die("Gagal membuat direktori uploads.");
        }
    }

    if (empty($model) || empty($harga)) {
        echo "Model dan harga harus diisi.";
    } else {
        $uploadedFile = $_FILES["file"]["name"];

        $currentDate = date("Y-m-d");
        $fileExtension = pathinfo($uploadedFile, PATHINFO_EXTENSION);
        $newFileName = $currentDate . "." . $fileExtension;
        $targetFile = $uploadDirectory . $newFileName;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
            $photoUrl = $targetFile;

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "db_mobil";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Koneksi database gagal: " . $conn->connect_error);
            }

            $sql = "INSERT INTO cars (model, harga, photo_url) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sss", $model, $harga, $photoUrl);

                if ($stmt->execute()) {
                    echo "Mobil berhasil ditambahkan ke database.";
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
        } else {
            echo "Error saat mengunggah gambar.";
        }
    }
}
?>
