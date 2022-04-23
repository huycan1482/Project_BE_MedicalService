-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 30, 2022 lúc 09:48 AM
-- Phiên bản máy phục vụ: 10.4.11-MariaDB
-- Phiên bản PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: medical_service
--

--
-- Đang đổ dữ liệu cho bảng roles
--

INSERT INTO roles (id, `name`, `level`, ward_id, description, is_active, created_at, updated_at, deleted_at) VALUES
(1, 'Admin', 1, 178, 'Admin', 1, '2022-03-23 03:11:26', '2022-03-23 03:11:26', NULL),
(2, 'Trạm trưởng trạm y tế Cát Linh', 2, 178, '<p>Trạm trưởng trạm y tế C&aacute;t Linh</p>', 1, '2022-03-24 06:26:40', '2022-03-24 06:28:37', NULL),
(3, 'Nhân viên trạm y tế Cát Linh', 3, 178, '<p>Nh&acirc;n vi&ecirc;n trạm y tế C&aacute;t Linh</p>', 1, '2022-03-24 06:27:01', '2022-03-24 06:28:48', NULL),
(4, 'Nhân viên ủy ban phường Cát Linh', 4, 178, '<p>Nh&acirc;n vi&ecirc;n ủy ban phường C&aacute;t Linh</p>', 1, '2022-03-24 06:27:22', '2022-03-24 06:28:58', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
