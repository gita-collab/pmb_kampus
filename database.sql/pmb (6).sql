-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2026 at 04:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pmb`
--

-- --------------------------------------------------------

--
-- Table structure for table `calon_mahasiswa`
--

CREATE TABLE `calon_mahasiswa` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `asal_sekolah` varchar(100) DEFAULT NULL,
  `prodi` varchar(50) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tanggal_daftar` date DEFAULT NULL,
  `status_test` enum('Belum','Lulus','Tidak Lulus') DEFAULT 'Belum',
  `nilai_test` int(11) DEFAULT NULL,
  `nomor_test` varchar(20) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `tanggal_test` date DEFAULT NULL,
  `profil_lengkap` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `calon_mahasiswa`
--

INSERT INTO `calon_mahasiswa` (`id`, `user_id`, `nama`, `jenis_kelamin`, `email`, `phone`, `asal_sekolah`, `prodi`, `alamat`, `tanggal_lahir`, `foto`, `tanggal_daftar`, `status_test`, `nilai_test`, `nomor_test`, `nim`, `tanggal_test`, `profil_lengkap`) VALUES
(35, NULL, 'GABY HUA', 'Perempuan', 'nasyi@gmail.com', '081517153119', 'SMKN 65 Jakarta Timur', 'Manajemen', 'mayong', '2002-08-14', 'mhs_1773152611.jpeg', '2026-03-10', 'Lulus', 100, 'USAT-2026-473926', '0262101313', '2026-03-10', 0);

-- --------------------------------------------------------

--
-- Table structure for table `daftar_ulang`
--

CREATE TABLE `daftar_ulang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `nim` varchar(20) DEFAULT NULL,
  `nilai` int(11) DEFAULT NULL,
  `prodi` varchar(50) DEFAULT NULL,
  `jenis_kelamin` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `alamat` text NOT NULL,
  `phone` varchar(20) NOT NULL,
  `phone_ortu` varchar(20) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `daftar_ulang`
--

INSERT INTO `daftar_ulang` (`id`, `nama`, `email`, `nim`, `nilai`, `prodi`, `jenis_kelamin`, `tanggal`, `alamat`, `phone`, `phone_ortu`, `status`, `user_id`) VALUES
(16, 'GABY HUA', 'nasyi@gmail.com', '0262101313', 100, 'Manajemen', 'Perempuan', '2026-03-10', 'JL.PANGKALAN JATI VI', '085691417895', '085691411212', 'LULUS', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jawaban`
--

