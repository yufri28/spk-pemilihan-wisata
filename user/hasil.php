<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'hasil';
require_once './../includes/header.php';
$id_user = $_SESSION['id_user'];

$selectBobot = $koneksi->query("SELECT * FROM bobot_kriteria WHERE f_id_user='$id_user'");

if(mysqli_num_rows($selectBobot) <= 0){
     $_SESSION['error-bobot'] = 'Harap mengisi data bobot kriteria terlebih dahulu!';
}


$jenisKriteriaC1 = mysqli_fetch_assoc($koneksi->query("SELECT jenis FROM jenis_kriteria WHERE f_id_kriteria='C1' AND f_id_user=$id_user"));
$jenisKriteriaC2 = mysqli_fetch_assoc($koneksi->query("SELECT jenis FROM jenis_kriteria WHERE f_id_kriteria='C2' AND f_id_user=$id_user"));
$jenisKriteriaC3 = mysqli_fetch_assoc($koneksi->query("SELECT jenis FROM jenis_kriteria WHERE f_id_kriteria='C3' AND f_id_user=$id_user"));
$jenisKriteriaC4 = mysqli_fetch_assoc($koneksi->query("SELECT jenis FROM jenis_kriteria WHERE f_id_kriteria='C4' AND f_id_user=$id_user"));
$jenisKriteriaC5 = mysqli_fetch_assoc($koneksi->query("SELECT jenis FROM jenis_kriteria WHERE f_id_kriteria='C5' AND f_id_user=$id_user"));
$c1 = $jenisKriteriaC1['jenis'];
$c2 = $jenisKriteriaC2['jenis'];
$c3 = $jenisKriteriaC3['jenis'];
$c4 = $jenisKriteriaC4['jenis'];
$c5 = $jenisKriteriaC5['jenis'];
$norm = $koneksi->query("SELECT 
a.nama_alternatif, 
a.id_alternatif,
a.latitude,
a.longitude,
a.alamat,
a.gambar,
MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END) AS C1,
MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END) AS C2,
MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END) AS C3,
MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END) AS C4,
MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.bobot_sub_kriteria END) AS C5,
MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.spesifikasi END) AS namaC1,
MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.spesifikasi END) AS namaC2,
MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.spesifikasi END) AS namaC3,
MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.spesifikasi END) AS namaC4,
MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.spesifikasi END) AS namaC5,

(MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C1' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria) * (SELECT C1 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C1,

(MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C2' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C2 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C2,

(MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C3' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C3 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C3,

(MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C4' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C4 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C4,

(MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C5' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria) * (SELECT C5 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C5
FROM alternatif a
JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria
GROUP BY a.nama_alternatif, a.id_alternatif ORDER BY a.id_alternatif ASC;");


$ap_am = $koneksi->query(
    "SELECT 
    'A+' AS nama_alternatif,
    NULL AS id_alternatif,
    NULL AS C1,
    NULL AS C2,
    NULL AS C3,
    NULL AS C4,
    NULL AS C5,
    IF('$c1'='cost', MIN(norm_C1), MAX(norm_C1)) AS norm___C1,
    IF('$c2'='benefit', MAX(norm_C2), MIN(norm_C2)) AS norm___C2,
    IF('$c3'='cost', MIN(norm_C3), MAX(norm_C3)) AS norm___C3,
    IF('$c4'='benefit', MAX(norm_C4), MIN(norm_C4)) AS norm___C4,
    IF('$c5'='benefit', MAX(norm_C5), MIN(norm_C5)) AS norm___C5
FROM (
    SELECT 
        a.nama_alternatif, 
        a.id_alternatif,
        MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END) AS C1,
        MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END) AS C2,
        MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END) AS C3,
        MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END) AS C4,
        MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.bobot_sub_kriteria END) AS C5,
        MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.spesifikasi END) AS namaC1,
        MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.spesifikasi END) AS namaC2,
        MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.spesifikasi END) AS namaC3,
        MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.spesifikasi END) AS namaC4,
        MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.spesifikasi END) AS namaC5,
        (MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C1' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria) * (SELECT C1 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C1,
        (MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C2' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C2 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C2,
        (MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C3' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C3 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C3,
        (MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C4' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C4 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C4,
        (MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C5' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C5 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C5
    FROM alternatif a
    JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
    JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
    JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria
    GROUP BY a.nama_alternatif, a.id_alternatif
) AS t

UNION ALL

SELECT 
    'A-' AS nama_alternatif,
    NULL AS id_alternatif,
    NULL AS C1,
    NULL AS C2,
    NULL AS C3,
    NULL AS C4,
    NULL AS C5,
    IF('cost'='cost', MAX(norm_C1), MIN(norm_C1)) AS norm__C1,
    IF('benefit'='benefit', MIN(norm_C2), MAX(norm_C2)) AS norm__C2,
    IF('cost'='cost', MAX(norm_C3), MIN(norm_C3)) AS norm__C3,
    IF('benefit'='benefit', MIN(norm_C4), MAX(norm_C4)) AS norm__C4,
    IF('benefit'='benefit', MIN(norm_C5), MAX(norm_C5)) AS norm__C5
FROM (
    SELECT 
        a.nama_alternatif, 
        a.id_alternatif,
        MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END) AS C1,
        MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END) AS C2,
        MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END) AS C3,
        MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END) AS C4,
        MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.bobot_sub_kriteria END) AS C5,
        MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.spesifikasi END) AS namaC1,
        MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.spesifikasi END) AS namaC2,
        MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.spesifikasi END) AS namaC3,
        MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.spesifikasi END) AS namaC4,
        MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.spesifikasi END) AS namaC5,
        (MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C1' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria) * (SELECT C1 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C1,
        (MAX(CASE WHEN k.id_kriteria = 'C2' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C2' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C2 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C2,
        (MAX(CASE WHEN k.id_kriteria = 'C3' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C3' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C3 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C3,
        (MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C4' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C4 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C4,
        (MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.bobot_sub_kriteria END)/(SELECT SQRT(SUM(POW(CASE WHEN k.id_kriteria = 'C5' THEN 	  	  sk.bobot_sub_kriteria END, 2))) FROM alternatif a
        JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
        JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
        JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria)* (SELECT C5 FROM bobot_kriteria bk WHERE bk.f_id_user=$id_user)) AS norm_C5
    FROM alternatif a
    JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
    JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
    JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria
    GROUP BY a.nama_alternatif, a.id_alternatif
) AS t;"
);

$D_plus = 0;
$D_min = 0;
$d = 0;
$V = 0;
$kedekatan_rel = array(); 
foreach ($norm as $key => $value) {
    foreach ($ap_am as $keys => $values) {

        switch ($values['nama_alternatif']) {
            case "A+":
                $D_plus = sqrt(pow(($value['norm_C1'] - $values['norm___C1']),2)+pow(($value['norm_C2'] - $values['norm___C2']),2)+pow(($value['norm_C3'] - $values['norm___C3']),2)+pow(($value['norm_C4'] - $values['norm___C4']),2)+pow(($value['norm_C5'] - $values['norm___C5']),2));
                break;
            case "A-":
                $D_min = sqrt(pow(($value['norm_C1'] - $values['norm___C1']),2)+pow(($value['norm_C2'] - $values['norm___C2']),2)+pow(($value['norm_C3'] - $values['norm___C3']),2)+pow(($value['norm_C4'] - $values['norm___C4']),2)+pow(($value['norm_C5'] - $values['norm___C5']),2));
                break;
        }
    }
    $d = $D_plus + $D_min;
    $V = $D_min/($D_min+$D_plus);
    // echo $value['nama_alternatif'].' D: '.$V;
    // echo "<br>";


    array_push($kedekatan_rel,[
        'id_alternatif' => $value['id_alternatif'],
        'nama_alternatif' => $value['nama_alternatif'],
        'nilai_akhir' => $V,
        'nilai_d' => $d,
        'gambar' => $value['gambar'],
        'namaC1' => $value['namaC1'],
        'namaC2' => $value['namaC2'],
        'namaC3' => $value['namaC3'],
        'namaC4' => $value['namaC4'],
        'namaC5' => $value['namaC5'],
        'lat' => $value['latitude'],
        'long' => $value['longitude']
    ]);
    // $kedekatan_rel = [
    //     'nama_alternatif' => $value['nama_alternatif'],
    //     'nilai_akhir' => $V,
    // ]; 
}

function compareNilaiAkhir($a, $b) {
    if ($a['nilai_akhir'] == $b['nilai_akhir']) {
        return 0;
    }
    return ($a['nilai_akhir'] > $b['nilai_akhir']) ? -1 : 1;
}

// Menggunakan fungsi usort untuk mengurutkan array berdasarkan nilai_akhir
usort($kedekatan_rel, 'compareNilaiAkhir');

// Menampilkan hasil pengurutan
// foreach ($kedekatan_rel as $alternatif) {
//     echo "Id Alternatif: " . $alternatif['id_alternatif'] ." Nama Alternatif: " . $alternatif['nama_alternatif'] . ", Nilai Akhir: " . $alternatif['nilai_akhir'] . " Latitude: " .$alternatif['lat']. " Longitude: " .$alternatif['long']. "\n";
//     echo "<br>";
// }
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
<?php if (isset($_SESSION['error-bobot'])): ?>
<script>
var errorBobot = '<?php echo $_SESSION["error-bobot"]; ?>';

Swal.fire({
    title: 'Error!',
    text: errorBobot,
    icon: 'error',
    confirmButtonText: 'OK'
}).then(function(result) {
    if (result.isConfirmed) {
        window.location.href = './kriteria.php';
    }
});
</script>
<?php unset($_SESSION['error-bobot']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>

<div class="container" style="font-family: 'Prompt', sans-serif">
    <div class="row">
        <div class="d-xxl-flex">
            <div class="col-xxl-12 mt-3 ms-xxl-6 mb-1">
                <!-- <div class="card"> -->
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="mapid"></div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
                <div class="card mt-2">
                    <div class="card-header bg-primary text-white">Hasil Perengkingan</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" style="width:100%" id="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Ranking</th>
                                        <th scope="col">Nama Wisata</th>
                                        <th scope="col">Biaya Masuk</th>
                                        <th scope="col">Fasilitas</th>
                                        <th scope="col">Jarak Pusat Kota</th>
                                        <th scope="col">Jumlah Pengunjung</th>
                                        <th scope="col">Kualitas Jalan</th>
                                        <th scope="col">Nilai Akhir</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <?php foreach ($kedekatan_rel as $key => $value):?>
                                    <tr>
                                        <th scope="row"><?=$key+1;?></th>
                                        <td><?=$value['nama_alternatif']?></td>
                                        <td><?=$value['namaC1']?></td>
                                        <td><?=$value['namaC2']?></td>
                                        <td><?=$value['namaC3']?></td>
                                        <td><?=$value['namaC4']?></td>
                                        <td><?=$value['namaC5']?></td>
                                        <td><?=$value['nilai_akhir'];?></td>
                                        <td>
                                            <a href="https://www.google.com/maps/dir/?api=1&destination=<?=$value['lat'];?>,<?=$value['long'];?>"
                                                title="Lokasi di MAPS" class="btn btn-sm btn-success">Lokasi</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
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
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
var mymap = L.map('mapid').setView([-9.7847232, 124.1418834], 9.04);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(mymap);

<?php
      usort($kedekatan_rel, function($a, $b) {
          return $a['nilai_akhir'] <=> $b['nilai_akhir'];
      });
      $iconNumber = count($kedekatan_rel); // Angka awal untuk ikon (misalnya 1)
      foreach ($kedekatan_rel as $location) {
        if ($location['lat'] != '-' && $location['long'] != '-') {
            echo "var marker = L.marker([" . $location['lat'] . "," . $location['long'] . "]).addTo(mymap);";
            if ($location['gambar'] == '-') {
                echo "marker.bindPopup('<div class=\"custom-popup\"><img src=\"../user/gambar/" . "no-img.png" . "\" width=\"210\" height=\"150\"><br><b>" . $iconNumber.'. '.htmlspecialchars($location['nama_alternatif']) . "</b><br><div style=\"word-wrap: break-word;width:200px\">Biaya masuk : " . $location['namaC1'] . "<br>Fasilitas : " . $location['namaC2'] . "<br>Jarak dari pusat kota : " . $location['namaC3'] . "<br>Jumlah pengunjung : " . $location['namaC4'] . "<br>Kualitas jalan : " . $location['namaC5'] . "<br></div></div>', {className:'custom-popup'}).openPopup();";
            } else {
                echo "marker.bindPopup('<div class=\"custom-popup\"><img src=\"../user/gambar/" . $location['gambar'] . "\" width=\"200\" height=\"150\"><br><b>" . htmlspecialchars($location['nama_alternatif']) . "</b><br><div style=\"word-wrap: break-word;\">Biaya masuk : " . $location['namaC1'] . "<br>Fasilitas : " . $location['namaC2'] . "<br>Jarak dari pusat kota : " . $location['namaC3'] . "<br>Jumlah pengunjung : " . $location['namaC4'] . "<br>Kualitas jalan : " . $location['namaC5'] . "<br></div></div>', {className:'custom-popup'}).openPopup();";
            }
        }
        $iconNumber--;
    }
?>
</script>
<style>
.custom-icon {
    text-align: center;
    color: #EB455F;
    font-size: 16pt;
    font-weight: bold;
}
</style>