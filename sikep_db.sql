-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 26, 2025 at 03:17 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sikep_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_pegawai`
--

CREATE TABLE `dokumen_pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pegawai_id` bigint(20) UNSIGNED NOT NULL,
  `jenis_dokumen_id` bigint(20) UNSIGNED NOT NULL,
  `nama_file_asli` varchar(255) NOT NULL,
  `nama_file_tersimpan` varchar(255) NOT NULL,
  `path_file` varchar(255) NOT NULL,
  `tanggal_upload` datetime NOT NULL,
  `versi_dokumen` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `status_dokumen` varchar(255) NOT NULL DEFAULT 'Aktif',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dokumen_pegawai`
--

INSERT INTO `dokumen_pegawai` (`id`, `pegawai_id`, `jenis_dokumen_id`, `nama_file_asli`, `nama_file_tersimpan`, `path_file`, `tanggal_upload`, `versi_dokumen`, `status_dokumen`, `keterangan`, `created_at`, `updated_at`) VALUES
(3, 6, 1, 'Screenshot (267).png', '378468367_ktp_V1_8658c61f-f24d-47da-b2cc-cac2456cf5e3.png', '/storage/dokumen_pegawai/378468367/378468367_ktp_V1_8658c61f-f24d-47da-b2cc-cac2456cf5e3.png', '2025-06-25 04:24:11', 1, 'Revisi', 'asli', '2025-06-24 21:24:11', '2025-06-24 23:22:14'),
(4, 6, 1, 'Screenshot (236).png', '378468367_ktp_V2_1edb7389-e9f2-4879-9fe8-1f8a2cd3bc2e.png', '/storage/dokumen_pegawai/378468367/378468367_ktp_V2_1edb7389-e9f2-4879-9fe8-1f8a2cd3bc2e.png', '2025-06-25 06:22:14', 2, 'Dihapus', 'fotocopy', '2025-06-24 23:22:14', '2025-06-24 23:22:56'),
(5, 6, 2, 'Screenshot (267).png', '378468367_ijazah_V1_dbcff5a8-1600-4e50-aa5b-b3470b9cf9d2.png', '/storage/dokumen_pegawai/378468367/378468367_ijazah_V1_dbcff5a8-1600-4e50-aa5b-b3470b9cf9d2.png', '2025-06-25 06:22:42', 1, 'Revisi', NULL, '2025-06-24 23:22:42', '2025-06-25 00:02:05'),
(6, 6, 1, 'Screenshot (528).png', '378468367_ktp_V1_8090b08e-1078-4514-aa0b-4286c8256588.png', '/storage/dokumen_pegawai/378468367/378468367_ktp_V1_8090b08e-1078-4514-aa0b-4286c8256588.png', '2025-06-25 06:40:24', 1, 'Dihapus', 'huiy', '2025-06-24 23:40:24', '2025-06-25 00:07:56'),
(7, 6, 2, 'Screenshot (14).png', '378468367_ijazah_V2_d975a568-aea7-4c1d-afd1-e2dec689ed0a.png', '/storage/dokumen_pegawai/378468367/378468367_ijazah_V2_d975a568-aea7-4c1d-afd1-e2dec689ed0a.png', '2025-06-25 07:02:05', 2, 'Dihapus', NULL, '2025-06-25 00:02:05', '2025-06-25 00:05:07'),
(8, 6, 3, 'BMC template[1].pdf', '378468367_sertifikat-pelatihan_V1_1d316049-53df-48b8-879d-5de899496c41.pdf', '/storage/dokumen_pegawai/378468367/378468367_sertifikat-pelatihan_V1_1d316049-53df-48b8-879d-5de899496c41.pdf', '2025-06-25 07:07:18', 1, 'Revisi', NULL, '2025-06-25 00:07:18', '2025-06-25 00:07:36'),
(9, 6, 3, 'BMC template[1].pdf', '378468367_sertifikat-pelatihan_V2_276475f8-6694-44fb-85b1-98a244f940bb.pdf', '/storage/dokumen_pegawai/378468367/378468367_sertifikat-pelatihan_V2_276475f8-6694-44fb-85b1-98a244f940bb.pdf', '2025-06-25 07:07:36', 2, 'Dihapus', NULL, '2025-06-25 00:07:36', '2025-06-25 00:08:07'),
(10, 6, 1, 'BMC template[1].pdf', '378468367_ktp_V3_de9da2f6-b330-434f-b19a-acdfa7415c76.pdf', '/storage/dokumen_pegawai/378468367/378468367_ktp_V3_de9da2f6-b330-434f-b19a-acdfa7415c76.pdf', '2025-06-25 07:09:40', 3, 'Aktif', NULL, '2025-06-25 00:09:40', '2025-06-25 00:09:40');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_dokumen`
--

CREATE TABLE `jenis_dokumen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_jenis` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis_dokumen`
--

