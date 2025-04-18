<?php
include('db.php');

// Tambah data
if (isset($_POST['insert'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $foto = $_FILES['foto']['name'];
    $tmp_foto = $_FILES['foto']['tmp_name'];
    $folder = "uploads/" . $foto;

    if (move_uploaded_file($tmp_foto, $folder)) {
        $sql = "INSERT INTO users (name, email, foto) VALUES ('$name', '$email', '$foto')";
        $conn->query($sql);
    }
}

// Hapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $getFoto = $conn->query("SELECT foto FROM users WHERE id=$id")->fetch_assoc();
    if ($getFoto && file_exists("uploads/" . $getFoto['foto'])) {
        unlink("uploads/" . $getFoto['foto']);
    }
    $conn->query("DELETE FROM users WHERE id=$id");
}

// Ambil semua data
$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pengguna - Angelia Oktaviani</title>
</head>
<body>
    <h2>Data Pengguna</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id']; ?></td>
            <td><?= $row['name']; ?></td>
            <td><?= $row['email']; ?></td>
            <td><img src="uploads/<?= $row['foto']; ?>" width="100"></td>
            <td>
                <a href="edit.php?id=<?= $row['id']; ?>">Edit</a> |
                <a href="?delete=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h3>Tambah Data Baru</h3>
    <form method="POST" enctype="multipart/form-data">
        <label>Nama:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Foto:</label><br>
        <input type="file" name="foto" required><br><br>

        <input type="submit" name="insert" value="Simpan">
    </form>
</body>
</html>
