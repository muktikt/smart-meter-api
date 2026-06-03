-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Jun 2026 pada 19.11
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_meter`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bukti_pengaduan`
--

CREATE TABLE `bukti_pengaduan` (
  `id` int(11) NOT NULL,
  `pengaduan_id` int(11) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
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
-- Struktur dari tabel `gangguan_air`
--

CREATE TABLE `gangguan_air` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `estimasi_selesai` date DEFAULT NULL,
  `status` enum('aktif','proses','selesai') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `gangguan_air`
--

INSERT INTO `gangguan_air` (`id`, `judul`, `deskripsi`, `foto`, `kecamatan`, `tanggal_mulai`, `estimasi_selesai`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Perbaikan pipa', 'bivhuvouh', 'gangguan/LVzjvI1HUCZJqBMcNI1RlrHTWyzNqG0Fy66FLfl5.png', 'Indramayu', '2026-05-29', '2026-05-29', 'selesai', '2026-05-28 12:44:12', '2026-05-28 13:07:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `petugas_id` bigint(20) DEFAULT NULL,
  `aktivitas` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `device` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `meter_reading`
--

CREATE TABLE `meter_reading` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `meter_lama` int(11) UNSIGNED DEFAULT NULL,
  `meter_baru` int(11) UNSIGNED DEFAULT NULL,
  `pemakaian` int(11) UNSIGNED DEFAULT NULL,
  `foto_meter` text DEFAULT NULL,
  `hasil_ocr` varchar(255) DEFAULT NULL,
  `status` enum('pending','valid','reject') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_anomali` varchar(20) DEFAULT 'normal',
  `catatan_anomali` text DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `petugas_id` int(11) DEFAULT NULL,
  `ocr_persen` int(11) DEFAULT 0,
  `ocr_status` varchar(50) DEFAULT 'pending',
  `validasi_petugas` varchar(50) DEFAULT 'pending',
  `validated_at` datetime DEFAULT NULL
) ;

--
-- Dumping data untuk tabel `meter_reading`
--

INSERT INTO `meter_reading` (`id`, `user_id`, `bulan`, `tahun`, `meter_lama`, `meter_baru`, `pemakaian`, `foto_meter`, `hasil_ocr`, `status`, `created_at`, `updated_at`, `status_anomali`, `catatan_anomali`, `catatan`, `petugas_id`, `ocr_persen`, `ocr_status`, `validasi_petugas`, `validated_at`) VALUES
(3, 3, 'Januari', 2026, 1400, 1500, 100, NULL, NULL, 'valid', '2026-05-07 15:12:27', NULL, 'normal', NULL, NULL, NULL, 0, 'pending', 'pending', NULL),
(7, 2, 'Mei', 2026, 980, 1200, 220, 'meter/ZpqAIVKe5qOTB9Z6wWxakwA3k5JBptXz9DoEhpEn.png', '1200', 'valid', '2026-05-30 09:39:48', '2026-05-30 11:03:15', 'normal', NULL, NULL, 5, 90, 'berhasil', 'valid', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2026_05_07_161006_create_personal_access_tokens_table', 1),
(4, '2026_05_25_000001_create_roles_table', 2),
(5, '2026_05_25_000002_add_role_id_to_users_table', 2),
(6, '2026_05_29_170212_add_hasil_ocr_to_meter_reading_table', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `monitoring_kecamatan`
--

CREATE TABLE `monitoring_kecamatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kecamatan` varchar(100) NOT NULL,
  `total_pelanggan` int(11) DEFAULT 0,
  `meter_hari_ini` int(11) DEFAULT 0,
  `pengaduan_aktif` int(11) DEFAULT 0,
  `gangguan_aktif` int(11) DEFAULT 0,
  `anomali` int(11) DEFAULT 0,
  `persentase_aktif` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT 'normal',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `monitoring_server`
--

CREATE TABLE `monitoring_server` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cpu_usage` int(11) DEFAULT 0,
  `ram_usage` int(11) DEFAULT 0,
  `storage_usage` int(11) DEFAULT 0,
  `status` varchar(50) DEFAULT 'online',
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `judul` varchar(150) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('tagihan_baru','jatuh_tempo','pengaduan_selesai','gangguan_air') NOT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `invoice_id` varchar(100) DEFAULT NULL,
  `payment_gateway` varchar(50) DEFAULT 'dompetx',
  `amount` double NOT NULL,
  `metode_pembayaran` varchar(100) DEFAULT NULL,
  `status` enum('pending','paid','expired','failed') DEFAULT 'pending',
  `payment_url` text DEFAULT NULL,
  `paid_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`id`, `tagihan_id`, `invoice_id`, `payment_gateway`, `amount`, `metode_pembayaran`, `status`, `payment_url`, `paid_at`, `created_at`, `updated_at`) VALUES
(1, 3, '90f19a01-5f9c-4a51-9d61-26001c4e71c8', 'dompetx', 400000, 'checkout', 'pending', NULL, NULL, '2026-05-29 12:18:24', '2026-05-29 12:18:24'),
(2, 3, '6b8fd460-c896-4566-8212-bb70957be900', 'dompetx', 400000, 'checkout', 'pending', 'https://checkout.dompetx.com/checkoutV2?refId=6b8fd460-c896-4566-8212-bb70957be900', NULL, '2026-05-29 12:45:02', '2026-05-29 12:45:02'),
(3, 3, 'f1e560cc-4060-4ee6-9841-ec24e296dd84', 'dompetx', 400000, 'checkout', 'pending', 'https://checkout.dompetx.com/checkoutV2?refId=f1e560cc-4060-4ee6-9841-ec24e296dd84', NULL, '2026-05-30 06:41:17', '2026-05-30 06:41:17'),
(4, 3, '556001d2-1f7e-435d-add4-c173ecc47b5d', 'dompetx', 400000, 'checkout', 'pending', 'https://checkout.dompetx.com/checkout?refId=556001d2-1f7e-435d-add4-c173ecc47b5d', NULL, '2026-05-30 07:06:27', '2026-05-30 07:06:27'),
(5, 5, '70a37f46-d860-498a-b34f-59e133f73af8', 'dompetx', 880000, 'checkout', 'pending', 'https://checkout.dompetx.com/checkoutV2?refId=70a37f46-d860-498a-b34f-59e133f73af8', NULL, '2026-06-03 09:26:14', '2026-06-03 09:26:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `tagihan_id` int(11) DEFAULT NULL,
  `metode` varchar(50) DEFAULT NULL,
  `jumlah` double DEFAULT NULL,
  `status` enum('pending','success','gagal') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaduan`
--

CREATE TABLE `pengaduan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` text DEFAULT NULL,
  `status` enum('pending','proses','selesai') DEFAULT 'proses',
  `petugas_id` int(11) DEFAULT NULL,
  `catatan_petugas` text DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'smart_meter', '56f673b52b33d9afcee2c1e6dfae73747ce4d868bde2f0af9c549dc8c37e73c0', '[\"*\"]', NULL, NULL, '2026-05-07 10:18:11', '2026-05-07 10:18:11'),
(2, 'App\\Models\\User', 1, 'smart_meter', '140e2caf2efdc5fbddc2c7dc3897d030478b64fa413b826b8afb2ae0b6609165', '[\"*\"]', NULL, NULL, '2026-05-07 11:16:25', '2026-05-07 11:16:25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `kode_petugas` varchar(100) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'aktif',
  `device_id` varchar(255) DEFAULT NULL,
  `device_name` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id`, `kode_petugas`, `nama`, `email`, `password`, `no_hp`, `kecamatan`, `role`, `status`, `device_id`, `device_name`, `foto`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'IND002', 'Petugas Indramayu', 'indramayu@pdam.com', '$2y$12$CootQ7mT9ZDRDD0z1gYWHeXmS3is3/pqZfMS..P294yyIh0n07VZq', '081214959954', 'Arahan', 'lapangan', 'aktif', 'android-test-1', 'Samsung A55', NULL, NULL, '2026-05-30 10:47:37', '2026-05-30 10:50:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin', 'Full access to the application', '2026-05-25 01:49:39', '2026-05-25 01:49:39'),
(2, 'Pelanggan', 'pelanggan', 'Customer / end user', '2026-05-25 01:49:39', '2026-05-25 01:49:39'),
(3, 'Petugas', 'petugas', 'Field officer / staff', '2026-05-25 01:49:39', '2026-05-25 01:49:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tagihan`
--

CREATE TABLE `tagihan` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `meter_id` int(11) DEFAULT NULL,
  `bulan` varchar(20) DEFAULT NULL,
  `tahun` int(11) DEFAULT NULL,
  `periode` varchar(20) DEFAULT NULL,
  `pemakaian` int(11) DEFAULT NULL,
  `total_tagihan` double DEFAULT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `tarif_per_m3` double DEFAULT 4000,
  `status` enum('belum_bayar','lunas') DEFAULT 'belum_bayar',
  `tanggal_bayar` datetime DEFAULT NULL,
  `metode_bayar` varchar(100) DEFAULT NULL,
  `jatuh_tempo` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tagihan`
--

INSERT INTO `tagihan` (`id`, `user_id`, `meter_id`, `bulan`, `tahun`, `periode`, `pemakaian`, `total_tagihan`, `invoice_number`, `tarif_per_m3`, `status`, `tanggal_bayar`, `metode_bayar`, `jatuh_tempo`, `created_at`, `updated_at`) VALUES
(3, 3, 3, 'Mei', 2026, 'Mei 2026', 100, 400000, 'INV-3-1780149983', 4000, 'belum_bayar', NULL, 'dompetx', '2026-06-20', '2026-05-07 15:12:27', '2026-05-30 07:06:27'),
(5, 2, 7, 'Mei', 2026, 'Mei 2026', 220, 880000, 'INV-5-1780503969', 4000, 'belum_bayar', NULL, 'dompetx', '2026-06-20', '2026-05-30 09:39:48', '2026-06-03 09:26:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `no_pelanggan` varchar(12) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `kecamatan` varchar(100) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `status_akun` enum('belum_aktif','aktif','nonaktif') DEFAULT 'belum_aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `device_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `role_id`, `no_pelanggan`, `nama`, `email`, `password`, `no_hp`, `alamat`, `kecamatan`, `latitude`, `longitude`, `status_akun`, `created_at`, `updated_at`, `device_id`) VALUES
(2, NULL, '120000000002', 'Najmi Ayu Fajriyah', 'najmi@gmail.com', '$2y$12$wWiddz9w8g9H0MOLgh5.pufBieqXWqWGi61w1.xcqGSAnlcG3Lt2S', '081234567890', 'Arahan', 'Arahan', -6.3, 108.3, 'aktif', '2026-05-07 15:12:27', '2026-05-30 08:47:37', NULL),
(3, NULL, '120000000003', 'Asri Dwi Aryanti', 'asri@gmail.com', '$2y$12$HG5RIypKNVHnPlT0nhrWxeoAvD4trygwptslItfO6mos5zB28H1Rq', '0812230674', 'karangampel', 'karangampel', -6.53, 108.51, 'aktif', '2026-05-07 15:12:27', '2026-05-31 15:37:09', NULL),
(4, 1, '000000', 'Admin PDAM', 'admin@pdam.com', '$2y$12$hX.v2F5CanwAR4f5PdQGtenzUxbd1kn2umQ6SIZlel9CpSMRFzKmS', '081234567890', 'Kantor Pusat PDAM', 'Kecamatan', NULL, NULL, 'aktif', '2026-05-25 01:40:23', '2026-05-25 01:40:23', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bukti_pengaduan`
--
ALTER TABLE `bukti_pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pengaduan_id` (`pengaduan_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `gangguan_air`
--
ALTER TABLE `gangguan_air`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `meter_reading`
--
ALTER TABLE `meter_reading`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_meter_user_bulan_tahun` (`user_id`,`bulan`,`tahun`),
  ADD KEY `meter_reading_petugas_fk` (`petugas_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `monitoring_kecamatan`
--
ALTER TABLE `monitoring_kecamatan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `monitoring_server`
--
ALTER TABLE `monitoring_server`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payment_tagihan` (`tagihan_id`);

--
-- Indeks untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `petugas_id` (`petugas_id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_petugas` (`kode_petugas`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_slug_unique` (`slug`);

--
-- Indeks untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `meter_id` (`meter_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `no_pelanggan` (`no_pelanggan`),
  ADD KEY `idx_no_pelanggan` (`no_pelanggan`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bukti_pengaduan`
--
ALTER TABLE `bukti_pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `gangguan_air`
--
ALTER TABLE `gangguan_air`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `meter_reading`
--
ALTER TABLE `meter_reading`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `monitoring_kecamatan`
--
ALTER TABLE `monitoring_kecamatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `monitoring_server`
--
ALTER TABLE `monitoring_server`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bukti_pengaduan`
--
ALTER TABLE `bukti_pengaduan`
  ADD CONSTRAINT `bukti_pengaduan_ibfk_1` FOREIGN KEY (`pengaduan_id`) REFERENCES `pengaduan` (`id`);

--
-- Ketidakleluasaan untuk tabel `meter_reading`
--
ALTER TABLE `meter_reading`
  ADD CONSTRAINT `meter_reading_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `meter_reading_petugas_fk` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payment_tagihan` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pengaduan`
--
ALTER TABLE `pengaduan`
  ADD CONSTRAINT `pengaduan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `pengaduan_ibfk_2` FOREIGN KEY (`petugas_id`) REFERENCES `petugas` (`id`);

--
-- Ketidakleluasaan untuk tabel `tagihan`
--
ALTER TABLE `tagihan`
  ADD CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`meter_id`) REFERENCES `meter_reading` (`id`);

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
