-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Agu 2023 pada 06.17
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_pem_wisata`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alternatif` int(5) NOT NULL,
  `nama_alternatif` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `rating` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `alternatif`
--

INSERT INTO `alternatif` (`id_alternatif`, `nama_alternatif`, `alamat`, `gambar`, `latitude`, `longitude`, `rating`) VALUES
(2, 'Kampung adat Boti', '-', '-', '-9.56522781556891', '124.23324709489728', 1),
(3, 'Gunung Mutis', '-', '-', '-9.565125658547931', '124.18302099829398', 2),
(4, 'Fatumnasi', '-', '-', '-9.712473063953183', ' 124.22802736659872', 1),
(5, 'Fatunausus', '-', '-', '-9.802771229973178', ' 124.30737749543702', 1),
(6, 'Air Terjun Oehala', '-', '-', '-9.62871123927298', ' 124.63119345208362', 1),
(7, 'Fatukopa', '-', '-', '-9.979412177412835', ' 124.5182035605519', 1),
(8, 'Kolbano', '-', '-', '-10.154238976191714', ' 124.31347258714773', 1),
(9, 'Oetune', '-', '-', '-9.833087380993256', ' 124.41281113776452', 1),
(10, 'Benteng Nonef', '-', '-', '-9.847900321615707', ' 124.26583459729325', 1),
(11, 'Taman Bu\'at', '-', '-', '-9.90892879933305', ' 124.53599478383306', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_kriteria`
--

CREATE TABLE `bobot_kriteria` (
  `id_bobot` int(11) NOT NULL,
  `C1` float NOT NULL,
  `C2` float NOT NULL,
  `C3` float NOT NULL,
  `C4` float NOT NULL,
  `C5` float NOT NULL,
  `f_id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bobot_kriteria`
--

INSERT INTO `bobot_kriteria` (`id_bobot`, `C1`, `C2`, `C3`, `C4`, `C5`, `f_id_user`) VALUES
(1, 0.25, 0.2, 0.15, 0.2, 0.2, 2),
(3, 0.25, 0.2, 0.2, 0.15, 0.2, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kriteria`
--

CREATE TABLE `jenis_kriteria` (
  `id_jenis_kriteria` int(5) NOT NULL,
  `jenis` enum('cost','benefit') NOT NULL,
  `f_id_kriteria` char(2) NOT NULL,
  `f_id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_kriteria`
--

INSERT INTO `jenis_kriteria` (`id_jenis_kriteria`, `jenis`, `f_id_kriteria`, `f_id_user`) VALUES
(86, 'cost', 'C1', 2),
(87, 'benefit', 'C2', 2),
(88, 'cost', 'C3', 2),
(89, 'benefit', 'C4', 2),
(90, 'benefit', 'C5', 2),
(91, 'cost', 'C1', 3),
(92, 'benefit', 'C2', 3),
(93, 'cost', 'C3', 3),
(94, 'benefit', 'C4', 3),
(95, 'benefit', 'C5', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kecocokan_alt_kriteria`
--

CREATE TABLE `kecocokan_alt_kriteria` (
  `id_alt_kriteria` int(11) NOT NULL,
  `f_id_alternatif` int(5) NOT NULL,
  `f_id_kriteria` char(2) NOT NULL,
  `f_id_sub_kriteria` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kecocokan_alt_kriteria`
--

INSERT INTO `kecocokan_alt_kriteria` (`id_alt_kriteria`, `f_id_alternatif`, `f_id_kriteria`, `f_id_sub_kriteria`) VALUES
(1, 3, 'C1', 1),
(2, 3, 'C2', 8),
(3, 3, 'C3', 13),
(4, 3, 'C4', 18),
(5, 3, 'C5', 22),
(6, 4, 'C1', 1),
(7, 4, 'C2', 7),
(8, 4, 'C3', 13),
(9, 4, 'C4', 16),
(10, 4, 'C5', 22),
(11, 5, 'C1', 1),
(12, 5, 'C2', 9),
(13, 5, 'C3', 13),
(14, 5, 'C4', 19),
(15, 5, 'C5', 23),
(16, 6, 'C1', 1),
(17, 6, 'C2', 8),
(18, 6, 'C3', 12),
(19, 6, 'C4', 18),
(20, 6, 'C5', 21),
(21, 7, 'C1', 1),
(22, 7, 'C2', 10),
(23, 7, 'C3', 14),
(24, 7, 'C4', 19),
(25, 7, 'C5', 25),
(26, 8, 'C1', 1),
(27, 8, 'C2', 7),
(28, 8, 'C3', 15),
(29, 8, 'C4', 17),
(30, 8, 'C5', 21),
(31, 9, 'C1', 1),
(32, 9, 'C2', 8),
(33, 9, 'C3', 15),
(34, 9, 'C4', 19),
(35, 9, 'C5', 21),
(36, 10, 'C1', 1),
(37, 10, 'C2', 9),
(38, 10, 'C3', 13),
(39, 10, 'C4', 20),
(40, 10, 'C5', 24),
(41, 11, 'C1', 2),
(42, 11, 'C2', 8),
(43, 11, 'C3', 12),
(44, 11, 'C4', 17),
(45, 11, 'C5', 21),
(46, 2, 'C1', 1),
(47, 2, 'C2', 8),
(48, 2, 'C3', 13),
(49, 2, 'C4', 20),
(50, 2, 'C5', 25);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` char(2) NOT NULL,
  `nama_kriteria` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id_kriteria`, `nama_kriteria`) VALUES
('C1', 'Biaya masuk'),
('C2', 'Fasilitas'),
('C3', 'Jarak dari pusat kota'),
('C4', 'Jumlah pengunjung'),
('C5', 'Kualitas jalan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_user`
--

CREATE TABLE `login_user` (
  `id_login` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `login_user`
--

INSERT INTO `login_user` (`id_login`, `username`, `password`, `level`) VALUES
(1, 'admin', '$2y$10$o9rw1S2HbWQolaKF3XKDdeu2B4fsebEq35Ca0KTwmytsi3tud1HCC', 0),
(2, 'yupi', '$2y$10$xrlDvgFGBGHxPTRdSzhYHOUA3TEDSiLcgVElMjwO2IufeGbvfW4DW', 1),
(3, 'yupi3', '$2y$10$76ZuNQF.YASVnv99HAYHkeZ1T1Zd4hXX0sPbc/fbQG43yMdR8wQqy', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id_sub_kriteria` int(5) NOT NULL,
  `nama_sub_kriteria` varchar(25) NOT NULL,
  `spesifikasi` text NOT NULL,
  `bobot_sub_kriteria` int(5) NOT NULL,
  `f_id_kriteria` char(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id_sub_kriteria`, `nama_sub_kriteria`, `spesifikasi`, `bobot_sub_kriteria`, `f_id_kriteria`) VALUES
(1, 'Sangat murah', 'Rp. 0 - 10.000', 5, 'C1'),
(2, 'Murah', 'Rp. >10.000 - 25.000', 4, 'C1'),
(3, 'Sedang', 'Rp. >25.000 - 50.000', 3, 'C1'),
(4, 'Mahal', 'Rp. >50.000 - 100.000', 2, 'C1'),
(5, 'Sangat mahal', '> Rp.100.000', 1, 'C1'),
(6, 'Sangat lengkap', 'Jika memenuhi 5 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo.', 5, 'C2'),
(7, 'Lengkap', 'Jika memenuhi 4 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo.', 4, 'C2'),
(8, 'Cukup lengkap', 'Jika memenuhi 3 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo. ', 3, 'C2'),
(9, 'Kurang lengkap', 'Jika memenuhi 2 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo.', 2, 'C2'),
(10, 'Tidak lengkap', 'Jika memenuhi 1 item dari fasilitas berikut ini: Kamar mandi, tempat parkir, area food court, tempat sampah, gazebo.', 1, 'C2'),
(11, 'Sangat dekat', '0 - 5 Km', 5, 'C3'),
(12, 'Dekat', '> 5 - 20 Km', 4, 'C3'),
(13, 'Sedang', '> 20 - 50 Km', 3, 'C3'),
(14, 'Jauh', '> 50 - 75 Km', 2, 'C3'),
(15, 'Sangat jauh', '> 75 - 134 Km', 1, 'C3'),
(16, 'Sangat banyak', '>100 Orang', 5, 'C4'),
(17, 'Banyak', '76-100 Orang', 4, 'C4'),
(18, 'Sedang', '51-75 Orang', 3, 'C4'),
(19, 'Sedikit', '26-50 Orang', 2, 'C4'),
(20, 'Sangat sedikit', '5-25 Orang', 1, 'C4'),
(21, 'Sangat baik', 'Aspal', 5, 'C5'),
(22, 'Baik', 'Aspal (sedikit berlubang)', 4, 'C5'),
(23, 'Cukup baik', 'Tanah Putih', 3, 'C5'),
(24, 'Buruk', 'Aspal (banyak lubang)', 2, 'C5'),
(25, 'Sangat Buruk', 'Batu Lepas', 1, 'C5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_tampung`
--

CREATE TABLE `tabel_tampung` (
  `id` int(11) NOT NULL,
  `prio1` varchar(50) NOT NULL,
  `prio2` varchar(50) NOT NULL,
  `prio3` varchar(50) NOT NULL,
  `prio4` varchar(50) NOT NULL,
  `prio5` varchar(50) NOT NULL,
  `f_id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tabel_tampung`
--

INSERT INTO `tabel_tampung` (`id`, `prio1`, `prio2`, `prio3`, `prio4`, `prio5`, `f_id_user`) VALUES
(3, 'Biaya masuk', 'Fasilitas', 'Jumlah pengunjung', 'Kualitas jalan', 'Jarak dari pusat kota', 3);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alternatif`);

--
-- Indeks untuk tabel `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD PRIMARY KEY (`id_bobot`),
  ADD KEY `f_id_user` (`f_id_user`);

--
-- Indeks untuk tabel `jenis_kriteria`
--
ALTER TABLE `jenis_kriteria`
  ADD PRIMARY KEY (`id_jenis_kriteria`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`),
  ADD KEY `f_id_user` (`f_id_user`);

--
-- Indeks untuk tabel `kecocokan_alt_kriteria`
--
ALTER TABLE `kecocokan_alt_kriteria`
  ADD PRIMARY KEY (`id_alt_kriteria`),
  ADD KEY `f_id_alternatif` (`f_id_alternatif`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`),
  ADD KEY `f_id_sub_kriteria` (`f_id_sub_kriteria`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indeks untuk tabel `login_user`
--
ALTER TABLE `login_user`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id_sub_kriteria`),
  ADD KEY `f_id_kriteria` (`f_id_kriteria`);

--
-- Indeks untuk tabel `tabel_tampung`
--
ALTER TABLE `tabel_tampung`
  ADD PRIMARY KEY (`id`),
  ADD KEY `f_id_user` (`f_id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id_alternatif` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  MODIFY `id_bobot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `jenis_kriteria`
--
ALTER TABLE `jenis_kriteria`
  MODIFY `id_jenis_kriteria` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `kecocokan_alt_kriteria`
--
ALTER TABLE `kecocokan_alt_kriteria`
  MODIFY `id_alt_kriteria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `login_user`
--
ALTER TABLE `login_user`
  MODIFY `id_login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id_sub_kriteria` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `tabel_tampung`
--
ALTER TABLE `tabel_tampung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bobot_kriteria`
--
ALTER TABLE `bobot_kriteria`
  ADD CONSTRAINT `bobot_kriteria_ibfk_1` FOREIGN KEY (`f_id_user`) REFERENCES `login_user` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jenis_kriteria`
--
ALTER TABLE `jenis_kriteria`
  ADD CONSTRAINT `jenis_kriteria_ibfk_1` FOREIGN KEY (`f_id_user`) REFERENCES `login_user` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jenis_kriteria_ibfk_2` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `kecocokan_alt_kriteria`
--
ALTER TABLE `kecocokan_alt_kriteria`
  ADD CONSTRAINT `kecocokan_alt_kriteria_ibfk_1` FOREIGN KEY (`f_id_sub_kriteria`) REFERENCES `sub_kriteria` (`id_sub_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kecocokan_alt_kriteria_ibfk_2` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kecocokan_alt_kriteria_ibfk_3` FOREIGN KEY (`f_id_alternatif`) REFERENCES `alternatif` (`id_alternatif`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD CONSTRAINT `sub_kriteria_ibfk_1` FOREIGN KEY (`f_id_kriteria`) REFERENCES `kriteria` (`id_kriteria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tabel_tampung`
--
ALTER TABLE `tabel_tampung`
  ADD CONSTRAINT `tabel_tampung_ibfk_1` FOREIGN KEY (`f_id_user`) REFERENCES `login_user` (`id_login`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
