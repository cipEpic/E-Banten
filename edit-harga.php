<?php

session_start();
include 'connect-db.php';
include 'functions/functions.php';

// cek apakah sudah login sebagai agen
cekAgen();

// mengambil id agen di session
$idAgen = $_SESSION["agen"];

// mengambil data harga pada db
$canang = mysqli_query($connect, "SELECT * FROM harga WHERE id_agen = '$idAgen' AND jenis = 'canang'");
$canang = mysqli_fetch_assoc($canang);
$pejati = mysqli_query($connect, "SELECT * FROM harga WHERE id_agen = '$idAgen' AND jenis = 'pejati'");
$pejati = mysqli_fetch_assoc($pejati);
$kajengkliwon = mysqli_query($connect, "SELECT * FROM harga WHERE id_agen = '$idAgen' AND jenis = 'kajengkliwon'");
$kajengkliwon = mysqli_fetch_assoc($kajengkliwon);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "headtags.html"; ?>
    <title>Ubah Data Harga</title>
</head>
<body>

    <!-- header -->
    <?php include 'header.php'; ?>
    <!-- end header -->

    <!-- body -->
    <div class="container">
        <h3 class="header light center">Data Harga</h3>
        <form action="" method="post">
            <div class="input field">
                <label for="canang">Canang</label>
                <input type="text" id="canang" name="canang" value="<?= $canang['harga'] ?>">
            </div>
            <div class="input field">
                <label for="pejati">Pejati</label>
                <input type="text" id="pejati" name="pejati" value="<?= $pejati['harga'] ?>">
            </div>
            <div class="input field">
                <label for="kajengkliwon">Kajeng Kliwon</label><input type="text" id="kajengkliwon" name="kajengkliwon" value="<?= $kajengkliwon['harga'] ?>">
            </div>
            <div class="input field center">
                <button class="btn-large blue darken-2" type="submit" name="simpan">Simpan Data</button>
            </div>
        </form>
    </div>
    <!-- end body -->

    <!-- footer -->
    <?php include "footer.php" ?>
    <!-- end footer -->

</body>
</html>

<?php


// fungsi mengubah harga
function ubahHarga($data){
    global $connect, $idAgen;

    $hargaCanang = htmlspecialchars($data["canang"]);
    $hargaPejati = htmlspecialchars($data["pejati"]);
    $hargaKajengKliwon = htmlspecialchars($data["kajengkliwon"]);

    validasiHarga($hargaCanang);
    validasiHarga($hargaPejati);
    validasiHarga($hargaKajengKliwon);

    $query1 = "UPDATE harga SET
        harga = $hargaCanang
        WHERE jenis = 'canang' AND id_agen = $idAgen
    ";
    $query2 = "UPDATE harga SET
        harga = $hargaPejati
        WHERE jenis = 'pejati' AND id_agen = $idAgen
    ";
    $query3 = "UPDATE harga SET
        harga = $hargaKajengKliwon
        WHERE jenis = 'kajengkliwon' AND id_agen = $idAgen
    ";

    mysqli_query($connect,$query1);
    $hasil1 = mysqli_affected_rows($connect);
    mysqli_query($connect,$query2);
    $hasil2 = mysqli_affected_rows($connect);
    mysqli_query($connect,$query3);
    $hasil3 = mysqli_affected_rows($connect);

    return $hasil1+$hasil2+$hasil3;
}


// jika user menekan tombol simpan harga
if (isset($_POST["simpan"])) {

    if ( ubahHarga($_POST) > 0)   {
        echo "
            <script>
                Swal.fire('Data Berhasil Di Update','','success').then(function() {
                    window.location = 'edit-harga.php';
                });
            </script>
        ";
    }else {
        echo "
            <script>
                Swal.fire('Data Gagal Di Update','','error');
            </script>
        ";
        mysqli_error($connect);
    }

}

?>