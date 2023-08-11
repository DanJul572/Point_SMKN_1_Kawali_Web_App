-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2021 at 11:56 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel-24`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `username`, `password`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', '$2y$10$OciCIoMnv5abMWLyxJUOFutRIf1uFzCKYwzThJJURUF8dWae17k3y', '5nObQurcy3kutMuN.jpg', '2020-11-07 22:43:48', '2020-11-21 09:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nama`, `nip`, `kode`, `created_at`, `updated_at`) VALUES
(1, 'Guru 1', '082119852422', 'saya', '2021-02-01 05:58:00', '2021-02-01 06:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'TKRO 1', '2020-11-07 16:07:36', '2020-11-07 16:07:36'),
(2, 'TKRO 2', '2020-11-07 16:07:42', '2020-11-09 19:45:04'),
(3, 'TKRO 3', '2020-11-07 16:07:49', '2020-11-07 16:07:49'),
(4, 'TKJ 1', '2020-11-07 16:10:30', '2020-11-07 16:10:30'),
(5, 'TKJ 2', '2020-11-07 16:11:02', '2020-11-07 16:11:02'),
(6, 'TKJ 3', '2020-11-07 16:11:54', '2020-11-07 16:11:54'),
(7, 'RPL 1', '2020-11-07 16:12:00', '2020-11-07 16:12:00'),
(8, 'RPL 2', '2020-11-07 16:12:03', '2020-11-07 16:12:03'),
(9, 'OTKP 1', '2020-11-07 16:12:08', '2020-11-07 16:12:08'),
(10, 'OTKP 2', '2020-11-07 16:12:14', '2020-11-07 16:12:14'),
(11, 'OTKP 3', '2020-11-07 16:12:18', '2020-11-07 16:12:18'),
(12, 'AKL 1', '2020-11-07 16:12:21', '2020-11-07 16:12:21'),
(13, 'AKL 2', '2020-11-07 16:12:24', '2020-11-07 16:12:24'),
(14, 'AKL 3', '2020-11-07 16:12:27', '2020-11-07 16:12:27'),
(15, 'DPIB 1', '2020-11-07 16:12:32', '2020-11-07 16:12:32'),
(16, 'DPIB 2', '2020-11-07 16:12:36', '2020-11-07 16:12:36'),
(17, 'SK', '2020-11-07 16:12:41', '2020-11-07 16:12:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(15, '2019_08_19_000000_create_failed_jobs_table', 2),
(16, '2020_10_12_071231_create_guru_table', 2),
(17, '2020_10_12_071241_create_siswa_table', 2),
(18, '2020_10_12_071252_create_poin_table', 2),
(19, '2020_10_12_071308_create_pengaduan_table', 2),
(20, '2020_10_12_071321_create_sanksi_table', 2),
(21, '2020_10_12_073232_create_kelas_table', 2),
(22, '2020_10_12_073926_create_poin_siswa_table', 2),
(23, '2020_10_16_023211_create_tingkat_table', 2),
(24, '2020_10_22_020103_create_penebusan_table', 2),
(25, '2020_10_31_123735_create_admin_table', 2),
(26, '2020_11_02_070612_create_operasi_table', 2),
(27, '2020_11_07_223342_create_penghargaan_table', 2),
(28, '2020_11_10_222454_create_semester_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `operasi`
--

CREATE TABLE `operasi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `akses_user` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `operasi`
--

INSERT INTO `operasi` (`id`, `akses_user`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-11-09 06:34:01', '2021-01-19 03:26:06');

-- --------------------------------------------------------

--
-- Table structure for table `penebusan`
--

CREATE TABLE `penebusan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `penghargaan_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penebusan`
--

INSERT INTO `penebusan` (`id`, `siswa_id`, `penghargaan_id`, `semester_id`, `created_at`, `updated_at`) VALUES
(1, 2, 5, 1, '2021-02-01 06:15:16', '2021-02-01 06:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `poin_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengaduan`
--

INSERT INTO `pengaduan` (`id`, `poin_id`, `siswa_id`, `user_id`, `user_type`, `gambar`, `status`, `created_at`, `updated_at`) VALUES
(1, 6, 2, 1, 'App\\Models\\Guru', 'FnffsSHFN0YKhJtU.jpg', 1, '2021-02-01 06:12:04', '2021-02-01 06:12:46');

-- --------------------------------------------------------

--
-- Table structure for table `penghargaan`
--

CREATE TABLE `penghargaan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penghargaan`
--

INSERT INTO `penghargaan` (`id`, `kode`, `deskripsi`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 'A1a', 'Juara I Tingkat Kelas', 4, '2020-11-08 13:53:09', '2020-11-08 13:53:09'),
(2, 'A1b', 'Juara II Tingkat Kelas', 3, '2020-11-08 13:53:10', '2020-11-08 13:53:10'),
(3, 'A1c', 'Juara III Tingkat Kelas', 2, '2020-11-08 13:53:11', '2020-11-08 13:53:11'),
(4, 'A2a', 'Juara I Tingkat Sekolah / Kecamatan', 6, '2020-11-08 13:53:12', '2020-11-08 13:53:12'),
(5, 'A2b', 'Juara II Tingkat Sekolah / Kecamatan', 4, '2020-11-08 13:53:13', '2020-11-08 13:53:13'),
(6, 'A2c', 'Juara III Tingkat Sekolah / Kecamatan', 3, '2020-11-08 13:53:14', '2020-11-08 13:53:14'),
(7, 'A3a', 'Juara I Tingkat Kabupaten', 8, '2020-11-08 13:53:15', '2020-11-08 13:53:15'),
(8, 'A3b', 'Juara II Tingkat Kabupaten', 6, '2020-11-08 13:53:16', '2020-11-08 13:53:16'),
(9, 'A3c', 'Juara III Tingkat Kabupaten', 4, '2020-11-08 13:53:17', '2020-11-08 13:53:17'),
(10, 'A4a', 'Juara I Tingkat Wilayah', 10, '2020-11-08 13:53:18', '2020-11-08 13:53:18'),
(11, 'A4b', 'Juara II Tingkat Wilayah', 8, '2020-11-08 13:53:19', '2020-11-08 13:53:19'),
(12, 'A4c', 'Juara III Tingkat Wilayah', 6, '2020-11-08 13:53:20', '2020-11-08 13:53:20'),
(13, 'A5a', 'Juara I Tingkat Provinsi', 12, '2020-11-08 13:53:21', '2020-11-08 13:53:21'),
(14, 'A5b', 'Juara II Tingkat Provinsi', 10, '2020-11-08 13:53:22', '2020-11-08 13:53:22'),
(15, 'A5c', 'Juara III Tingkat Provinsi', 8, '2020-11-08 13:53:23', '2020-11-08 13:53:23'),
(16, 'B1a', 'Tahfid Surat-surat Al-Qur\'an (5 surat)', 2, '2020-11-08 13:53:24', '2020-11-08 13:53:24'),
(17, 'B1b', 'Tahfid Surat-surat Al-Qur\'an (10 surat)', 4, '2020-11-08 13:53:25', '2020-11-08 13:53:25'),
(18, 'B1c', 'Tahfid Surat-surat Al-Qur\'an (15 surat)', 6, '2020-11-08 13:53:26', '2020-11-08 13:53:26'),
(19, 'B1d', 'Tahfid Surat-surat Al-Qur\'an (20 surat)', 8, '2020-11-08 13:53:27', '2020-11-08 13:53:27'),
(20, 'B1e', 'Tahfid Surat-surat Al-Qur\'an (Lebih dari 20 surat)', 20, '2020-11-08 13:53:28', '2020-11-08 13:53:28'),
(21, 'B1f', 'Tahfidz Qur\'an/Juz', 40, '2020-11-08 13:53:29', '2020-11-08 13:53:29'),
(22, 'B2a', 'Membaca Surat-surat Al-Qur\'an (10 surat)', 2, '2020-11-08 13:53:30', '2020-11-08 13:53:30'),
(23, 'B2b', 'Membaca Surat-surat Al-Qur\'an (14 surat)', 4, '2020-11-08 13:53:31', '2020-11-08 13:53:31'),
(24, 'B2c', 'Membaca Surat-surat Al-Qur\'an (16 surat)', 6, '2020-11-08 13:53:32', '2020-11-08 13:53:32'),
(25, 'B2d', 'Membaca Surat-surat Al-Qur\'an (18 surat)', 8, '2020-11-08 13:53:33', '2020-11-08 13:53:33'),
(26, 'B2e', 'Membaca Surat-surat Al-Qur\'an (Lebih dari atau sama dengan 20 surat)', 15, '2020-11-08 13:53:34', '2020-11-08 13:53:34'),
(27, 'B2f', 'Membaca Surat-surat Al-Qur\'an / Juz', 20, '2020-11-08 13:53:35', '2020-11-08 13:53:35'),
(28, 'C1', 'Pengurus inti kelas (KM, WKM, Sekretaris, Bendahara) / semester', 2, '2020-11-08 13:53:36', '2020-11-08 13:53:36'),
(29, 'C2', 'Anggota MPK / semsester', 4, '2020-11-08 13:53:37', '2020-11-08 13:53:37'),
(30, 'C3', 'Pengurus inti MPK / semester', 6, '2020-11-08 13:53:38', '2020-11-08 13:53:38'),
(31, 'C4', 'Anggota pengurus OSIS / semester', 4, '2020-11-08 13:53:39', '2020-11-08 13:53:39'),
(32, 'C5', 'Pengurus inti OSIS / semester', 6, '2020-11-08 13:53:40', '2020-11-08 13:53:40'),
(33, 'C6a', 'Pengurus organisasi otonomi (Tingkat Kecamatan)', 4, '2020-11-08 13:53:41', '2020-11-08 13:53:41'),
(34, 'C6b', 'Pengurus organisasi otonomi (Tingkat Kabupaten)', 6, '2020-11-08 13:53:42', '2020-11-08 13:53:42'),
(35, 'C6c', 'Pengurus organisasi otonomi (Tingkat Wilayah)', 8, '2020-11-08 13:53:43', '2020-11-08 13:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `poin`
--

CREATE TABLE `poin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poin`
--

INSERT INTO `poin` (`id`, `kode`, `deskripsi`, `nilai`, `created_at`, `updated_at`) VALUES
(1, 'A1', 'Senin-Selasa tidak berpakaian PSAS (Putih-Abu) lengkap', 4, NULL, NULL),
(2, 'A2', 'Rabu-Kamis tidak berpakaian Batik Sekolah dan bawahan Hitam, \"kerudung Hitam\" bagi perempuan', 4, NULL, NULL),
(3, 'A3', 'Jum\'at tidak berpakaian Pramuka', 4, NULL, NULL),
(4, 'A4', 'Senin-Jum\'at tidak bersepatu hitam, Senin-Kamis tidak berkaos kaki putih, Jum\'at putri tidak berkaos kaki warna coklat, laki-laki tidak berkaos kaki warna hitam', 4, NULL, NULL),
(5, 'A5', 'Tidak berikat pinggang hitam (lebar maksiam 3cm gesper seimbang)', 4, NULL, NULL),
(6, 'A6', 'Tidak memakai topi saat upacara bendera', 4, NULL, NULL),
(7, 'A7', 'Tidak memakai rok/celana penjang, ke atas sebatas pinggang, ke bawah sebatas mata kaki', 4, NULL, NULL),
(8, 'A8', 'Berpakaian ketat', 4, NULL, NULL),
(9, 'A9', 'Model seragam tidak rapih/tidak sopan', 4, NULL, NULL),
(10, 'A10', 'Memakai jaket/sweater/topi bebas di dalam lingkungan sekolah selama KBM berlangsung', 4, NULL, NULL),
(11, 'A11', 'Baju seragam tidak dimasukan', 4, NULL, NULL),
(12, 'A12', 'Tidak menggunakan kerudung bagi peserta didik putri (muslimah)', 4, NULL, NULL),
(13, 'B1', 'Dicat selain warna hitam', 8, NULL, NULL),
(14, 'B2', 'Rambut tidak berukuran 3-2-1 cm', 4, NULL, NULL),
(15, 'B3', 'Model rambut dimodifikasi', 8, NULL, NULL),
(16, 'B4', 'Tidak tertutupi kerudung (Khusus Perempuan)', 8, NULL, NULL),
(17, 'C1', 'Memakai cat/pacar kuku', 4, NULL, NULL),
(18, 'C2', 'Make Up berlebihan (Eye Shadow, lip stick)', 4, NULL, NULL),
(19, 'C3', 'Laki-laki memakai perhiasan', 4, NULL, NULL),
(20, 'C4', 'Perempuan memakai perhiasan berlebihan', 4, NULL, NULL),
(21, 'C5', 'Berkuku panjang', 4, NULL, NULL),
(22, 'D1', 'Terlambat masuk pintu gerbang > 5 menit (masuk pukul 06.50)', 4, NULL, NULL),
(23, 'D2', 'Terlambat masuk kelas > 10 menit', 8, NULL, NULL),
(24, 'D3', 'Bolos/Kabur/Pilih pelajaran', 10, NULL, NULL),
(25, 'D4', 'Alpha', 8, NULL, NULL),
(26, 'D5', 'Surat palsu', 10, NULL, NULL),
(27, 'D6', 'Keluar kelas tanpa izin guru', 4, NULL, NULL),
(28, 'D7', 'Keluar lingkungan Sekolah tanpa izin piket guru', 4, NULL, NULL),
(29, 'D8', 'Tidak mengikuti tadarus dan atau pembacaan Surat Yasin', 4, NULL, NULL),
(30, 'D9', 'Tidak mengikuti upacara bendera', 8, NULL, NULL),
(31, 'D10', 'Terlambat mengikuti upacara bendera (saat bendera sudah naik)', 4, NULL, NULL),
(32, 'D11', 'Izin (tanpa keterangan) lebih dari 3 hari berturut-turut', 4, NULL, NULL),
(33, 'D12', 'Sakit lebih dari 6 hari tanpa surat keterangan petugas kesehatan/dokter/orang tua', 4, NULL, NULL),
(34, 'D13', 'Tidak mengikuti kegiatan yang dilaksanakan disekolah (keagamaan, keosisan, belanegara, dll)', 15, NULL, NULL),
(35, 'E1', 'Tidak melaksanakan tugas piket kelas', 8, NULL, NULL),
(36, 'E2', 'Mebuang sampah tidak pada tempatnya', 4, NULL, NULL),
(37, 'E3', 'Mencoret-coret sarana dan prasarana sekolah', 10, NULL, NULL),
(38, 'E4', 'Menggunakan WC kepala sekolah, guru dan karyawan', 4, NULL, NULL),
(39, 'E6', 'Makan dan minum di dalam kelas/ruang praktek selama KBM berlangsung', 8, NULL, NULL),
(40, 'E7', 'Merusak/menghilangkan sarana dan prasarana sekolah dengan sengaja', 25, NULL, NULL),
(41, 'F1', 'Keluar/Masuk ruangan melewati jendela', 10, NULL, NULL),
(42, 'F2', 'Berkata tidak sopan', 5, NULL, NULL),
(43, 'F3', 'Memanggil nama buruk yang bukan namanya', 5, NULL, NULL),
(44, 'F4a', 'Menggunakan HP', 4, NULL, NULL),
(45, 'F4b', 'Membawa dan menggunakan alat musik (walkman, radio, ipon, dll)', 8, NULL, NULL),
(46, 'F4c', 'Mentontek memberi informasi saat ulangan berlangsung', 8, NULL, NULL),
(47, 'F4d', 'Bersolek', 4, NULL, NULL),
(48, 'F4e', 'Tidak mengerjakan tugas dari guru', 4, NULL, NULL),
(49, 'F4f', 'Mengganggu KBM', 4, NULL, NULL),
(50, 'F4g', 'Tidak membawa peralatan belajar', 4, NULL, NULL),
(51, 'F4h', 'Membaca/mengerjakan pelajaran yang lain', 4, NULL, NULL),
(52, 'F4i', 'Tidur kelas', 4, NULL, NULL),
(53, 'F5', 'membawa kendaraan tidak sesuai ketentuan lalu lintas', 4, NULL, NULL),
(54, 'F6', 'Memarkir kendaraan tidak pada tempatnya', 4, NULL, NULL),
(55, 'F7', 'Tidak menggunakan seragam praktek/menggunakan milik orang lain', 4, NULL, NULL),
(56, 'F8', 'Mengendarai kendaraan dalam keadaan mesin hidup selama KBM berlangsung di dalam lingkungan sekolah (mesin kendaraan harus dimatikan dari gerbang ke tempat parkir watau dari tempat parkir ke gerbang) kecuali keseluruhan KBM sudah berkahir', 8, NULL, NULL),
(57, 'F9', 'Tidak melaksanakan Kegiatan hari Jum\'at (kebersihan, Kerohanian, Olahraga)', 4, NULL, NULL),
(58, 'G1', 'Menyalahgunakan barang cetakan/elektronik yang bersifat sara, sosial dan porno', 30, NULL, NULL),
(59, 'G2', 'Membawa atau meroko di lingkungan sekolah (radius 100 m)', 30, NULL, NULL),
(60, 'G3', 'Berpacaran di sekolah', 25, NULL, NULL),
(61, 'G4', 'Anggota badan bertato dan bertindik (pria)', 30, NULL, NULL),
(62, 'G5', 'Berperilaku buruk terhadap kepala sekolah, guru dan karyawan', 50, NULL, NULL),
(63, 'G6', 'Membawa alat kontrasepsi', 50, NULL, NULL),
(64, 'G7', 'Bermain judi/kartu Sekolah', 50, NULL, NULL),
(65, 'G8', 'Berbohong, memfitnah, menuduh, mengancam, mengintimidasi', 50, NULL, NULL),
(66, 'H1', 'Membawa senjata tajam tanpa izin', 75, NULL, NULL),
(67, 'H2', 'Menganiaya', 75, NULL, NULL),
(68, 'H3', 'Berkelahi', 75, NULL, NULL),
(69, 'H4', 'Tawuran', 100, NULL, NULL),
(70, 'H5', 'Mengganti/memalsukan dokumen (rapot, ijazah, dsb)', 100, NULL, NULL),
(71, 'H6', 'Mencuri/menipu', 100, NULL, NULL),
(72, 'H7', 'Pemerasan', 100, NULL, NULL),
(73, 'H8', 'Melawan secara fisik terhadap kepa;la sekolah, guru, dan karyawan sekolah', 200, NULL, NULL),
(74, 'H9', 'Membawa/menggunakan/mengedarkan NARKOBA', 200, NULL, NULL),
(75, 'H10', 'Membawa/menggunakan/mengedarkan MIRAS', 200, NULL, NULL),
(76, 'H11', 'Hamil (sengaja/terencana)/menghamili', 200, NULL, NULL),
(77, 'H12', 'Menikah', 200, NULL, NULL),
(78, 'H13', 'Pelecehan seksual', 200, NULL, NULL),
(79, 'H14', 'Sex bebas, bergaul bebas, bergaul sesama jenis', 200, NULL, NULL),
(80, 'H15', 'Memperkosa', 200, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `poin_siswa`
--

CREATE TABLE `poin_siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `poin_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `semester_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `poin_siswa`
--

INSERT INTO `poin_siswa` (`id`, `poin_id`, `siswa_id`, `semester_id`, `created_at`, `updated_at`) VALUES
(1, 6, 2, 1, NULL, NULL),
(2, 6, 2, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sanksi`
--

CREATE TABLE `sanksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `minimal_poin` int(11) NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sanksi`
--

INSERT INTO `sanksi` (`id`, `minimal_poin`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 12, 'Teguran lisan', NULL, '2020-11-10 15:51:05'),
(2, 18, 'Peringatan tertulis', NULL, NULL),
(3, 22, 'Peringatan tertulis disampaikan kepada orang tua', NULL, NULL),
(4, 50, 'Pemanggilan orang tua', NULL, NULL),
(5, 75, 'Siswa dan orang tua membuat surat perjanjian bermateri', NULL, NULL),
(6, 100, 'Siswa di skor selama tiga hari', NULL, NULL),
(7, 135, 'Siswa di skor selama enam hari', NULL, NULL),
(8, 175, 'Siswa diminta pindah sekolah', NULL, NULL),
(9, 200, 'Siswa dikembalikan kepada orang tua', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `semester`
--

CREATE TABLE `semester` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` int(11) NOT NULL,
  `tahun_ajaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `semester`
--

INSERT INTO `semester` (`id`, `nama`, `tahun_ajaran`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-2020', '2021-01-26 13:13:11', '2021-01-26 13:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tingkat_id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nama`, `nis`, `kode`, `tingkat_id`, `kelas_id`, `created_at`, `updated_at`) VALUES
(1, 'Dandi Juliandi', '181910260', 'kodesaya', 3, 8, '2021-02-01 05:56:57', '2021-02-01 05:56:57'),
(2, 'Restu Kersana', '181910261', 'kodesaya', 3, 8, '2021-02-01 05:57:36', '2021-02-01 05:57:36');

-- --------------------------------------------------------

--
-- Table structure for table `tingkat`
--

CREATE TABLE `tingkat` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tingkat`
--

INSERT INTO `tingkat` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'X', '2020-11-07 23:06:42', '2020-11-07 23:06:44'),
(2, 'XI', '2020-11-07 23:06:49', '2020-11-07 23:06:51'),
(3, 'XII', '2020-11-07 23:06:55', '2020-11-07 23:06:57'),
(4, 'Lulus', '2020-11-07 23:07:03', '2020-11-07 23:07:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `operasi`
--
ALTER TABLE `operasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penebusan`
--
ALTER TABLE `penebusan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penghargaan`
--
ALTER TABLE `penghargaan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poin`
--
ALTER TABLE `poin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `poin_siswa`
--
ALTER TABLE `poin_siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sanksi`
--
ALTER TABLE `sanksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `semester`
--
ALTER TABLE `semester`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tingkat`
--
ALTER TABLE `tingkat`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `operasi`
--
ALTER TABLE `operasi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penebusan`
--
ALTER TABLE `penebusan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `penghargaan`
--
ALTER TABLE `penghargaan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `poin`
--
ALTER TABLE `poin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `poin_siswa`
--
ALTER TABLE `poin_siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sanksi`
--
ALTER TABLE `sanksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `semester`
--
ALTER TABLE `semester`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tingkat`
--
ALTER TABLE `tingkat`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
