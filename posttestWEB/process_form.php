<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $model = $_POST["model"];
    $harga = $_POST["harga"];

    if (empty($model) || empty($harga)) {
        echo "Model dan harga harus diisi.";
    } else {

        echo "Data mobil dengan model $model dan harga $harga telah diproses.";
    }
}
?>
