-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:8889
-- Thời gian đã tạo: Th10 08, 2021 lúc 12:36 PM
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
-- Cấu trúc bảng cho bảng `customer_reservations`
--

CREATE TABLE `customer_reservations` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `business_profile_id` int(10) NOT NULL,
  `book_name` varchar(250) DEFAULT NULL,
  `number_of_people` int(10) DEFAULT NULL,
  `country_code_id` int(11) DEFAULT NULL,
  `book_phone` varchar(50) DEFAULT NULL,
  `date_arrived` date DEFAULT NULL,
  `time_arrived` time DEFAULT NULL,
  `book_status_id` tinyint(4) NOT NULL COMMENT '2: approved, 1: Expired, 3: Cancelled, 4: Declined',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `customer_reservations`
--

INSERT INTO `customer_reservations` (`id`, `customer_id`, `business_profile_id`, `book_name`, `number_of_people`, `country_code_id`, `book_phone`, `date_arrived`, `time_arrived`, `book_status_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`) VALUES
(1, 26, 6, 'Thien', 1, 80, '0377731910', '2021-10-26', '10:00:00', 2, '2021-10-08 19:20:43', 0, NULL, NULL, NULL),
(2, 26, 6, 'Thien Nguyen', 10, 80, '0377731910', '2021-10-20', '10:00:00', 2, '2021-10-08 19:28:15', 0, NULL, NULL, NULL),
(3, 26, 6, 'Hoang Nguyen', 10, 80, '0377731910', '2021-10-19', '10:00:00', 2, '2021-10-08 19:29:06', 0, NULL, NULL, NULL),
(4, 26, 6, 'Thien', 10, 80, '0377731910', '2021-10-20', '10:00:00', 2, '2021-10-08 19:30:04', 0, NULL, NULL, NULL),
(5, 26, 6, 'áđâsd', 1, 80, '0377731910', '2021-10-19', '10:00:00', 2, '2021-10-08 19:31:05', 0, NULL, NULL, NULL),
(6, 26, 6, 'Nguyen', 1, 80, '0886917766', '2021-10-20', '10:00:00', 2, '2021-10-08 19:31:34', 0, NULL, NULL, NULL),
(7, 26, 6, 'áđá ad á', 1, 80, '0377731910', '2021-10-20', '10:00:00', 2, '2021-10-08 19:32:18', 0, NULL, NULL, NULL),
(8, 26, 6, 'Thien Nguyen', 1, 80, '0377731910', '2021-10-20', '10:00:00', 2, '2021-10-08 19:33:13', 0, NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `customer_reservations`
--
ALTER TABLE `customer_reservations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `customer_reservations`
--
ALTER TABLE `customer_reservations`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
