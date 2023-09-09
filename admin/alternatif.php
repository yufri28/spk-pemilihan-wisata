<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'alternatif';
require_once './header.php';
require_once './classes/alternatif.php';

$dataAlternatif = $getDataAlternatif->getDataAlternatif();
if(isset($_POST['simpan'])){
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $namaFile = $_FILES['gambar']['name'];
        $lokasiSementara = $_FILES['gambar']['tmp_name'];
        
        // Tentukan lokasi tujuan penyimpanan
        $targetDir = '../user_area/gambar/';
        $targetFilePath = $targetDir . $namaFile;

        // Cek apakah nama file sudah ada dalam direktori target
        if (file_exists($targetFilePath)) {
            $fileInfo = pathinfo($namaFile);
            $baseName = $fileInfo['filename'];
            $extension = $fileInfo['extension'];
            $counter = 1;

            // Loop hingga menemukan nama file yang unik
            while (file_exists($targetFilePath)) {
                $namaFile = $baseName . '_' . $counter . '.' . $extension;
                $targetFilePath = $targetDir . $namaFile;
                $counter++;
            }
        }

        // Pindahkan file gambar dari lokasi sementara ke lokasi tujuan
        if (move_uploaded_file($lokasiSementara, $targetFilePath)) {
            $namaAlternatif = htmlspecialchars($_POST['nama_alternatif']);
            $latitude = htmlspecialchars($_POST['latitude']);
            $longitude = htmlspecialchars($_POST['longitude']);
            $alamat = htmlspecialchars($_POST['alamat']);
            $rating = htmlspecialchars($_POST['rating']);
            $biaya = htmlspecialchars($_POST['biaya']);
            $fasilitas = htmlspecialchars($_POST['fasilitas']);
            $jarak = htmlspecialchars($_POST['jarak']);
            $jumlah_pengunjung = htmlspecialchars($_POST['jumlah-pengunjung']);
           

            $dataAlt = [
                'nama_alternatif' => $namaAlternatif,
                'latitude' =>$latitude,
                'longitude' => $longitude,
                'rating' => $rating,
                'gambar' => $namaFile,
                'alamat' => $alamat       
            ];
            $dataSubKriteria = [
                'C1' => $biaya,
                'C2' => $fasilitas,
                'C3' => $jarak,
                'C4' => $jumlah_pengunjung
        
            ];

            $getDataAlternatif->tambahAlternatif($dataAlt, $dataSubKriteria);
        } else {
            return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
        }
    } else {
        return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
    }
}   
if(isset($_POST['edit'])){
    // Pastikan ada file gambar yang diunggah
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $namaFile = $_FILES['gambar']['name'];
        $lokasiSementara = $_FILES['gambar']['tmp_name'];
        
        // Tentukan lokasi tujuan penyimpanan
        $targetDir = '../user_area/gambar/';
        $targetFilePath = $targetDir . $namaFile;

        // Cek apakah nama file sudah ada dalam direktori target
        if (file_exists($targetFilePath)) {
            $fileInfo = pathinfo($namaFile);
            $baseName = $fileInfo['filename'];
            $extension = $fileInfo['extension'];
            $counter = 1;

            // Loop hingga menemukan nama file yang unik
            while (file_exists($targetFilePath)) {
                $namaFile = $baseName . '_' . $counter . '.' . $extension;
                $targetFilePath = $targetDir . $namaFile;
                $counter++;
            }
        }

        // Pindahkan file gambar dari lokasi sementara ke lokasi tujuan
        if (move_uploaded_file($lokasiSementara, $targetFilePath)) {
            if (isset($_POST["gambar_lama"])) {
                $fileLama = $_POST["gambar_lama"];
                if (file_exists($targetDir . $fileLama)) {
                    unlink($targetDir . $fileLama);
                }
            }
            $uploadedFiles['gambar_lama'] = $namaFile;
            $id_alternatif = htmlspecialchars($_POST['id_alternatif']);
            $namaAlternatif = htmlspecialchars($_POST['nama_alternatif']);
            $latitude = htmlspecialchars($_POST['latitude']);
            $longitude = htmlspecialchars($_POST['longitude']);
            $alamat = htmlspecialchars($_POST['alamat']);
            $rating = htmlspecialchars($_POST['rating']);
            $biaya = htmlspecialchars($_POST['biaya']);
            $fasilitas = htmlspecialchars($_POST['fasilitas']);
            $jarak = htmlspecialchars($_POST['jarak']);
            $jumlah_pengunjung = htmlspecialchars($_POST['jumlah-pengunjung']);
        
        
            $dataAlt = [
                'id_alternatif' => $id_alternatif,
                'nama_alternatif' => $namaAlternatif,
                'latitude' =>$latitude,
                'longitude' => $longitude,
                'rating' => $rating,
                'gambar' => $namaFile,
                'alamat' => $alamat       
            ];

            $dataSubKriteria = [$biaya,$fasilitas,$jarak,$jumlah_pengunjung];
            $getDataAlternatif->editAlternatif($dataAlt,$dataSubKriteria);
        } else {
            return $_SESSION['error'] = 'Tidak ada data yang dikirim!';
        }
    } else {
        $id_alternatif = htmlspecialchars($_POST['id_alternatif']);
        $namaAlternatif = htmlspecialchars($_POST['nama_alternatif']);
        $latitude = htmlspecialchars($_POST['latitude']);
        $longitude = htmlspecialchars($_POST['longitude']);
        $alamat = htmlspecialchars($_POST['alamat']);
        $rating = htmlspecialchars($_POST['rating']);
        $biaya = htmlspecialchars($_POST['biaya']);
        $fasilitas = htmlspecialchars($_POST['fasilitas']);
        $jarak = htmlspecialchars($_POST['jarak']);
        $jumlah_pengunjung = htmlspecialchars($_POST['jumlah-pengunjung']);
       
    
        $dataAlt = [
            'id_alternatif' => $id_alternatif,
            'nama_alternatif' => $namaAlternatif,
            'latitude' =>$latitude,
            'longitude' => $longitude,
            'rating' => $rating,
            'gambar' => $_POST['gambar_lama'],
            'alamat' => $alamat       
        ];
        $dataSubKriteria = [$biaya,$fasilitas,$jarak,$jumlah_pengunjung];
        $getDataAlternatif->editAlternatif($dataAlt,$dataSubKriteria);
    }    
}   

