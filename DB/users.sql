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
-- Đang đổ dữ liệu cho bảng users
--

INSERT INTO users (id, `name`, date_of_birth, phone, identity_card, gender, ward_id, address, description, email, email_verified_at, `password`, remember_token, role_id, is_active, created_at, updated_at, deleted_at) VALUES
(1, 'Đặng Đức Huy', '2000-08-14', '0928583902', '12345678901', 1, 178, 'bi mật', '<p>bi mật</p>', 'admin@gmail.com', NULL, '$2y$10$UQdf3X8Cw9q973x2xoJT0uiU.K37WBvlUX9B5na7vEaxkOM/Pr0uq', 'KeXKdvkcZreuu6jnVBmKOYkWiHyUT2XEmaNN95VbPAVHuZR0nhXEz1agQlEm', 1, 1, '2022-03-11 13:12:12', '2022-03-11 13:43:13', NULL),
(2, 'Nguyễn Ngọc Giang', '1991-09-27', '6489392408', '83024952841', 1, 178, 'dia chi 1', NULL, 'catlinh1@gmail.com', NULL, '$2y$10$4dTUd4pmUoc0ykVZCHDQruWhE7Nr6VElv3rgj7iHF6GPj5ZMmu1zm', NULL, 2, 1, '2022-03-24 06:30:36', '2022-03-24 06:30:36', NULL),
(3, 'Phan Thu Trà', '1998-03-02', '0938294075', '63289409218', 0, 1, 'dia chi 1', NULL, 'catlinh2@gmail.com', NULL, '$2y$10$3WBKuD4fxAABJQyCZ0HHqeHpBFWPC.qHmQQ48Xnhf3pWojOMcKtnO', NULL, 3, 1, '2022-03-24 06:31:52', '2022-03-24 06:31:52', NULL),
(4, 'Nguyễn Thị Thanh Tâm', '1996-03-16', '9402840395', '29482710382', 0, 43, 'dia chi 1', NULL, 'catlinh3@gmail.com', NULL, '$2y$10$/7SzY7h2bFoAomvrXwYO3OUZCNLJvWRWnpabrXz0XnHrEHumkh4R2', NULL, 3, 1, '2022-03-24 06:33:06', '2022-03-24 06:33:06', NULL),
(5, 'Nguyễn Hồng Hải', '1989-03-08', '9382740583', '39284102831', 0, 118, 'dia chi 1', NULL, 'catlinh4@gmail.com', NULL, '$2y$10$j7xtAZNwh1KqO/FnbptaU.dy8ALQTLS32NSHKvaTny7fExuKl9m6K', NULL, 3, 1, '2022-03-24 06:33:55', '2022-03-24 06:33:55', NULL),
(6, 'Hoàng Minh Trang', '1996-09-17', '9309672066', '38019238127', 1, 187, 'dia chi 2', NULL, 'catlinh5@gmail.com', NULL, '$2y$10$SlyG6q0/G81v.sIGjnlDNeefZyPXr99ll7biKiZV2owyhwdfRc.U.', NULL, 3, 1, '2022-03-24 06:34:54', '2022-03-24 06:34:54', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
