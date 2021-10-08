-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:8889
-- Thời gian đã tạo: Th10 08, 2021 lúc 10:50 AM
-- Phiên bản máy phục vụ: 5.7.32
-- Phiên bản PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `ci_adbazar_eu`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reservation_configs`
--

CREATE TABLE `reservation_configs` (
  `id` int(10) NOT NULL,
  `business_profile_id` int(10) NOT NULL,
  `day_id` tinyint(4) NOT NULL,
  `max_people` int(10) DEFAULT NULL,
  `max_per_reservation` int(10) DEFAULT NULL,
  `duration` int(10) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `reservation_config_status_id` tinyint(4) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `reservation_configs`
--

INSERT INTO `reservation_configs` (`id`, `business_profile_id`, `day_id`, `max_people`, `max_per_reservation`, `duration`, `start_time`, `end_time`, `reservation_config_status_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`) VALUES
(1, 3, 0, 90, 10, 45, '09:00:00', '20:00:00', 2, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52'),
(2, 3, 1, 90, 10, 45, '09:00:00', '20:00:00', 2, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52'),
(3, 3, 2, 90, 10, 45, '09:00:00', '20:00:00', 2, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52'),
(4, 3, 3, 90, 10, 45, '09:00:00', '20:00:00', 2, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52'),
(5, 3, 4, 90, 10, 45, '09:00:00', '20:00:00', 2, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52'),
(6, 3, 5, 90, 10, 45, '09:00:00', '20:00:00', 2, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52'),
(7, 3, 6, 90, 10, 45, '09:00:00', '20:00:00', 2, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52', NULL, '2021-10-08 09:04:52');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `reservation_configs`
--
ALTER TABLE `reservation_configs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `reservation_configs`
--
ALTER TABLE `reservation_configs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