if(isset($_POST['hapus'])){
    $idAlternatif = htmlspecialchars($_POST['id_alternatif']);
    $getDataAlternatif->hapusAlternatif($idAlternatif);
}

$getSubBiaya = $getDataAlternatif->getSubBiaya();
$getSubFasilitas = $getDataAlternatif->getSubFasilitas();
$getSubPusatKota = $getDataAlternatif->getSubPusatKota();
$getSubJumlahPengunjung = $getDataAlternatif->getSubJumlahPengunjung();
?>
<?php if (isset($_SESSION['success'])): ?>
<script>
var successfuly = '<?php echo $_SESSION["success"]; ?>';
Swal.fire({
    title: 'Sukses!',
    text: successfuly,
    icon: 'success',
    confirmButtonText: 'OK'
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = '';
    }
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
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = '';
    }
});
</script>
<?php unset($_SESSION['error']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>
<div class="container" style="font-family: 'Prompt', sans-serif">
    <div class="row">
        <div class="d-xxl-flex">
            <div class="col-xxl-3 mb-xxl-3 mt-5">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="text-center pt-2 col-12">
                                Tambah Data
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <label for="exampleFormControlInput1" class="form-label">Nama Alternatif</label>
                                <input type="text" name="nama_alternatif" class="form-control"
                                    id="exampleFormControlInput1" required placeholder="Nama Alternatif" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" name="latitude" required class="form-control" id="latitude"
                                    placeholder="Latitude" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" name="longitude" required class="form-control" id="longitude"
                                    placeholder="Longitude" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="exampleFormControlInput1" class="form-label">Alamat</label>
                                <textarea class="form-control" required placeholder="Alamat..."
                                    name="alamat"></textarea>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="rating" class="form-label">Rating</label>
                                <input type="number" max="5" name="rating" required class="form-control" id="rating"
                                    placeholder="0" />
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="biaya" class="form-label">Biaya</label>
                                <select class="form-select" name="biaya" required aria-label="Default select example">
                                    <option value="">-- Biaya --</option>
                                    <?php foreach ($getSubBiaya as $key => $biaya):?>
                                    <option value="<?=$biaya['id_sub_kriteria'];?>">
                                        <?=$biaya['spesifikasi'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="fasilitas" class="form-label">Fasilitas</label>
                                <select class="form-select" name="fasilitas" required
                                    aria-label="Default select example">
                                    <option value="">-- Pilih Fasilitas --</option>
                                    <?php foreach ($getSubFasilitas as $key => $fasilitas):?>
                                    <option value="<?=$fasilitas['id_sub_kriteria'];?>">
                                        <?=$fasilitas['spesifikasi'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="jarak" class="form-label">Jarak Pusat Kota</label>
                                <select class="form-select" name="jarak" required aria-label="Default select example">
                                    <option value="">-- Jarak --</option>
                                    <?php foreach ($getSubPusatKota as $key => $jarak):?>
                                    <option value="<?=$jarak['id_sub_kriteria'];?>">
                                        <?=$jarak['spesifikasi'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>

                            <div class="mb-3 mt-3">
                                <label for="jumlah-pengunjung" class="form-label">Jumlah Pengunjung</label>
                                <select class="form-select" name="jumlah-pengunjung" required
                                    aria-label="Default select example">
                                    <option value="">-- Jumlah Pengunjung --</option>
                                    <?php foreach ($getSubJumlahPengunjung as $key => $jumlahPengunjung):?>
                                    <option value="<?=$jumlahPengunjung['id_sub_kriteria'];?>">
                                        <?=$jumlahPengunjung['spesifikasi'];?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="gambar" class="form-label">Gambar</label>
                                <input type="file" accept=".jpg,.jpeg,.png" class="form-control" name="gambar"
                                    id="gambar" required />
                            </div>

                            <button type="submit" name="simpan" class="btn col-12 btn-outline-secondary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-xxl-9 mt-5 ms-xxl-5">
                <div class="card">
                    <div class="card-header">DAFTAR ALTERNATIF</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%"
                                id="table-penilaian">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Gambar</th>
                                        <th scope="col">Nama Alternatif</th>
                                        <th scope="col">Latitude</th>
                                        <th scope="col">Longitude</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Biaya masuk</th>
                                        <th scope="col">Fasilitas</th>
                                        <th scope="col">Jarak dari pusat kota</th>
                                        <th scope="col">Jumlah pengunjung</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php foreach ($dataAlternatif as $i => $alternatif):?>
                                    <tr>
                                        <th scope="row"><?=$i+1;?></th>
                                        <td><a href="../user_area/gambar/<?= $alternatif['gambar'] == '-'? 'no-img.png': $alternatif['gambar'];?>"
                                                data-lightbox="image-1"
                                                data-title="<?= $alternatif['nama_alternatif']; ?>"><img
                                                    style="width:100px; height:100px;"
                                                    src="../user_area/gambar/<?= $alternatif['gambar'] == '-'? 'no-img.png': $alternatif['gambar']; ?>"
                                                    alt=""></a>
                                        </td>
                                        <td><?=$alternatif['nama_alternatif'];?></td>
                                        <td><?=$alternatif['latitude'];?></td>
                                        <td><?=$alternatif['longitude'];?></td>
                                        <td><?=$alternatif['alamat'];?></td>
                                        <td><?=$alternatif['spesifikasi_C1'];?></td>
                                        <td><?=$alternatif['spesifikasi_C2'];?></td>
                                        <td><?=$alternatif['spesifikasi_C3'];?></td>
                                        <td><?=$alternatif['spesifikasi_C4'];?></td>
                                        <td>

                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#edit<?=$alternatif['id_alternatif'];?>">
                                                Edit
                                            </button>
                                            <a href="https://www.google.com/maps/dir/?api=1&destination=<?=$alternatif['latitude'];?>,<?=$alternatif['longitude'];?>"
                                                title="Lokasi di MAPS" target="_blank" class="btn btn-sm btn-success">ke
                                                Maps</a>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#hapus<?=$alternatif['id_alternatif'];?>">
                                                Hapus
                                            </button>
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

<?php foreach ($dataAlternatif as $alternatif):?>
<div class="modal fade" id="edit<?=$alternatif['id_alternatif'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" enctype="multipart/form-data">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal edit</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" name="id_alternatif" value="<?=$alternatif['id_alternatif'];?>">
                <div class="modal-body">
                    <div class="card-body">
                        <div class="mb-3 mt-3">
                            <label for="exampleFormControlInput1" class="form-label">Nama Alternatif</label>
                            <input type="text" class="form-control" required name="nama_alternatif"
                                value="<?=$alternatif['nama_alternatif'];?>" id="exampleFormControlInput1"
                                placeholder="Nama Alternatif" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" value="<?=$alternatif['latitude'];?>"
                                name="latitude" id="latitude" required placeholder="Latitude" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" value="<?=$alternatif['longitude'];?>"
                                name="longitude" id="longitude" required placeholder="Longitude" />
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" required name="alamat"><?=$alternatif['alamat'];?></textarea>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="rating" class="form-label">Rating</label>
                        <input type="number" max="5" value="<?=$alternatif['rating'];?>" name="rating" required
                            class="form-control" id="rating" placeholder="0" />
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="biaya" class="form-label">Biaya</label>
                        <select class="form-select" name="biaya" required aria-label="Default select example">
                            <option value="">-- Biaya --</option>
                            <?php foreach ($getSubBiaya as $key => $biaya):?>
                            <option <?=$biaya['id_sub_kriteria'] == $alternatif['id_sub_C1'] ? 'selected':'';?>
                                value="<?=$biaya['id_sub_kriteria'];?>">
                                <?=$biaya['spesifikasi'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="fasilitas" class="form-label">Fasilitas</label>
                        <select class="form-select" name="fasilitas" required aria-label="Default select example">
                            <option value="">-- Pilih Fasilitas --</option>
                            <?php foreach ($getSubFasilitas as $key => $fasilitas):?>
                            <option <?=$fasilitas['id_sub_kriteria'] == $alternatif['id_sub_C2'] ? 'selected':'';?>
                                value="<?=$fasilitas['id_sub_kriteria'];?>">
                                <?=$fasilitas['spesifikasi'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="jarak" class="form-label">Jarak Pusat Kota</label>
                        <select class="form-select" name="jarak" required aria-label="Default select example">
                            <option value="">-- Jarak --</option>
                            <?php foreach ($getSubPusatKota as $key => $jarak):?>
                            <option <?=$jarak['id_sub_kriteria'] == $alternatif['id_sub_C3'] ? 'selected':'';?>
                                value="<?=$jarak['id_sub_kriteria'];?>">
                                <?=$jarak['spesifikasi'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="mb-3 mt-3">
                        <label for="jumlah-pengunjung" class="form-label">Jumlah Pengunjung</label>
                        <select class="form-select" name="jumlah-pengunjung" required
                            aria-label="Default select example">
                            <option value="">-- Jumlah Pengunjung --</option>
                            <?php foreach ($getSubJumlahPengunjung as $key => $jumlahPengunjung):?>
                            <option
                                <?= $jumlahPengunjung['id_sub_kriteria'] == $alternatif['id_sub_C4'] ? 'selected':'';?>
                                value="<?=$jumlahPengunjung['id_sub_kriteria'];?>">
                                <?=$jumlahPengunjung['spesifikasi'];?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 mt-3">
                            <input type="hidden" name="gambar_lama" value="<?=$alternatif['gambar'];?>">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" accept=".jpg,.jpeg,.png" class="form-control" name="gambar"
                                id="gambar" />
                            <?php if($alternatif['gambar'] == '-'):?>
                            <img class="mt-2" style="width: 150px; height:150px;" src="../user_area/gambar/gereja.jpg"
                                alt="">
                            <?php else:?>
                            <img class="mt-2" style="width: 150px; height:150px;"
                                src="../user_area/gambar/<?=$alternatif['gambar'];?>" alt="">
                            <?php endif;?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="edit" class="btn btn-outline-primary">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php foreach ($dataAlternatif as $alternatif):?>
<div class="modal fade" id="hapus<?=$alternatif['id_alternatif'];?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <input type="hidden" name="id_alternatif" value="<?=$alternatif['id_alternatif'];?>">
                <div class="modal-body">
                    <p>Anda yakin ingin menghapus alternatif <strong>
                            <?=$alternatif['nama_alternatif'];?></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="hapus" class="btn btn-outline-primary">
                        Hapus
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach;?>
<?php 
require_once './footer.php';
?>