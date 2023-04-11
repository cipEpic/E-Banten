<?php

session_start();
include 'connect-db.php';
include 'functions/functions.php';

cekAgen();

$idAgen = $_SESSION["agen"];

// ambil data agen
$query = "SELECT * FROM agen WHERE id_agen = '$idAgen'";
$result = mysqli_query($connect, $query);
$agen = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "headtags.html"; ?>
    <title>Registrasi Agen Lanjutan</title>
</head>
<body>

    <!-- header -->
    <?php include 'header.php' ?>
    <!-- end header -->

    <div class="row">

        <!-- term -->
        <div class="col s4 offset-s1">
            <div class="card">
                <div class="col center" style="margin:20px">
                    <img src="img/banner.png" alt="laundryku" width=100%/><br><br>
                    <span class="card-title black-text">Syarat dan Ketentuan :</span>
                </div>
                <div class="card-content">
                <p>1.	Memiliki lokasi usaha toko banten yang strategis dan teridentifikasi oleh google map</p>
                    <p>2.	Agen memiliki nama usaha serta logo perusahaan agar dapat diposting di website e-Banten</p>
                    <p>3.	Mampu memberikan layanan Banten dengan kualitas prima dan harga yang bersaing</p>
                    <p>4.	Memiliki driver yang bersedia untuk melakukan pengantaran terhadap pembelian banten oleh pelanggan</p>
                    <p>5.	Harga dari pesanan banten ditentukan berdasarkan banyak per pieces (Pcs) ditambah dengan biaya ongkos kirim</p> <!-- masih bingung di term ini -->
                    <p>6.	Bersedia untuk memberikan informasi kepada pelanggan mengenai harga banten per pieces (pcs)</p> <!-- masih bingung di term ini -->
                    <p>7.	Bersedia untuk menerapkan sistem poin kepada pelanggan</p>
                    <p>8.	Agen tidak diperkenankan untuk melakukan kerjasama dengan pihak Toko Banten lainnya</p>
                    <p>9.	Sebagai kompensasi atas kerjasama adalah sistem bagi hasil sebesar 5%, yang diperhitungkan dari setiap 7 hari</p>
                    <p>10.	Status agen secara otomatis dicabut apabila melanggar kesepakatan yang telah ditetapkan dalam surat perjanjian kerjasama ataupun agen ingin mengundurkan diri</p>
                </div>
                <div class="card-action">
                    <a href="term.php">Baca Selengkapnya</a>
                </div>
            </div>  
        </div>
        <!-- end term -->

    
        <!-- harga -->
        <div class="col s4 offset-s1">
            <h3 class="header light center">Data Harga</h3>
            <form action="" method="post">
                <div class="input-field inline">
                    <ul>
                        <li>
                            <label for="canang">Canang (Rp.)</label>
                            <input type="text" size=50 name="canang" value="0">
                        </li>
                        <li>
                            <label for="pejati">Pejati (Rp.)</label>
                            <input type="text" size=50 name="pejati" value="0">
                        </li>
                        <li>
                            <label for="kajengkliwon">KajengKliwon (Rp.)</label>
                            <input type="text" size=50 name="kajengkliwon" value="0">
                        </li>
                        <li>
                            <div class="center">
                                <button class="btn-large blue darken-2" type="submit" name="submit">Simpan Harga</button>
                            </div>
                        </li>
                    </ul>
                </div>
            </form>
        </div>
        <!-- end harga -->
    </div>

    <!-- footer -->
    <?php include 'footer.php'; ?>
    <!-- end footer -->

</body>
</html>

<?php

function dataHarga($data){
    global $connect, $idAgen;

    $canang = htmlspecialchars($data["canang"]);
    $pejati = htmlspecialchars($data["pejati"]);
    $kajengkliwon = htmlspecialchars($data["kajengkliwon"]);

    validasiHarga($canang);
    validasiHarga($pejati);
    validasiHarga($kajengkliwon);

    $query2 = "INSERT INTO harga VALUES(
        '',
        'canang',
        '$idAgen',
        '$canang'
    )";
    $query3 = "INSERT INTO harga VALUES(
        '',
        'pejati',
        '$idAgen',
        '$pejati'
    )";
    $query4 = "INSERT INTO harga VALUES(
        '',
        'kajengkliwon',
        '$idAgen',
        '$kajengkliwon'
    )";

    $result2 = mysqli_query($connect, $query2);
    $result3 = mysqli_query($connect, $query3);
    $result4 = mysqli_query($connect, $query4);

    return mysqli_affected_rows($connect);
}

if ( isset($_POST["submit"]) ){
    

    if ( dataHarga($_POST) > 0 ){
        echo "
            <script>
                Swal.fire('Pendaftaran Berhasil','Data Harga Berhasil Ditambahkan','success').then(function(){
                    window.location = 'index.php';
                });
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Data Gagal Ditambahkan !');
            </script>
        ";
        echo mysqli_error($connect);
    }
}

?>