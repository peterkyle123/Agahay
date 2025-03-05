-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2025 at 08:45 AM
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
-- Database: `agahay_resort`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `name` varchar(100) NOT NULL,
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`name`, `id`, `email`, `password`, `created_at`, `updated_at`) VALUES
('Admin User', 1, 'admin@example.com', '$2y$12$o8iUgM/5wjZoKkwGOnWsMu4vvG9tb4nbfpnyJKdfbHCCT1gRaxwUu', '2025-02-04 23:17:25', '2025-02-04 23:17:25'),
('Admin User', 4, 'pkyle.gingo@gmail.com', '$2y$12$pqBQyEsDMl35Mc3tSlam3OLNiq52ySLl6lY56UYDltDlc0jD.70fS', '2025-02-12 17:06:18', '2025-02-12 17:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `guest_name` varchar(255) DEFAULT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `days_staying` int(225) DEFAULT NULL,
  `phone` varchar(12) NOT NULL,
  `payment` varchar(255) DEFAULT NULL,
  `downpayment` varchar(255) NOT NULL DEFAULT 'Not Paid',
  `balance` decimal(8,2) DEFAULT NULL,
  `proof_of_payment` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tracking_code` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT 'Pending',
  `package_name` varchar(255) DEFAULT NULL,
  `extra_pax` int(11) NOT NULL DEFAULT 0,
  `special_request` text DEFAULT NULL,
  `downpayment_locked` tinyint(1) NOT NULL DEFAULT 0,
  `decline_reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_name`, `guest_name`, `check_in_date`, `check_out_date`, `days_staying`, `phone`, `payment`, `downpayment`, `balance`, `proof_of_payment`, `created_at`, `updated_at`, `tracking_code`, `status`, `package_name`, `extra_pax`, `special_request`, `downpayment_locked`, `decline_reason`) VALUES
(214, 'Jilly Newmansiubghb', 's', '2025-02-17', '2025-02-19', 2, '09207080240', '₱10,300.00', 'Not Paid', NULL, NULL, '2025-02-24 17:02:07', '2025-02-24 19:12:28', 'BKJ-3703-W', 'Canceled', 'VIP Booking', 1, 'df', 0, NULL),
(215, 'Jilly Newmansiubghb', 'ssd', '2025-03-30', '2025-03-31', 1, '09207080240', '₱7,500.00', 'Not Paid', NULL, NULL, '2025-02-24 17:05:43', '2025-02-24 17:10:20', 'BKT-9405-M', 'Declined', 'Small Group', 0, NULL, 0, NULL),
(216, 'Jilly Newmansiubghb', 's', '2025-03-25', '2025-03-27', 2, '09207080240', '₱10,600.00', 'Not Paid', NULL, 'uploads/downpayments/1740448213_code.PNG', '2025-02-24 17:50:13', '2025-02-24 18:19:37', 'BK6-5726-M', 'Request for Cancellation', 'VIP Booking', 2, 'd', 0, NULL),
(217, 'Jilly Newmansiubghb', 'ssd', '2025-04-01', '2025-04-03', NULL, '09308245845', '₱10,600.00', 'Not Paid', NULL, 'uploads/downpayments/1740450129_code.PNG', '2025-02-24 18:22:10', '2025-02-25 16:16:10', 'BK0-5671-U', 'Request for Cancellation', 'VIP Booking', 2, 'f', 0, NULL),
(218, 'Jilly Newman', 'ssd', '2025-02-24', '2025-02-25', 1, '09207080240', '₱10,300.00', 'Not Paid', NULL, 'uploads/downpayments/1740451432_code.PNG', '2025-02-24 18:43:52', '2025-02-24 19:27:54', 'BKN-4796-N', 'Declined', 'VIP Booking', 1, NULL, 0, 'g'),
(219, 'Jilly Newmansiubghb', 'ssd', '2025-02-17', '2025-02-19', 2, '09207080240', '₱10,000.00', 'Not Paid', NULL, 'uploads/downpayments/1740453217_code.PNG', '2025-02-24 19:13:37', '2025-02-24 19:29:18', 'BKB-4505-H', 'Declined', 'VIP Booking', 0, NULL, 0, NULL),
(220, 'Newmix', 'ssd', '2025-02-07', '2025-02-09', 2, '09207080240', '₱10,800.00', 'Not Paid', NULL, 'uploads/downpayments/1740454902_code.PNG', '2025-02-24 19:41:42', '2025-02-24 22:24:58', 'BK8-3178-S', 'Declined', 'VIP Booking', 2, NULL, 0, 'g'),
(221, 'Jilly Newmansiubghb', 'ssd', '2025-02-17', '2025-02-19', 2, '09207080240', '₱10,300.00', 'Not Paid', NULL, 'uploads/downpayments/1740454993_code.PNG', '2025-02-24 19:43:13', '2025-02-24 22:41:48', 'BKO-0052-T', 'Done', 'VIP Booking', 1, NULL, 0, NULL),
(222, 'Jilly Newmansiubghb', 'ssd', '2025-02-20', '2025-02-22', 2, '09207080240', '₱10,300.00', 'Not Paid', NULL, 'uploads/downpayments/1740531177_code.PNG', '2025-02-25 16:52:57', '2025-02-25 16:53:23', 'BKI-2631-S', 'Done', 'VIP Booking', 1, NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image_name`, `image_path`, `description`, `created_at`, `updated_at`) VALUES
(47, '8.jpg', 'gallery_images/6oB3Iht1NOffs9QavYJn32W8cBzzFb4CNHzzzK0k.jpg', NULL, '2025-02-07 19:18:40', '2025-02-07 19:18:40'),
(64, '16 pax.jpg', 'gallery_images/yERN0bM4wA5lmIKlvWqRLCijp6cn3gGFpqVX5lil.jpg', NULL, '2025-02-11 16:36:15', '2025-02-11 16:36:15'),
(65, 'three.jpg', 'gallery_images/ocRBTqMPqeGGatyWBFUrKBor4keSaFqFXGNHtf93.jpg', NULL, '2025-02-11 16:36:28', '2025-02-11 16:36:28'),
(66, 'agahayresort.jpg', 'gallery_images/h8iVwEdPlEYGQUFdlwUVS78yVyoMG3b8SLLoHMh1.jpg', NULL, '2025-02-11 16:36:41', '2025-02-11 16:36:41'),
(70, 'one.jpg', 'gallery_images/SCviRVRUOrvkDZ5VDCwZmgIQQuSiDGhRp5ulN7qz.jpg', NULL, '2025-02-14 21:27:31', '2025-02-14 21:27:31');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_02_01_052226_create_bookings_table', 1),
(5, '2025_02_01_052227_create_admins_table', 1),
(6, '2025_02_01_072721_create_packages_table', 1),
(7, '2025_02_05_073447_create_bookings_table', 2),
(10, '2025_02_05_080556_add_extra_pax_and_special_request_to_bookings', 3),
(11, '2025_02_13_025459_create_reviews_table', 4),
(12, '2025_02_13_031751_create_reviews_table', 5),
(13, '2025_02_13_062525_add_package_price_and_pax_fee_to_bookings_table', 6),
(14, '2025_02_18_075259_add_cancellation_requested_to_bookings', 7),
(15, '2025_02_20_003619_add_downpayment_locked_to_bookings_table', 8),
(16, '2025_02_20_051347_add_fri_sun_price_to_packages_table', 9),
(17, '2025_02_21_002143_add_available_to_packages_table', 10),
(18, '2025_02_21_075414_add_balance_to_bookings_table', 11),
(19, '2025_02_22_011757_add_downpayment_column_to_bookings_table', 12),
(20, '2025_02_22_022713_add_proof_of_payment_to_bookings_table', 13),
(21, '2025_02_24_022203_add_decline_reason_to_bookings_table', 14),
(22, '2025_02_25_005756_add_guest_name_to_bookings_table', 15),
(23, '2025_02_25_011557_add_proof_of_downpayment_to_bookings_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `initial_payment` decimal(10,2) NOT NULL,
  `number_of_days` int(9) NOT NULL,
  `number_of_guests` int(10) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `per_day_price` int(255) NOT NULL,
  `fri_sun_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `extra_pax_price` int(255) NOT NULL,
  `available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`package_id`, `package_name`, `price`, `initial_payment`, `number_of_days`, `number_of_guests`, `description`, `image`, `per_day_price`, `fri_sun_price`, `extra_pax_price`, `available`) VALUES
