<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'jenis-kriteria';
require_once './../includes/header.php';
require_once './classes/jenis_kriteria.php';
require_once './classes/kriteria.php';
// $id_user = $_SESSION['id_user'];


if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['simpan'])){ 
        $dataJenisKriteria = [
            'C1' => htmlspecialchars($_POST['C1']),
            'C2' => htmlspecialchars($_POST['C2']),
            'C3' => htmlspecialchars($_POST['C3']),
            'C4' => htmlspecialchars($_POST['C4']),
            'C5' => htmlspecialchars($_POST['C5'])
        ];
        $JenisKriteria->tambahJenisKriteria($dataJenisKriteria,$id_user);
    }else if(isset($_POST['edit'])){
        $id_jenis_kriteria = htmlspecialchars($_POST['id_jenis_kriteria']);
        $jenis_kriteria = htmlspecialchars($_POST['jenis_kriteria']);
        $dataKriteria = [
           "id_jenis_kriteria" => $id_jenis_kriteria,
           "jenis_kriteria" => $jenis_kriteria
        ];
        $JenisKriteria->editJenisKriteria($dataKriteria);
    }
    else if(isset($_POST['hapus'])){
        $id_jenis_kriteria = $_POST['id_jenis_kriteria'];
        $JenisKriteria->hapusJenisKriteria($id_jenis_kriteria);
    }
    else{
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
    
        $dataJenisKriteria = [
            'C1' => htmlspecialchars($data['C1']),
            'C2' => htmlspecialchars($data['C2']),
            'C3' => htmlspecialchars($data['C3']),
            'C4' => htmlspecialchars($data['C4']),
            'C5' => htmlspecialchars($data['C5'])
        ];
        $JenisKriteria->tambahJenisKriteria($dataJenisKriteria,$id_user);
    }
}

$data_jenis_kriteria = $JenisKriteria->getJenisKriteria($id_user);
$data_kriteria = $Kriteria->getKriteria();
?>
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
            <?php if(mysqli_num_rows($data_jenis_kriteria) < 1) :?>
            <div class="col-xxl-3 mb-xxl-3 mt-5">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 class="text-center text-white pt-2 col-12 btn-outline-primary">
                            Tambah Jenis Kriteria
                        </h5>
                    </div>
                    <form method="post" action="">
                        <div class="card-body">
                            <div class="alert alert-warning" role="alert">
                                <small><strong>cost</strong> : Jika nilai kriteria semakin kecil, maka semakin baik.
                                    Contohnya, dalam hal biaya masuk, semakin kecil atau lebih murah biaya masuknya,
                                    semakin baik.</small><br>
                                <small><strong>benefit</strong> : Jika nilai kriteria semakin besar, maka semakin baik.
                                    Sebagai contoh, dalam hal fasilitas, semakin banyak fasilitas yang ditawarkan,
                                    semakin baik.</small>
                            </div>
                            <?php foreach($data_kriteria as $kriteria):?>
                            <div class="mb-3 mt-3">
                                <label for="jenis_kriteria" class="form-label">Kriteria
                                    <?=$kriteria['nama_kriteria'];?></label>
                                <select class="form-select" id="jenis_kriteria" name="<?=$kriteria['id_kriteria'];?>">
                                    <option value="">-- Pilih Jenis Kriteria --</option>
                                    <option value="cost">cost</option>
                                    <option value="benefit">benefit</option>
                                </select>
                            </div>
                            <?php endforeach;?>
                            <button type="submit" name="simpan" class="btn col-12 btn-outline-primary">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif;?>
            <div
                class="<?= mysqli_num_rows($data_jenis_kriteria) < 1 ? "col-xxl-9 ms-xxl-3":"col-xxl-12 ms-xxl-2"; ?> mt-5">
                <div class="card">
                    <div class="card-header bg-primary text-white">DAFTAR JENIS KRITERIA</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Jenis Kriteria</th>
                                        <th scope="col">Kode Kriteria</th>
                                        <th scope="col">Nama Kriteria</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php foreach ($data_jenis_kriteria as $key => $kriteria):?>
                                    <tr>
                                        <th scope="row"><?=$key+1;?></th>
                                        <td scope="row"><?=$kriteria['jenis'];?></td>
                                        <td scope="row"><?=$kriteria['f_id_kriteria'];?></td>
                                        <td><?=$kriteria['nama_kriteria'];?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#edit<?=$kriteria['id_kriteria'];?>">
                                                Edit
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

    <?php foreach ($data_jenis_kriteria as $key => $jenis_kriteria):?>
    <div class="modal fade" id="edit<?=$jenis_kriteria['id_kriteria'];?>" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Jenis Kriteria</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <!-- <label for="id_kriteria" class="form-label">Kode Kriteria</label> -->
                                <input class="form-control" value="<?=$jenis_kriteria['id_jenis_kriteria'];?>" required
                                    name="id_jenis_kriteria" type="hidden">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <label for="nama_kriteria" class="form-label">Nama Kriteria</label>
                                <input class="form-control" value="<?=$jenis_kriteria['nama_kriteria'];?>" required
                                    name="nama_kriteria" disabled type="text" placeholder="Nama Kriteria"
                                    aria-label="default input example">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <label for="jenis_kriteria" class="form-label">Kriteria
                                    <?=$kriteria['nama_kriteria'];?></label>
                                <select class="form-select" id="jenis_kriteria" name="jenis_kriteria">
                                    <option value="">-- Pilih Jenis Kriteria --</option>
                                    <option <?=$jenis_kriteria['jenis'] == 'cost' ? 'selected':'';?> value="cost">cost
                                    </option>
                                    <option <?=$jenis_kriteria['jenis'] == 'benefit' ? 'selected':'';?> value="benefit">
                                        benefit
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="edit" class="btn btn-outline-primary">
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endforeach;?>
</div>

<?php 
 require_once './../includes/footer.php';
?>