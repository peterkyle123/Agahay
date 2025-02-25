-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 25, 2025 at 01:14 AM
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

INSERT INTO `bookings` (`id`, `customer_name`, `check_in_date`, `check_out_date`, `days_staying`, `phone`, `payment`, `downpayment`, `balance`, `proof_of_payment`, `created_at`, `updated_at`, `tracking_code`, `status`, `package_name`, `extra_pax`, `special_request`, `downpayment_locked`, `decline_reason`) VALUES
(197, 'Earl Mike Sarabia', '2025-04-05', '2025-04-08', NULL, '09308245845', '₱10,500.00', 'Not Paid', NULL, NULL, '2025-02-23 21:35:03', '2025-02-23 21:55:23', 'BKQ-2933-Q', 'Approved', 'VIP Booking', 1, 's', 0, NULL),
(198, 'TESTTHREE', '2025-03-22', '2025-03-23', NULL, '09207080240', '₱10,500.00', 'Not Paid', NULL, NULL, '2025-02-23 21:56:24', '2025-02-23 22:07:46', 'BKE-4685-D', 'Approved', 'VIP Booking', 1, 'S', 0, NULL),
(199, 'TESTFOUR', '2025-03-23', '2025-03-24', NULL, '09323124242', '₱10,500.00', 'Not Paid', NULL, NULL, '2025-02-23 21:56:53', '2025-02-23 21:57:05', 'BKG-6560-M', 'Approved', 'VIP Booking', 1, 'S', 0, NULL),
(200, 'Jieryl Madanguit', '2025-02-01', '2025-02-02', 1, '09207080240', '₱10,500.00', 'Not Paid', NULL, NULL, '2025-02-23 22:18:56', '2025-02-23 23:13:00', 'BKJ-4058-H', 'Done', 'VIP Booking', 1, 's', 0, NULL),
(201, 'Jilly Newman', '2025-02-03', '2025-02-04', 1, '09323124242', '₱10,300.00', 'Not Paid', NULL, NULL, '2025-02-23 22:20:31', '2025-02-23 22:54:43', 'BK0-2165-G', 'Done', 'VIP Booking', 1, 's', 0, NULL),
(202, 'Test Five', '2025-02-26', '2025-02-28', 2, '09323124242', '₱10,300.00', 'Not Paid', NULL, NULL, '2025-02-23 23:13:38', '2025-02-23 23:54:45', 'BKA-3798-S', 'Approved', 'VIP Booking', 1, NULL, 0, NULL),
(203, 'Jilly Newmansiubghb', '2025-03-01', '2025-03-03', 2, '09207080240', '₱10,500.00', 'Not Paid', NULL, NULL, '2025-02-24 00:00:51', '2025-02-24 00:01:21', 'BKM-2209-U', 'Approved', 'VIP Booking', 1, 's', 0, NULL),
(204, 'Jilly Newman', '2025-03-07', '2025-03-09', 2, '09323124242', '₱10,500.00', 'Not Paid', NULL, NULL, '2025-02-24 00:06:37', '2025-02-24 00:08:11', 'BKS-9504-T', 'Approved', 'VIP Booking', 1, NULL, 0, NULL),
(205, 'gikapoy nako', '2025-03-10', '2025-03-12', 2, '09308245845', '₱10,300.00', 'Not Paid', NULL, NULL, '2025-02-24 00:08:40', '2025-02-24 00:28:57', 'BKF-1317-B', 'Declined', 'VIP Booking', 1, NULL, 0, 'asd'),
(206, 'Jilly Newman', '2025-03-13', '2025-03-15', 2, '09207080240', '₱10,300.00', 'Not Paid', NULL, NULL, '2025-02-24 00:31:15', '2025-02-24 00:32:55', 'BKG-9407-M', 'Declined', 'VIP Booking', 1, NULL, 0, 'asd'),
(207, 'gikapoy nako', '2025-03-16', '2025-03-18', 2, '09308245845', '₱10,500.00', 'Not Paid', NULL, NULL, '2025-02-24 00:35:21', '2025-02-24 00:35:28', 'BKU-4072-5', 'Declined', 'VIP Booking', 1, NULL, 0, 'g'),
(208, 'Jilly Newmansiubghb', '2025-03-04', '2025-03-06', 2, '09308245845', '₱10,300.00', 'Not Paid', NULL, NULL, '2025-02-24 00:36:36', '2025-02-24 00:36:45', 'BKV-0957-F', 'Declined', 'VIP Booking', 1, NULL, 0, 'nothing'),
(209, 'gikapoy nako', '2025-03-19', '2025-03-21', 2, '09207080240', '₱11,200.00', 'Not Paid', NULL, NULL, '2025-02-24 00:37:23', '2025-02-24 00:37:30', 'BKM-3994-V', 'Approved', 'VIP Booking', 4, NULL, 0, NULL);

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
(21, '2025_02_24_022203_add_decline_reason_to_bookings_table', 14);

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
(1, 'Small Group', 7000.00, 4500.00, 4, 10, 'DESCRIPTION', 'images/8.jpg', 2000, 500.00, 76, 0),
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
(18, 'King', 4, 'd', 'reviews/zJMNx8Q2HmKFHJJjG6c2F7zZPPaADFx20fW9sn8y.jpg', 'pkyle.gingo@gmail.com', '2025-02-21 17:53:53', '2025-02-21 17:53:53');

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
('xt1RCBbqqNe4JgOGj1ODGGhDy7BEY7QCCsuiiFqq', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiaVE1WFZPVzNGd2I2WWVpUG9DUWlrc1NXWE1MQlBMVTFPZFhkWDY2WCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcHByb3ZlZC1ib29raW5ncyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NToiYWRtaW4iO2k6MTt9', 1740386357);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=210;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