(1, 'Small Group', 7000.00, 4500.00, 4, 10, 'DESCRIPTION', 'images/8.jpg', 2000, 500.00, 76, 1),
(2, 'VIP Booking', 10000.00, 600.00, 3, 8, 'Experience premium luxury with our VIP package. Private amenities, enhanced comfort, and exclusive services.', 'images/VIP.jpg', 100, 200.00, 300, 1),
(3, 'Large Group Package', 1200.00, 500.00, 3, 30, 'Enjoy a private stay at Agahay Guesthouse. Includes full house access, free Wi-Fi, billiards, and videoke. Extra pax: ₱75 each.', 'images/16 pax.jpg', 430, 0.00, 100, 1);

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
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rating` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `img_upld` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `name`, `rating`, `message`, `img_upld`, `email`, `created_at`, `updated_at`) VALUES
(12, 'PETER KYLE', 2, 'xc', 'reviews/GGZP1ktDywugSLX0HC33KGMwtiiPIxTQFjnl6hQG.jpg', 'admin@example.com', '2025-02-16 22:11:28', '2025-02-16 22:11:28'),
(13, 'Small', 5, 'HG', 'reviews/8UrPYCh3NvJzKsRcyIoyd5B9ZoRcbsL0HxoNlWME.jpg', 'admin@example.com', '2025-02-16 23:10:11', '2025-02-16 23:10:11'),
(14, 'Historia Novaria', 5, 'nothing', 'reviews/qO8BfSfl3OSYJVBzYoNxIz8MSn5uDJ8lTAPJxDr2.jpg', 'admin@example.com', '2025-02-17 17:51:43', '2025-02-17 17:51:43'),
(15, 'PETER KYLE', 5, 'jhjll;llkjjk', 'reviews/ts1TTxDwwl0TqbmyNLf8UaWrE4IPvAFa0QcUImWy.png', 'pkyle.gingo@gmail.com', '2025-02-17 23:27:24', '2025-02-17 23:27:24'),
(16, 'John Newgens', 4, 'testing new reviews layout', 'reviews/e5MoOlCHHlydmBDxChnbCIY68NViJbHcoVjWutRN.png', 'admin@example.com', '2025-02-18 22:29:32', '2025-02-18 22:29:32'),
(17, 'sd', 4, 'sdsd', 'reviews/dfftwMYmSSwPto8u4lzljFmsFMsdwsObJIBe0o1Y.png', 'admin@example.com', '2025-02-18 23:53:46', '2025-02-18 23:53:46'),
(18, 'King', 4, 'd', 'reviews/zJMNx8Q2HmKFHJJjG6c2F7zZPPaADFx20fW9sn8y.jpg', 'pkyle.gingo@gmail.com', '2025-02-21 17:53:53', '2025-02-21 17:53:53'),
(19, 'Niches', 1, 's', 'reviews/9WYRBnrCtuEiv64g4MoNIhFSLIQkjlFrpEeEIjBk.png', 'admin@example.com', '2025-02-25 16:21:05', '2025-02-25 16:21:05');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('lQdNHp5o6gBDWqJiTPp78G7k2HzF6HwRQE4I8lOq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMmdEaVpHWDVlTE96ZG1HTGxZNFoyT3NiRVhTZEJKN0g2YW96eGJEOSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ib29rIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1OiJhZG1pbiI7aToxO3M6MTA6Im1hbnVhbENvZ3MiO3M6MToiMyI7fQ==', 1740531621);

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
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
