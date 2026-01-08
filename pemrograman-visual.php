<?php
include 'config.php';

/* =========================
   TAMBAH ANGGOTA
========================= */
if (isset($_POST['tambah'])) {
    $kelompok = $_POST['kelompok'];
    $nama     = $_POST['nama'];
    $nim      = $_POST['nim'];

    $stmt = $conn->prepare(
        "INSERT INTO anggota_pv (kelompok, nama, nim) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sss", $kelompok, $nama, $nim);
    $stmt->execute();
    $stmt->close();
}

/* =========================
   HAPUS ANGGOTA
========================= */
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $stmt = $conn->prepare(
        "DELETE FROM anggota_pv WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

/* =========================
   EDIT ANGGOTA
========================= */
if (isset($_POST['edit'])) {
    $id   = $_POST['id'];
    $nama = $_POST['nama'];
    $nim  = $_POST['nim'];

    $stmt = $conn->prepare(
        "UPDATE anggota_pv SET nama = ?, nim = ? WHERE id = ?"
    );
    $stmt->bind_param("ssi", $nama, $nim, $id);
    $stmt->execute();
    $stmt->close();
}

/* =========================
   AMBIL DATA ANGGOTA
========================= */
$result = $conn->query(
    "SELECT * FROM anggota_pv ORDER BY kelompok ASC, created_at ASC"
);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pemrograman Visual | TI.23.C4</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background: linear-gradient(135deg, #198754, #20c997);
    font-family: 'Segoe UI', sans-serif;
    min-height:100vh;
    padding:30px;
}
.container{
    background:#ffffff;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}
h2{
    text-align:center;
    margin-bottom:25px;
    color:#198754;
}
ul{
    padding-left:0;
}
li{
    list-style:none;
    padding:8px 12px;
    margin-bottom:6px;
    background:#f8f9fa;
    border-radius:6px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
</style>
</head>

<body>
<div class="container">

<a href="index.html" class="btn btn-secondary mb-3">
    &larr; Kembali ke Dashboard
</a>

<h2>Mata Kuliah Pemrograman Visual <br> Sanudin, S.Kom., M.Kom.</h2>

<!-- =========================
     FORM TAMBAH ANGGOTA
========================= -->
<form method="post" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="kelompok" class="form-select" required>
            <option value="">-- Pilih Kelompok --</option>
            <option>Kelompok 1</option>
            <option>Kelompok 2</option>
            <option>Kelompok 3</option>
            <option>Kelompok 4</option>
            <option>Kelompok 5</option>
            <option>Kelompok 6</option>
            <option>Kelompok 7</option>
            <option>Kelompok 8</option>
            <option>Kelompok 9</option>
            <option>Kelompok 10</option>
        </select>
    </div>

    <div class="col-md-4">
        <input type="text" name="nama" class="form-control" placeholder="Nama Mahasiswa" required>
    </div>

    <div class="col-md-3">
        <input type="text" name="nim" class="form-control" placeholder="NIM" required>
    </div>

    <div class="col-md-2">
        <button type="submit" name="tambah" class="btn btn-success w-100">
            Tambah
        </button>
    </div>
</form>

<!-- =========================
     DAFTAR ANGGOTA PER KELOMPOK
========================= -->
<?php
$kelompok_sebelumnya = '';

echo '<ul>';

while ($row = $result->fetch_assoc()) {

    if ($row['kelompok'] !== $kelompok_sebelumnya) {

        if ($kelompok_sebelumnya !== '') {
            echo '</ul><hr><ul>';
        }

        echo '<h5 class="mt-3">'.$row['kelompok'].'</h5>';
        $kelompok_sebelumnya = $row['kelompok'];
    }

    echo '<li>';
    echo $row['nama'].' ('.$row['nim'].')';
    echo '
        <span>
            <a href="?hapus='.$row['id'].'" 
               class="btn btn-sm btn-danger"
               onclick="return confirm(\'Yakin ingin menghapus?\')">
               Hapus
            </a>

            <button class="btn btn-sm btn-primary"
                onclick="editForm(
                    '.$row['id'].',
                    \''.$row['nama'].'\',
                    \''.$row['nim'].'\'
                )">
                Edit
            </button>
        </span>
    ';
    echo '</li>';
}

echo '</ul>';
?>

<!-- =========================
     FORM EDIT ANGGOTA
========================= -->
<div class="mt-4" id="editFormContainer" style="display:none;">
    <h5>Edit Data Anggota</h5>

    <form method="post" class="row g-2">
        <input type="hidden" name="id" id="edit_id">

        <div class="col-md-5">
            <input type="text" name="nama" id="edit_nama" class="form-control" required>
        </div>

        <div class="col-md-5">
            <input type="text" name="nim" id="edit_nim" class="form-control" required>
        </div>

        <div class="col-md-2">
            <button type="submit" name="edit" class="btn btn-warning w-100">
                Update
            </button>
        </div>
    </form>
</div>

</div>

<script>
function editForm(id, nama, nim) {
    document.getElementById('editFormContainer').style.display = 'block';
    document.getElementById('edit_id').value   = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_nim').value  = nim;

    window.scrollTo(0, document.body.scrollHeight);
}
</script>

</body>
</html>