CREATE TABLE `jawaban` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) DEFAULT NULL,
  `soal_id` int(11) DEFAULT NULL,
  `jawaban` enum('A','B','C','D') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jawaban`
--

INSERT INTO `jawaban` (`id`, `mahasiswa_id`, `soal_id`, `jawaban`) VALUES
(40, 14, 1, 'B'),
(41, 14, 2, 'B'),
(42, 14, 3, 'C'),
(43, 14, 11, 'B'),
(44, 14, 12, 'B'),
(45, 14, 13, 'B'),
(46, 14, 14, 'C'),
(47, 14, 15, 'C'),
(48, 14, 16, 'A'),
(49, 14, 17, 'A'),
(50, 15, 1, 'B'),
(51, 15, 2, 'B'),
(52, 15, 3, 'C'),
(53, 15, 11, 'B'),
(54, 15, 12, 'B'),
(55, 15, 13, 'B'),
(56, 15, 14, 'C'),
(57, 15, 15, 'C'),
(58, 15, 16, 'A'),
(59, 15, 17, 'A'),
(60, 16, 1, 'B'),
(61, 16, 2, 'B'),
(62, 16, 3, 'C'),
(63, 16, 11, 'B'),
(64, 16, 12, 'B'),
(65, 16, 13, 'B'),
(66, 16, 14, 'B'),
(67, 16, 15, 'C'),
(68, 16, 16, 'A'),
(69, 16, 17, 'A'),
(70, 17, 1, 'B'),
(71, 17, 2, 'B'),
(72, 17, 3, 'C'),
(73, 17, 11, 'B'),
(74, 17, 12, 'B'),
(75, 17, 13, 'B'),
(76, 17, 14, 'C'),
(77, 17, 15, 'B'),
(78, 17, 16, 'A'),
(79, 17, 17, 'A'),
(90, 19, 1, 'A'),
(91, 19, 2, 'A'),
(92, 19, 3, 'A'),
(93, 19, 11, 'B'),
(94, 19, 12, 'B'),
(95, 19, 13, 'B'),
(96, 19, 14, 'B'),
(97, 19, 15, 'C'),
(98, 19, 16, 'A'),
(99, 19, 17, 'A'),
(110, 20, 1, 'B'),
(111, 20, 2, 'B'),
(112, 20, 3, 'C'),
(113, 20, 11, 'B'),
(114, 20, 12, 'C'),
(115, 20, 13, 'B'),
(116, 20, 14, 'C'),
(117, 20, 15, 'C'),
(118, 20, 16, 'A'),
(119, 20, 17, 'A'),
(120, 21, 7, 'C'),
(121, 21, 9, 'B'),
(122, 21, 10, 'C'),
(123, 24, 7, 'B'),
(124, 24, 9, 'C'),
(125, 24, 10, 'B'),
(126, 25, 1, 'B'),
(127, 25, 2, 'B'),
(128, 25, 3, 'C'),
(129, 25, 11, 'B'),
(130, 25, 12, 'C'),
(131, 25, 13, 'B'),
(132, 25, 14, 'C'),
(133, 25, 15, 'C'),
(134, 25, 16, 'A'),
(135, 25, 17, 'A'),
(136, 26, 1, 'B'),
(137, 26, 2, 'B'),
(138, 26, 3, 'C'),
(139, 26, 11, 'B'),
(140, 26, 12, 'B'),
(141, 26, 13, 'B'),
(142, 26, 14, 'C'),
(143, 26, 15, 'C'),
(144, 26, 16, 'A'),
(145, 26, 17, 'A'),
(149, 29, 1, 'B'),
(150, 29, 2, 'B'),
(151, 29, 3, 'C'),
(152, 29, 11, 'B'),
(153, 29, 12, 'B'),
(154, 29, 13, 'B'),
(155, 29, 14, 'C'),
(156, 29, 15, 'C'),
(157, 29, 16, 'A'),
(158, 29, 17, 'A'),
(159, 31, 1, 'A'),
(160, 31, 2, 'B'),
(161, 31, 3, 'C'),
(162, 31, 11, 'B'),
(163, 31, 12, 'C'),
(164, 31, 13, 'A'),
(165, 31, 14, 'C'),
(166, 31, 15, 'C'),
(167, 31, 16, 'B'),
(168, 31, 17, 'A'),
(169, 32, 1, 'B'),
(170, 32, 2, 'B'),
(171, 32, 3, 'C'),
(172, 32, 11, 'B'),
(173, 32, 12, 'B'),
(174, 32, 13, 'B'),
(175, 32, 14, 'C'),
(176, 32, 15, 'C'),
(177, 32, 16, 'A'),
(178, 32, 17, 'A'),
(179, 33, 1, 'A'),
(180, 33, 2, 'B'),
(181, 33, 3, 'C'),
(182, 33, 11, 'B'),
(183, 33, 12, 'B'),
(184, 33, 13, 'B'),
(185, 33, 14, 'C'),
(186, 33, 15, 'C'),
(187, 33, 16, 'A'),
(188, 33, 17, 'A'),
(189, 35, 1, 'B'),
(190, 35, 2, 'B'),
(191, 35, 3, 'C'),
(192, 35, 11, 'B'),
(193, 35, 12, 'B'),
(194, 35, 13, 'B'),
(195, 35, 14, 'C'),
(196, 35, 15, 'C'),
(197, 35, 16, 'A'),
(198, 35, 17, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id` int(11) NOT NULL,
  `pertanyaan` text DEFAULT NULL,
  `opsi_a` varchar(255) DEFAULT NULL,
  `opsi_b` varchar(255) DEFAULT NULL,
  `opsi_c` varchar(255) DEFAULT NULL,
  `opsi_d` varchar(255) DEFAULT NULL,
  `jawaban` enum('A','B','C','D') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `prodi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban`, `created_at`, `prodi`) VALUES
