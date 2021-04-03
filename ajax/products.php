<?php
// usleep(500000);
require '../functions.php';

$keyword = $_GET['keyword'];

$query = "select * from products where name like '%$keyword%' 
            or category like '%$keyword%' 
            or description like '%$keyword%'";

$products = query($query);
?>
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