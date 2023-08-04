<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'penilaian';
require_once './../includes/header.php';
require_once './classes/alternatif.php';
$id_user = $_SESSION['id_user'];

$alternatif_kriteria = $getDataAlternatif->alternatif_kriteria();
?>
<!-- Tampilkan pesan sukses atau error jika sesi tersebut diatur -->
<?php if (isset($_SESSION['success'])): ?>
<script>
Swal.fire({
    title: 'Sukses!',
    text: '<?php echo $_SESSION['success']; ?>',
    icon: 'success',
    confirmButtonText: 'OK'
});
</script>
<?php unset($_SESSION['success']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<script>
Swal.fire({
    title: 'Error!',
    text: '<?php echo $_SESSION['error']; ?>',
    icon: 'error',
    confirmButtonText: 'OK'
});
</script>
<?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<div class="container mb-5 pt-5" style="font-family: 'Prompt', sans-serif">
    <div class="row">
        <div class="d-xxl-flex">
            <div class="col-xxl-12 mt-5 ms-xxl-1">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        DAFTAR KOST
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%"
                                id="table-penilaian">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Nama Kost</th>
                                        <th scope="col">Biaya Masuk</th>
                                        <th scope="col">Fasilitas</th>
                                        <th scope="col">Jarak Pusat Kota</th>
                                        <th scope="col">Jumlah Pengunjung</th>
                                        <th scope="col">Kualitas Jalan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php foreach ($alternatif_kriteria  as $i => $value):?>
                                    <tr>
                                        <th scope="row"><?= $i+1; ?></th>
                                        <td><a href="./gambar/<?= $value['gambar'] == '-'? 'no-img.png': $value['gambar'];?>"
                                                data-lightbox="image-1"
                                                data-title="<?= $value['nama_alternatif']; ?>"><img
                                                    style="width:100px; height:100px;"
                                                    src="./gambar/<?= $value['gambar'] == '-'? 'no-img.png': $value['gambar']; ?>"
                                                    alt=""></a>
                                        </td>
                                        <td><?= $value['nama_alternatif']; ?></td>
                                        <td><?= $value['namaC1']; ?></td>
                                        <td><?= $value['namaC2']; ?></td>
                                        <td><?= $value['namaC3']; ?></td>
                                        <td><?= $value['namaC4']; ?></td>
                                        <td><?= $value['namaC5']; ?></td>
                                        <td>
                                            <a href="https://www.google.com/maps/dir/?api=1&destination=<?=$value['latitude'];?>,<?=$value['longitude'];?>"
                                                title="Lokasi di MAPS" class="btn btn-sm btn-success">Lokasi</a>
                                        </td>
                                    </tr>
                                    <?php endforeach;?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
require_once './../includes/footer.php';
?>


<script>
$(document).ready(function() {
    $("#prioritas_1").change(function() {
        var prioritas_1 = $("#prioritas_1").val();
        $.ajax({
            type: 'POST',
            url: "./functions/pilihan.php",
            data: {
                prioritas_1: [prioritas_1]
            },
            cache: false,
            success: function(msg) {
                $("#prioritas_2").html(msg);
            }
        });
    });

    $("#prioritas_2").change(function() {
        var prioritas_1 = $("#prioritas_1").val();
        var prioritas_2 = $("#prioritas_2").val();
        $.ajax({
            type: 'POST',
            url: "./functions/pilihan.php",
            data: {
                prioritas_2: [prioritas_1, prioritas_2]
            },
            cache: false,
            success: function(msg) {
                $("#prioritas_3").html(msg);
            }
        });
    });

    $("#prioritas_3").change(function() {
        var prioritas_1 = $("#prioritas_1").val();
        var prioritas_2 = $("#prioritas_2").val();
        var prioritas_3 = $("#prioritas_3").val();
        $.ajax({
            type: 'POST',
            url: "./functions/pilihan.php",
            data: {
                prioritas_3: [prioritas_1, prioritas_2, prioritas_3]
            },
            cache: false,
            success: function(msg) {
                $("#prioritas_4").html(msg);
            }
        });
        $("#prioritas_4").change(function() {
            var prioritas_1 = $("#prioritas_1").val();
            var prioritas_2 = $("#prioritas_2").val();
            var prioritas_3 = $("#prioritas_3").val();
            var prioritas_4 = $("#prioritas_4").val();
            $.ajax({
                type: 'POST',
                url: "./functions/pilihan.php",
                data: {
                    prioritas_4: [prioritas_1, prioritas_2, prioritas_3, prioritas_4]
                },
                cache: false,
                success: function(msg) {
                    $("#prioritas_5").html(msg);
                }
            });
        });
    });
});
</script>