(1, 'Manajemen adalah proses…', 'Menyusun laporan keuangan', 'Mengatur orang dan sumber daya untuk mencapai tujuan', 'Membuat produk baru', 'Menyelesaikan tugas sendiri', 'B', '2026-01-27 09:47:29', 'Manajemen'),
(2, 'Fungsi manajemen yang berkaitan dengan menentukan tujuan dan merencanakan cara mencapainya adalah', 'Pengorganisasian', 'Perencanaan', 'Pengendalian', 'Kepemimpinan', 'B', '2026-01-27 09:59:52', 'Manajemen'),
(3, 'Seorang manajer yang memberikan tugas, memotivasi karyawan, dan memastikan pekerjaan selesai termasuk fungsi manajemen…', 'Perencanaan', 'Pengendalian', 'Kepemimpinan/Staffing', 'Organisasi', 'C', '2026-01-27 10:00:59', 'Manajemen'),
(4, 'Akuntansi adalah proses…', 'Menyusun laporan keuangan dan mencatat transaksi keuangan', 'Mengatur karyawan', 'Menjual produk', 'Membuat rencana pemasaran', 'A', '2026-01-27 10:02:18', 'Akuntansi'),
(5, 'Persamaan dasar akuntansi adalah…', 'Aset = Modal + Hutang', 'Aset = Penjualan + Beban', 'Modal = Penjualan – Beban', 'Hutang = Aset – Beban', 'A', '2026-01-27 10:03:21', 'Akuntansi'),
(6, 'Contoh aset lancar adalah…', 'Gedung kantor', 'Kas di bank', 'Mesin pabrik', 'Hutang usaha', 'B', '2026-01-27 10:04:33', 'Akuntansi'),
(7, 'Perangkat keras komputer yang berfungsi untuk menyimpan data sementara saat komputer bekerja disebut…', 'Hard disk', 'RAM', 'CPU', 'Monitor', 'B', '2026-01-27 10:06:07', 'Informatika'),
(9, 'Sistem operasi adalah…\r\n', 'Program yang mengatur semua perangkat keras dan perangkat lunak komputer', 'Program untuk membuat animas', 'Program antivirus', 'Program untuk mengetik dokumen', 'A', '2026-01-27 10:07:15', 'Informatika'),
(10, 'Kode berikut ini print(\"Hello World\") digunakan untuk bahasa pemrograman…', 'Java', 'Python', 'C', 'HTML', 'B', '2026-01-27 10:13:22', 'Informatika'),
(11, 'Sumber daya manusia dalam manajemen biasanya disebut juga…', 'Modal', 'Tenaga kerja', 'Bahan baku', 'Peralatan', 'B', '2026-01-27 10:38:05', 'Manajemen'),
(12, 'Organisasi yang baik harus memiliki…', 'Banyak aturan tanpa tujuan', 'Struktur jelas dan tujuan yang terukur', 'Banyak karyawan tapi tanpa pembagian tugas', 'Hanya satu pemimpin tanpa tim', 'B', '2026-01-27 10:39:08', 'Manajemen'),
(13, 'Pengendalian dalam manajemen berfungsi untuk…', 'Menetapkan visi dan misi', 'Membandingkan hasil dengan rencana dan memperbaiki jika perlu', 'Membagi tugas saja', 'Menetapkan gaji karyawan', 'B', '2026-01-27 10:44:07', 'Manajemen'),
(14, 'Manajemen waktu yang efektif akan membantu…', 'Menunda pekerjaan', 'Mengurangi kualitas kerja', 'Menyelesaikan tugas tepat waktu', 'Menghilangkan pekerjaan', 'C', '2026-01-27 10:44:50', 'Manajemen'),
(15, 'Seorang manajer yang fokus pada proses produksi dan efisiensi disebut…', 'Manajer pemasaran', 'Manajer keuangan', 'Manajer operasional', 'Manajer HRD', 'C', '2026-01-27 10:45:33', 'Manajemen'),
(16, 'Sikap seorang manajer yang mendengarkan ide bawahan termasuk…', 'Demokratis', 'Otoriter', 'Tidak peduli', 'Laissez-faire', 'A', '2026-01-27 10:46:29', 'Manajemen'),
(17, 'Visi organisasi adalah…', 'Gambaran tujuan jangka panjang organisasi', 'Laporan keuangan tahunan', 'Rencana kegiatan harian', 'Daftar karyawan', 'A', '2026-01-27 10:47:16', 'Manajemen'),
(25, 'Apa yang dimaksud dengan aset dalam akuntansi?', 'Harta yang dimiliki perusahaan', 'Utang perusahaan', 'Pendapatan perusahaan', 'Beban perusahaan', 'A', '2026-03-10 14:33:58', 'Akuntansi'),
(26, 'Persamaan dasar akuntansi adalah?', 'Aset = Utang + Modal', 'Modal = Aset + Utang', 'Aset = Modal - Utang', 'Utang = Modal + Aset', 'A', '2026-03-10 14:33:58', 'Akuntansi'),
(27, 'Pencatatan transaksi pertama kali dilakukan di?', 'Buku besar', 'Jurnal', 'Neraca', 'Laporan laba rugi', 'B', '2026-03-10 14:33:58', 'Akuntansi'),
(28, 'Kewajiban perusahaan kepada pihak lain disebut?', 'Aset', 'Modal', 'Utang', 'Pendapatan', 'C', '2026-03-10 14:33:58', 'Akuntansi'),
(29, 'Laporan yang menunjukkan keuntungan atau kerugian perusahaan disebut?', 'Neraca', 'Laporan laba rugi', 'Buku besar', 'Jurnal', 'B', '2026-03-10 14:33:58', 'Akuntansi'),
(30, 'Kas termasuk dalam kelompok?', 'Aset', 'Utang', 'Modal', 'Beban', 'A', '2026-03-10 14:33:58', 'Akuntansi'),
(31, 'Catatan semua transaksi keuangan secara kronologis disebut?', 'Jurnal', 'Neraca', 'Laporan kas', 'Modal', 'A', '2026-03-10 14:33:58', 'Akuntansi'),
(32, 'Perangkat keras komputer disebut?', 'Software', 'Hardware', 'Brainware', 'Network', 'B', '2026-03-10 14:33:58', 'Teknik Informatika'),
(33, 'Bahasa yang digunakan untuk membuat struktur halaman web adalah?', 'HTML', 'CSS', 'Python', 'Java', 'A', '2026-03-10 14:33:58', 'Teknik Informatika'),
(34, 'Perangkat lunak yang digunakan untuk mengelola database adalah?', 'MySQL', 'Photoshop', 'CorelDraw', 'Excel', 'A', '2026-03-10 14:33:58', 'Teknik Informatika'),
(35, 'Apa fungsi sistem operasi pada komputer?', 'Mengedit gambar', 'Mengelola perangkat keras dan perangkat lunak', 'Membuat dokumen', 'Menggambar desain', 'B', '2026-03-10 14:33:58', 'Teknik Informatika'),
(36, 'Contoh perangkat input pada komputer adalah?', 'Monitor', 'Keyboard', 'Printer', 'Speaker', 'B', '2026-03-10 14:33:58', 'Teknik Informatika'),
(37, 'Kepanjangan dari CPU adalah?', 'Central Processing Unit', 'Computer Processing Unit', 'Central Program Unit', 'Control Processing Unit', 'A', '2026-03-10 14:33:58', 'Teknik Informatika'),
(38, 'Perangkat untuk menampilkan hasil proses komputer disebut?', 'Keyboard', 'Mouse', 'Monitor', 'Scanner', 'C', '2026-03-10 14:33:58', 'Teknik Informatika');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('admin','mahasiswa') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `active_session` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `password`, `role`, `created_at`, `active_session`) VALUES
(12, 'Admin PMB', 'admin@usat.ac.id', '$2y$10$ByG/FRVmZNJePzotNm6esO4pbbrFBwwhSwQ2ivbeAwBmhNpvAMLOS', 'admin', '2026-02-04 03:33:35', NULL),
(32, 'GABY HUA', 'nasyi@gmail.com', '$2y$10$VYNVvVWu058Ahn1arP/HweTyZcok83Chlsn8tBB/ZO1OfcCUH5AYu', 'mahasiswa', '2026-03-10 14:22:55', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_sessions`
--

CREATE TABLE `user_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  `login_time` datetime DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `user_agent` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `calon_mahasiswa`
--
ALTER TABLE `calon_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status_test`);

--
-- Indexes for table `daftar_ulang`
--
ALTER TABLE `daftar_ulang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_du_user` (`user_id`);

--
-- Indexes for table `jawaban`
--
ALTER TABLE `jawaban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soal_id` (`soal_id`),
  ADD KEY `jawaban_ibfk_1` (`mahasiswa_id`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_sessions`
--
ALTER TABLE `user_sessions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `calon_mahasiswa`
--
ALTER TABLE `calon_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `daftar_ulang`
--
ALTER TABLE `daftar_ulang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `jawaban`
--
ALTER TABLE `jawaban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `user_sessions`
--
ALTER TABLE `user_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `calon_mahasiswa`
--
ALTER TABLE `calon_mahasiswa`
  ADD CONSTRAINT `fk_cm_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `daftar_ulang`
--
ALTER TABLE `daftar_ulang`
  ADD CONSTRAINT `fk_du_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
