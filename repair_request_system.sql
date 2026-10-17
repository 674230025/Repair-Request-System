-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2026 at 04:30 PM
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
-- Database: `repair_request_system`
--

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
(2, '2026_10_17_000001_create_repair_categories_table', 1),
(3, '2026_10_17_000002_create_repair_requests_table', 1),
(4, '2026_10_17_000003_create_repair_updates_table', 1);

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
-- Table structure for table `repair_categories`
--

CREATE TABLE `repair_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repair_categories`
--

INSERT INTO `repair_categories` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'คอมพิวเตอร์', 'คอมพิวเตอร์ตั้งโต๊ะ โน้ตบุ๊ก และอุปกรณ์ต่อพ่วง', 1, '2026-10-17 14:04:01', '2026-10-17 14:04:01'),
(2, 'เครือข่ายอินเทอร์เน็ต', 'อินเทอร์เน็ต Wi-Fi LAN และอุปกรณ์เครือข่าย', 1, '2026-10-17 14:04:01', '2026-10-17 14:04:01'),
(3, 'เครื่องพิมพ์', 'เครื่องพิมพ์ หมึกพิมพ์ และการเชื่อมต่อ', 1, '2026-10-17 14:04:01', '2026-10-17 14:04:01'),
(4, 'โปรเจกเตอร์และจอภาพ', 'โปรเจกเตอร์ จอแสดงผล และสายสัญญาณ', 1, '2026-10-17 14:04:01', '2026-10-17 14:04:01'),
(5, 'ไฟฟ้าและอุปกรณ์ทั่วไป', 'ปลั๊กไฟ ไฟส่องสว่าง และอุปกรณ์สำนักงาน', 1, '2026-10-17 14:04:01', '2026-10-17 14:04:01'),
(6, 'อื่น ๆ', 'ปัญหาอื่นที่ไม่ตรงกับหมวดหมู่ข้างต้น', 1, '2026-10-17 14:04:01', '2026-10-17 14:04:01');

-- --------------------------------------------------------

--
-- Table structure for table `repair_requests`
--

CREATE TABLE `repair_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ticket_no` varchar(32) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(180) NOT NULL,
  `description` text NOT NULL,
  `location` varchar(180) NOT NULL,
  `urgency` varchar(20) NOT NULL DEFAULT 'normal',
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `image_path` varchar(255) DEFAULT NULL,
  `admin_note` text DEFAULT NULL,
  `assigned_to` bigint(20) UNSIGNED DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repair_requests`
--

INSERT INTO `repair_requests` (`id`, `ticket_no`, `user_id`, `category_id`, `title`, `description`, `location`, `urgency`, `status`, `image_path`, `admin_note`, `assigned_to`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 'RR-261017-MFWGY', 1, 1, 'คอมเปิดไม่ติดมีเสียงงี่งี่', 'อั๊วลองลื้อแล้วเละเละเลอ', 'อาคาร 6 ชั้น 8 ห้อง 689', 'high', 'completed', 'repair-attachments/xSX5IYzBoCBPVGfeVcBsVDNABR7CQF35teVWFvBV.jpg', NULL, NULL, '2026-10-17 14:26:54', '2026-10-17 14:10:11', '2026-10-17 14:26:54'),
(2, 'RR-261017-TDCCL', 2, 1, 'คอมมีไฟลุกลามท่วมทุ่ง', 'เอาน้ำฉีดไปแล้วไฟไม่ดับสักที', 'อาคาร 6 ชั้น 8 ห้อง 683', 'high', 'waiting_parts', 'repair-attachments/WY9GD2Ayyd96A1pgwc3Dr1F46PHp1Pmv9YeTMtf0.jpg', NULL, NULL, NULL, '2026-10-17 14:14:42', '2026-10-17 14:15:31');

-- --------------------------------------------------------

--
-- Table structure for table `repair_updates`
--

CREATE TABLE `repair_updates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `repair_request_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `repair_updates`
--

INSERT INTO `repair_updates` (`id`, `repair_request_id`, `user_id`, `status`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'pending', 'สร้างรายการแจ้งซ่อมใหม่', '2026-10-17 14:10:11', '2026-10-17 14:10:11'),
(2, 1, 1, 'pending', 'อัปเดตข้อมูลรายการแจ้งซ่อม', '2026-10-17 14:10:49', '2026-10-17 14:10:49'),
(3, 2, 2, 'pending', 'สร้างรายการแจ้งซ่อมใหม่', '2026-10-17 14:14:42', '2026-10-17 14:14:42'),
(4, 2, 1, 'waiting_parts', 'เปลี่ยนสถานะจาก รอดำเนินการ เป็น รออะไหล่', '2026-10-17 14:15:31', '2026-10-17 14:15:31'),
(5, 1, 1, 'rejected', 'เปลี่ยนสถานะจาก รอดำเนินการ เป็น ไม่อนุมัติ', '2026-10-17 14:26:19', '2026-10-17 14:26:19'),
(6, 1, 1, 'completed', 'เปลี่ยนสถานะจาก ไม่อนุมัติ เป็น ซ่อมเสร็จแล้ว', '2026-10-17 14:26:54', '2026-10-17 14:26:54');

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
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'ผู้ดูแลระบบ', 'admin@repair.local', NULL, '$2y$12$55Yi0CwWJiec1jXAJim3AOPZVdpp7OvD6V8uQmCwpJC6MzsMIJIUW', 'admin', NULL, '2026-10-17 14:04:01', '2026-10-17 14:04:01'),
(2, 'thanasak', '674230017@webmail.com', NULL, '$2y$12$z5xkXXqN4mkVwGzcGDa9MONznl.D7M7CR/VYXJJGJEiIpcM9CuTxK', 'user', NULL, '2026-10-17 14:12:52', '2026-10-17 14:12:52');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `repair_categories`
--
ALTER TABLE `repair_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `repair_categories_name_unique` (`name`),
  ADD KEY `repair_categories_is_active_index` (`is_active`);

--
-- Indexes for table `repair_requests`
--
ALTER TABLE `repair_requests`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `repair_requests_ticket_no_unique` (`ticket_no`),
  ADD KEY `repair_requests_category_id_foreign` (`category_id`),
  ADD KEY `repair_requests_assigned_to_foreign` (`assigned_to`),
  ADD KEY `repair_requests_user_id_created_at_index` (`user_id`,`created_at`),
  ADD KEY `repair_requests_urgency_index` (`urgency`),
  ADD KEY `repair_requests_status_index` (`status`);

--
-- Indexes for table `repair_updates`
--
ALTER TABLE `repair_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `repair_updates_user_id_foreign` (`user_id`),
  ADD KEY `repair_updates_repair_request_id_created_at_index` (`repair_request_id`,`created_at`);

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
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_index` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `repair_categories`
--
ALTER TABLE `repair_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `repair_requests`
--
ALTER TABLE `repair_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `repair_updates`
--
ALTER TABLE `repair_updates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `repair_requests`
--
ALTER TABLE `repair_requests`
  ADD CONSTRAINT `repair_requests_assigned_to_foreign` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `repair_requests_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `repair_categories` (`id`),
  ADD CONSTRAINT `repair_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `repair_updates`
--
ALTER TABLE `repair_updates`
  ADD CONSTRAINT `repair_updates_repair_request_id_foreign` FOREIGN KEY (`repair_request_id`) REFERENCES `repair_requests` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `repair_updates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