INSERT INTO `jenis_dokumen` (`id`, `nama_jenis`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'KTP', 'Kartu Tanda Penduduk', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(2, 'Ijazah', 'Ijazah Pendidikan Terakhir', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(3, 'Sertifikat Pelatihan', 'Sertifikat keikutsertaan pelatihan', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(4, 'SK Pengangkatan', 'Surat Keputusan Pengangkatan Jabatan', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(5, 'SK Kenaikan Pangkat', 'Surat Keputusan Kenaikan Pangkat', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(6, 'Kartu Keluarga', 'Kartu Keluarga', '2025-06-24 19:08:08', '2025-06-24 19:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(6, '2014_10_12_000000_create_users_table', 1),
(7, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2025_06_24_025330_create_pegawai_table', 1),
(11, '2025_06_24_072225_create_jenis_dokumen_table', 2),
(12, '2025_06_24_072303_create_dokumen_pegawai_table', 2),
(13, '2025_06_25_015225_create_unit_kerja_table', 3),
(14, '2025_06_25_015749_add_unit_kerja_id_to_pegawai_table', 3),
(15, '2025_06_25_035647_remove_unit_kerja_string_from_pegawai_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nomor_telepon` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `status_pegawai` varchar(255) DEFAULT NULL,
  `tanggal_bergabung` date DEFAULT NULL,
  `foto_profil_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_kerja_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id`, `nip`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `alamat`, `email`, `nomor_telepon`, `jabatan`, `status_pegawai`, `tanggal_bergabung`, `foto_profil_path`, `created_at`, `updated_at`, `unit_kerja_id`) VALUES
(5, '90909086', 'Aris', '2009-07-17', 'Laki-laki', 'metro', 'sikep@gmail.com', '45678', 'kesubag', 'Aktif', '2025-06-03', '/storage/foto_profil/90909086_foto_profil_3754082f-73f7-4cae-8bca-abc07116ced8.png', '2025-06-24 20:26:44', '2025-06-24 20:26:44', 1),
(6, '378468367', 'apki', '2024-06-25', 'Laki-laki', 'ertf', 'adminbaru@gmail.com', '8797621', 'kesubag', 'Aktif', '2025-06-04', '/storage/foto_profil/378468367_foto_profil_f94e4dd6-5144-4c81-8c69-521d1e8f5126.png', '2025-06-24 20:39:39', '2025-06-24 20:39:39', 3);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `unit_kerja`
--

CREATE TABLE `unit_kerja` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_unit` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `unit_kerja`
--

INSERT INTO `unit_kerja` (`id`, `nama_unit`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Aset', 'Divisi Aset Daerah', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(2, 'Bidang Anggaran & Perbendaharaan', 'Bidang Pengelolaan Anggaran dan Perbendaharaan', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(3, 'Bidang Akuntansi', 'Bidang Akuntansi Keuangan Daerah', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(4, 'UPT Kasda', 'Unit Pelaksana Teknis Kas Daerah', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(5, 'UPT Pemanfaatan Aset Daerah', 'Unit Pelaksana Teknis Pemanfaatan Aset Daerah', '2025-06-24 19:08:08', '2025-06-24 19:08:08'),
(6, 'Sekretariat', 'Sekretariat Instansi', '2025-06-24 19:08:08', '2025-06-24 19:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokumen_pegawai`
--
ALTER TABLE `dokumen_pegawai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dokumen_pegawai_pegawai_id_foreign` (`pegawai_id`),
  ADD KEY `dokumen_pegawai_jenis_dokumen_id_foreign` (`jenis_dokumen_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jenis_dokumen_nama_jenis_unique` (`nama_jenis`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pegawai_nip_unique` (`nip`),
  ADD UNIQUE KEY `pegawai_email_unique` (`email`),
  ADD KEY `pegawai_unit_kerja_id_foreign` (`unit_kerja_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unit_kerja_nama_unit_unique` (`nama_unit`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokumen_pegawai`
--
ALTER TABLE `dokumen_pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jenis_dokumen`
--
ALTER TABLE `jenis_dokumen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `unit_kerja`
--
ALTER TABLE `unit_kerja`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dokumen_pegawai`
--
ALTER TABLE `dokumen_pegawai`
  ADD CONSTRAINT `dokumen_pegawai_jenis_dokumen_id_foreign` FOREIGN KEY (`jenis_dokumen_id`) REFERENCES `jenis_dokumen` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `dokumen_pegawai_pegawai_id_foreign` FOREIGN KEY (`pegawai_id`) REFERENCES `pegawai` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_unit_kerja_id_foreign` FOREIGN KEY (`unit_kerja_id`) REFERENCES `unit_kerja` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
