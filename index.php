<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
require 'functions.php';

$products = query("select * from products");

// // pagination logic
// $dataPerPage = 1;

// if (isset($_POST['cari'])) {
//     $products = cari($_POST['keyword']);
//     $allCount = count($products);
//     $pageCount = ceil($allCount / $dataPerPage);
//     $activePage = (isset($_GET['page'])) ? $_GET['page'] : 1;
//     $startIndex = ($activePage * $dataPerPage) - $dataPerPage;
//     $products = array_slice($products, $startIndex, $dataPerPage);
// } else {
//     $result = mysqli_query($conn, "select * from products");
//     $allCount = mysqli_num_rows($result);
//     $pageCount = ceil($allCount / $dataPerPage);
//     $activePage = (isset($_GET['page'])) ? $_GET['page'] : 1;
//     $startIndex = ($activePage * $dataPerPage) - $dataPerPage;
//     $products = query("select * from products limit $startIndex,$dataPerPage");
// }

if (isset($_POST['cari'])) {
    $products = cari($_POST['keyword']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <style>
    .loader {
        width: 100px;
        position: absolute;
        top: 120px;
        left: 300px;
        z-index: -1;
        display: none;
    }
    </style>
</head>

<body>
    <a href="logout.php">Logout</a><br>
    <h1>Daftar Produk</h1>
    <a href="tambah.php">Tambah Produk</a>
    <br><br>
    <form action="" method="post">
        <input type="text" name="keyword" size="40" placeholder="masukkan keyword pencarian" autocomplete="off"
            autofocus id="keyword">
        <button type="submit" name="cari" id="tombol-cari">Cari</button>
        <img src="img/loader.gif" class="loader">
    </form>
    <!-- <br>
    <a href="">Reset Pencarian</a>
    <br><br>
    <?php if ($activePage > 1) : ?>
    <a href="?page=<?= $activePage - 1; ?>">&laquo;</a>
    <?php endif; ?>
    <?php for ($i = 1; $i <= $pageCount; $i++) : ?>
    <?php if ($i == $activePage) : ?>
    <a href="?page=<?= $i; ?>" style="font-weight:bold; color:red;"><?= $i; ?></a>
    <?php else : ?>
    <a href="?page=<?= $i; ?>"><?= $i; ?></a>
    <?php endif; ?>
    <?php endfor; ?>
    <?php if ($activePage < $pageCount) : ?>
    <a href="?page=<?= $activePage + 1; ?>">&raquo;</a>
    <?php endif; ?> -->
    <br><br>
    <div id="container">
        <table border="1" cellpadding="10" cellspacing="0">
            <tr>
                <th>No.</th>
                <th>Aksi</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Harga</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td>
                    <a href="ubah.php?id=<?= $product['id']; ?>">ubah</a> |
                    <a href="hapus.php?id=<?= $product['id']; ?>" onclick="return confirm('yakin?');">hapus</a>
                </td>
                <td><img src="img/<?= $product['image']; ?>" width="50"></td>
                <td><?= $product['name']; ?></td>
                <td><?= $product['category']; ?></td>
                <td><?= $product['description'] ?></td>
                <td><?= $product['price']; ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
    </div>
    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
</body>

</html>