-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:8889
-- Thời gian đã tạo: Th10 16, 2021 lúc 07:08 AM
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
-- Cấu trúc bảng cho bảng `customer_notifications`
--

CREATE TABLE `customer_notifications` (
  `id` int(10) NOT NULL,
  `notification_type` tinyint(4) NOT NULL COMMENT 'Loại notification',
  `item_id` int(10) DEFAULT NULL,
  `customer_id` int(10) DEFAULT NULL,
  `business_id` int(10) DEFAULT NULL,
  `notification_status_id` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `customer_notifications`
--
ALTER TABLE `customer_notifications`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `customer_notifications`
--
ALTER TABLE `customer_notifications`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
