<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "phpdasar");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function upload()
{
    $namaFile = $_FILES['image']['name'];
    $ukuranFile = $_FILES['image']['size'];
    $error = $_FILES['image']['error'];
    $tmpName = $_FILES['image']['tmp_name'];

    # cek apakah gambar sudah di upload
    if ($error === 4) {
        echo "<script>alert('pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    // cek apakah file adalah gamabar
    $extensiGambarValid = ['jpg', 'jpeg', 'png'];
    $extensiGambar = explode('.', $namaFile);
    $extensiGambar = strtolower(end($extensiGambar));
    if (!in_array($extensiGambar, $extensiGambarValid)) {
        echo "<script>alert('yang anda upload bukan gambar!');</script>";
        return false;
    }

    // cek apakah ukuran file < 1 MB
    if ($ukuranFile > 1000000) {
        echo "<script>alert('ukuran gambar terlalu besar!');</script>";
        return false;
    }

    // pindahkan gambar terupload ke dir
    $namaFileBaru = uniqid() . "." . $extensiGambar;
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

function tambah($data)
{
    global $conn;

    $name = htmlspecialchars($data['name']);
    $category = htmlspecialchars($data['category']);
    $description = htmlspecialchars($data['description']);
    $price = htmlspecialchars($data['price']);

    // $image = htmlspecialchars($data['image']);
    $image = upload();
    if (!$image) {
        return false;
    }

    $query = "insert into products values ('','$name','$category','$description','$price','$image')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function ubah($data)
{
    global $conn;

    $id = $data['id'];
    $name = htmlspecialchars($data['name']);
    $category = htmlspecialchars($data['category']);
    $description = htmlspecialchars($data['description']);
    $price = htmlspecialchars($data['price']);
    $gambarLama = htmlspecialchars($data['gambarLama']);

    if ($_FILES['image']['error'] === 4) {
        $image = $gambarLama;
    } else {
        $image = upload();
        unlink('img/' . $gambarLama);
    }

    $query = "update products set name = '$name', category = '$category', description = '$description',
                price = $price, image = '$image' where id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function hapus($id)
{
    global $conn;

    $row = query("select * from products where id = $id")[0];
    $imageName = $row['image'];

    mysqli_query($conn, "delete from products where id = $id");

    unlink('img/' . $imageName);

    return mysqli_affected_rows($conn);
}

function cari($keyword)
{
    $query = "select * from products where name like '%$keyword%' or category like '%$keyword%'";
    return query($query);
}

function register($data)
{
    global $conn;

    $username = strtolower(stripslashes($data['username']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['password2']);

    //  cek apakah username sudah terdaftar
    $result = mysqli_query($conn, "select * from users where username = '$username'");

    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('user sudah terdaftar!');</script>";
        return false;
    }

    // cek konfirmasi password
    if ($password !== $password2) {
        echo "<script>alert('konfirmasi password salah!')</script>";
        return false;
    }

    // password hashed
    $password = password_hash($password, PASSWORD_BCRYPT);

    // tambahkan data ke database
    mysqli_query($conn, "insert into users values('','$username','$password')");

    return mysqli_affected_rows($conn);
}