<?php
// koneksi database
$server = "localhost";
$user = "root";
$pass = "";
$database = "fazztrack";



$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

//jika tombol simpan di klik
if (isset($_POST['btnsimpan'])) {

    //pengujian apakah data akan diedit atau disimpan baru
    if ($_GET['hal'] == "edit") {
        //data akan diedit
        $edit = mysqli_query($koneksi, "UPDATE tproduk set
                                            namaproduk = '$_POST[produk]',
                                            harga = '$_POST[harga]',
                                            jumlah = '$_POST[jumlah]',
                                            keterangan = '$_POST[keterangan]'
                                        WHERE id_produk = '$_GET[id]'
                                        ");
        if ($edit) { //jika edit sukses 
            echo "<script>
                alert('edit data sukses');
                document.location = 'index.php';
                </script>";
        } else {
            echo "<script>
            alert('edit data GAGAL');
            document.location = 'index.php';
            </script>";
        }
    } else {
        //data akan disimpan baru
        $simpan = mysqli_query($koneksi, "INSERT INTO tproduk (namaproduk,harga,jumlah,keterangan)
                                            VALUES ('$_POST[produk]',
                                                '$_POST[harga]',
                                                '$_POST[jumlah]',
                                                '$_POST[keterangan]')
                                            ");
        if ($simpan) { //jika simpan baru sukses 
            echo "<script>
                alert('Simpan data sukses');
                document.location = 'index.php';
                </script>";
        } else {
            echo "<script>
                alert('Simpan data GAGAL');
                document.location = 'index.php';
                </script>";
        }
    }
}
//pengujian jika tombol edit / hapus data
if (isset($_GET['hal'])) {
    //Pengujian jika edit Data
    if ($_GET['hal'] == "edit") {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tproduk WHERE id_produk = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan maka ditampung dulu dalam variabel
            $vnamaproduk = $data['namaproduk'];
            $vharga = $data['harga'];
            $vjumlah = $data['jumlah'];
            $vketerangan = $data['keterangan'];
        }
    } else if ($_GET['hal'] == "hapus") {
        //perisapkan mengapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM tproduk WHERE id_produk = '$_GET[id]'");
        if ($hapus) {
            echo "<script>
                alert('Hapus data Berhasil');
                document.location = 'index.php';
                </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <title>CRUD WEB</title>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-3">PRODUK APP CRUD</h1>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>

        <!-- awal card form -->
        <div class="card mt-5">
            <div class="card-header bg-primary text-white">
                Form Input Data Produk
            </div>
            <div class="card-body">
                <form action="" method="POST">
                    <div class="form-group">
                        <label>Nama Produk</label>
                        <input type="text" name="produk" value="<?= @$vnamaproduk ?>" class="form-control" placeholder="Input nama produk disini" required>
                    </div>
                    <div class="form-group">
                        <label>Harga Produk</label>
                        <input type="text" name="harga" value="<?= @$vharga ?>" class="form-control" placeholder="Input Harga Produk disini" required>
                    </div>
                    <div class="form-group">
                        <label>Jumlah Produk</label>
                        <input type="text" name="jumlah" value="<?= @$vjumlah ?>" class="form-control" placeholder="Input Jumlah Produk disini" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" value="<?= @$vketerangan ?>" class="form-control" placeholder="Input Keterangan Produk disini" required>
                    </div>
                    <button type="submit" class="btn btn-success" name="btnsimpan">Simpan</button>
                    <button type="reset" class="btn btn-danger" name="btnreset">Reset</button>
                </form>
            </div>
        </div>
        <!-- akhir card form -->

        <!-- awal card form -->
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                Daftar Produk
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>No.</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * from tproduk order by id_produk desc");
                    while ($data = mysqli_fetch_array($tampil)) :
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['namaproduk'] ?></td>
                            <td><?= $data['harga'] ?></td>
                            <td><?= $data['jumlah'] ?></td>
                            <td><?= $data['keterangan'] ?></td>
                            <td>
                                <a href="index.php?hal=edit&id=<?= $data['id_produk'] ?>" class="btn btn-warning">Edit</a>
                                <a href="index.php?hal=hapus&id=<?= $data['id_produk'] ?>" onclick="return confirm('Apakah yakin ingin menghapus data ini ?')" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        <!-- unutuk ngecek datanya -->
                        <?php //var_dump($data['namaproduk']); 
                        ?>
                    <?php endwhile; ?>
                </table>
            </div>

        </div>
        <!-- akhir card form -->
    </div>


</body>

</html>