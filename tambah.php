<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';
if (isset($_POST['submit'])) {
    if (tambah($_POST) > 0) {
        echo "
            <script>
                alert('data berhasil ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal ditambahkan!');
                document.location.href = 'index.php';
            </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
</head>

<body>
    <h1>Tambah Produk</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" required>
            </li>
            <li>
                <label for="category">Kategori</label>
                <input type="text" name="category" id="category" required>
            </li>
            <li>
                <label for="description">Deskripsi</label>
                <input type="text" name="description" id="description" required>
            </li>
            <li>
                <label for="price">Harga</label>
                <input type="number" name="price" id="price" required>
            </li>
            <li>
                <label for="image">Gambar</label>
                <input type="file" name="image" id="image">
            </li>
            <li>
                <button type="submit" name="submit">Tambah Data</button>
            </li>
        </ul>
    </form>
</body>

</html>