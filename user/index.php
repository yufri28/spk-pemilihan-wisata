<?php 
session_start();
unset($_SESSION['menu']);
$_SESSION['menu'] = 'beranda-user';
require_once './../includes/header.php';
$alternatif = $koneksi->query("SELECT a.nama_alternatif, a.id_alternatif, a.gambar, a.latitude, a.longitude,
MAX(CASE WHEN k.id_kriteria = 'C1' THEN kak.id_alt_kriteria END) AS id_sub_C1,
MIN(CASE WHEN k.id_kriteria = 'C2' THEN kak.id_alt_kriteria END) AS id_sub_C2,
MIN(CASE WHEN k.id_kriteria = 'C3' THEN kak.id_alt_kriteria END) AS id_sub_C3,
MAX(CASE WHEN k.id_kriteria = 'C4' THEN kak.id_alt_kriteria END) AS id_sub_C4,
MAX(CASE WHEN k.id_kriteria = 'C5' THEN kak.id_alt_kriteria END) AS id_sub_C5,
MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.nama_sub_kriteria END) AS nama_C1,
MIN(CASE WHEN k.id_kriteria = 'C2' THEN sk.nama_sub_kriteria END) AS nama_C2,
MIN(CASE WHEN k.id_kriteria = 'C3' THEN sk.nama_sub_kriteria END) AS nama_C3,
MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.nama_sub_kriteria END) AS nama_C4,
MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.nama_sub_kriteria END) AS nama_C5,
MAX(CASE WHEN k.id_kriteria = 'C1' THEN sk.spesifikasi END) AS spesifikasi_C1,
MIN(CASE WHEN k.id_kriteria = 'C2' THEN sk.spesifikasi END) AS spesifikasi_C2,
MIN(CASE WHEN k.id_kriteria = 'C3' THEN sk.spesifikasi END) AS spesifikasi_C3,
MAX(CASE WHEN k.id_kriteria = 'C4' THEN sk.spesifikasi END) AS spesifikasi_C4,
MAX(CASE WHEN k.id_kriteria = 'C5' THEN sk.spesifikasi END) AS spesifikasi_C5
FROM alternatif a
JOIN kecocokan_alt_kriteria kak ON a.id_alternatif = kak.f_id_alternatif
JOIN sub_kriteria sk ON kak.f_id_sub_kriteria = sk.id_sub_kriteria
JOIN kriteria k ON kak.f_id_kriteria = k.id_kriteria
GROUP BY a.nama_alternatif;");



// jika belum ada data jenis kriteria

$cekJenisKriteria = $koneksi->query("SELECT * FROM jenis_kriteria WHERE f_id_user='$id_user'");
if(mysqli_num_rows($cekJenisKriteria) < 1){
    $_SESSION['warning'] = "Apakah anda suka dengan tempat wisata yang ramai?";
}

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
<?php if (isset($_SESSION['warning'])): ?>
<script>
const cost = 'cost';
const benefit = 'benefit';
const c4 = '';
Swal.fire({
    title: 'Berikan jawaban yang sesuai!',
    text: '<?php echo $_SESSION['warning']; ?>',
    icon: 'warning',
    showDenyButton: true,
    confirmButtonText: 'Ya',
    denyButtonText: 'Tidak',
    allowOutsideClick: false,
}).then(function(result) {

    if (result.isConfirmed) {
        Swal.fire(
            'Sukses!',
            'Terima kasih atas jawabannya!',
            'success'
        )
        postData('benefit');
    } else {
        Swal.fire(
            'Sukses!',
            'Terima kasih atas jawabannya!',
            'success'
        )
        postData('cost');
    }

    function postData(c4) {
        const url = './jenis_kriteria.php';
        const data = {
            C1: cost,
            C2: benefit,
            C3: cost,
            C4: c4,
            C5: benefit
        };

        fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then((responseData) => {
                console.log(responseData);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

});
</script>
<?php unset($_SESSION['warning']); // Menghapus session setelah ditampilkan ?>
<?php endif; ?>

<div class="container">
    <div class="row">
        <div class="col-12 mt-3 mb-5">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8 gx-lg-10 text-center">
                    <div class="title">
                        <h3>SISTEM PENDUKUNG KEPUTUSAN REKOMENDASI TEMPAT WISATA DI KABUPATEN TIMOR TENGAH SELATAN</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div id="mapid"></div>
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
foreach ($alternatif as $location) {
    if ($location['latitude'] != '-' && $location['longitude'] != '-') {
        echo "var marker = L.marker([" . $location['latitude'] . "," . $location['longitude'] . "]).addTo(mymap);";
        if ($location['gambar'] == '-') {
            echo "marker.bindPopup('<div class=\"custom-popup\"><img src=\"../user/gambar/" . "no-img.png" . "\" width=\"210\" height=\"150\"><br><b>" . htmlspecialchars($location['nama_alternatif']) . "</b><br><div style=\"word-wrap: break-word;width:200px\">Biaya masuk : " . $location['spesifikasi_C1'] . "<br>Fasilitas : " . $location['spesifikasi_C2'] . "<br>Jarak dari pusat kota : " . $location['spesifikasi_C3'] . "<br>Jumlah pengunjung : " . $location['spesifikasi_C4'] . "<br>Kualitas jalan : " . $location['spesifikasi_C5'] . "<br></div></div>', {className:'custom-popup'}).openPopup();";
        } else {
            echo "marker.bindPopup('<div class=\"custom-popup\"><img src=\"../user/gambar/" . $location['gambar'] . "\" width=\"200\" height=\"150\"><br><b>" . htmlspecialchars($location['nama_alternatif']) . "</b><br><div style=\"word-wrap: break-word;\">Biaya masuk : " . $location['spesifikasi_C1'] . "<br>Fasilitas : " . $location['spesifikasi_C2'] . "<br>Jarak dari pusat kota : " . $location['spesifikasi_C3'] . "<br>Jumlah pengunjung : " . $location['spesifikasi_C4'] . "<br>Kualitas jalan : " . $location['spesifikasi_C5'] . "<br></div></div>', {className:'custom-popup'}).openPopup();";
        }
    }
}
?>
</script>

<style>
.custom-popup {
    width: 250px;
    /* Sesuaikan lebar popup sesuai dengan kebutuhan Anda */
    white-space: pre-wrap;
    /* Membuat teks wrap jika melewati batas popup */
    text-align: left;
    /* Untuk membuat teks di dalam popup menjadi rata kiri */
}
</style>