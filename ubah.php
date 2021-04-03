<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';

$id = $_GET['id'];
$product = query("select * from products where id = $id")[0];

if (isset($_POST['submit'])) {
    if (ubah($_POST) >= 0) {
        echo "
            <script>
                alert('data berhasil diubah!');
                document.location.href = 'index.php';
            </script>
        ";
    } else {
        echo "
            <script>
                alert('data gagal diubah!');
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
    <title>Ubah Produk</title>
</head>

<body>
    <h1>Ubah Produk</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $product['id']; ?>">
        <input type="hidden" name="gambarLama" value="<?= $product['image']; ?>">
        <ul>
            <li>
                <label for="name">Nama</label>
                <input type="text" name="name" id="name" required value="<?= $product['name']; ?>">
            </li>
            <li>
                <label for="category">Kategori</label>
                <input type="text" name="category" id="category" required value="<?= $product['category']; ?>">
            </li>
            <li>
                <label for="description">Deskripsi</label>
                <input type="text" name="description" id="description" required value="<?= $product['description']; ?>">
            </li>
            <li>
                <label for="price">Harga</label>
                <input type="number" name="price" id="price" required value="<?= $product['price']; ?>">
            </li>
            <li>
                <label for="image">Gambar</label><br>
                <img src="img/<?= $product['image'] ?>" width="40"><br>
                <input type="file" name="image" id="image">
            </li>
            <li>
                <button type="submit" name="submit">Ubah Data</button>
            </li>
        </ul>
    </form>
</body>

</html>