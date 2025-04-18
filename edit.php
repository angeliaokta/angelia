<?php
include('db.php');

// Ambil ID dari URL
if (!isset($_GET['id'])) {
    echo "ID tidak ditemukan.";
    exit;
}

$id = $_GET['id'];

// Ambil data lama dari database
$query = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $query->fetch_assoc();

if (!$user) {
    echo "Data tidak ditemukan.";
    exit;
}

// Proses update
if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Jika ganti foto
    if ($_FILES['foto']['name'] != "") {
        $foto = $_FILES['foto']['name'];
        $tmp_foto = $_FILES['foto']['tmp_name'];
        $folder = "uploads/" . $foto;

        // Upload foto baru
        move_uploaded_file($tmp_foto, $folder);

        // Hapus foto lama
        if (file_exists("uploads/" . $user['foto'])) {
            unlink("uploads/" . $user['foto']);
        }

        // Update data dengan foto baru
        $conn->query("UPDATE users SET name='$name', email='$email', foto='$foto' WHERE id=$id");
    } else {
        // Update tanpa ubah foto
        $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
    }

    // Redirect kembali ke index
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Data Pengguna</title>
</head>
<body>

<h2>Edit Pengguna</h2>

<form method="POST" enctype="multipart/form-data">
    <label>Nama:</label><br>
    <input type="text" name="name" value="<?= $user['name']; ?>" required><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" value="<?= $user['email']; ?>" required><br><br>

    <label>Foto Saat Ini:</label><br>
    <img src="uploads/<?= $user['foto']; ?>" width="100"><br><br>

    <label>Ganti Foto (opsional):</label><br>
    <input type="file" name="foto"><br><br>

    <input type="submit" name="update" value="Update">
</form>

<br>
<a href="index.php">← Kembali ke Daftar</a>

</body>
</html>
