-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:8889
-- Thời gian đã tạo: Th10 08, 2021 lúc 12:41 PM
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
-- Cấu trúc bảng cho bảng `customer_reviews`
--

CREATE TABLE `customer_reviews` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `business_id` int(10) NOT NULL,
  `review_star` float(10,1) DEFAULT NULL,
  `customer_comment` text,
  `business_comment` text,
  `customer_review_status_id` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(10) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(10) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Đang đổ dữ liệu cho bảng `customer_reviews`
--

INSERT INTO `customer_reviews` (`id`, `customer_id`, `business_id`, `review_star`, `customer_comment`, `business_comment`, `customer_review_status_id`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`) VALUES
(1, 14, 3, 3.0, 'Hello xin chào', '<p>ádsađá</p>', 0, '2021-10-08 10:45:24', 0, '2021-10-08 14:48:59', 0, '2021-10-08 15:01:06'),
(2, 21, 3, 3.0, 'Hello xin chào', '<p>adsađá</p>', 0, '2021-10-08 10:48:07', 0, '2021-10-08 14:48:52', 0, '2021-10-08 15:01:00'),
(3, 21, 3, 3.0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula. Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum. onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula. Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum. onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.', 2, '2021-10-08 10:48:52', 0, '2021-10-08 13:48:52', NULL, NULL),
(4, 26, 6, 3.0, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula. Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum. onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.', NULL, 2, '2021-10-08 10:49:25', 0, NULL, NULL, NULL),
(5, 26, 6, 5.0, '', NULL, 2, '2021-10-08 11:40:21', 0, NULL, NULL, NULL),
(6, 26, 6, 5.0, '', NULL, 2, '2021-10-08 11:40:55', 0, NULL, NULL, NULL),
(7, 26, 3, 5.0, '<p>editorReview</p><p>editorReview</p><p>editorReview</p><p>editorReview</p>', '<p>Thien Nguyen</p>', 0, '2021-10-08 11:54:00', 0, '2021-10-08 14:49:11', 0, '2021-10-08 15:00:41'),
(8, 26, 3, 5.0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula. Donec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum. onec elementum fringilla rhoncus. Vestibulum in accumsan velit. Donec interdum.</p>', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero.</p>', 2, '2021-10-08 11:55:03', 0, '2021-10-08 15:02:23', 0, NULL),
(9, 26, 3, 3.0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin nulla felis sit amet sem. Proin augue felis, luctus vitae enim eu, consectetur rhoncus ligula.</p>', '', 2, '2021-10-08 12:11:16', 0, '2021-10-08 15:00:07', 0, NULL),
(10, 26, 6, 5.0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin nulla felis sit amet sem. Proin augue</p>', NULL, 2, '2021-10-08 12:51:18', 0, NULL, NULL, NULL),
(11, 26, 6, 1.0, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin nulla felis sit amet sem. Proin augue</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed in maximus libero. Fusce vulputate, lectus vitae rhoncus bibendum, eros purus dignissim sapien, sit amet sollicitudin nulla felis sit amet sem. Proin augue</p>', NULL, 2, '2021-10-08 12:51:28', 0, NULL, NULL, NULL),
(12, 26, 6, 1.0, '<p>overall_rating</p><p>overall_rating</p><p>overall_rating</p>', NULL, 2, '2021-10-08 12:54:26', 0, NULL, NULL, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `customer_reviews`
--
ALTER TABLE `customer_reviews`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `customer_reviews`
--
ALTER TABLE `customer_reviews`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
