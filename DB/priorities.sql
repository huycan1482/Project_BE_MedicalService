-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 30, 2022 lúc 09:47 AM
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
-- Đang đổ dữ liệu cho bảng priorities
--

INSERT INTO priorities (id, `name`, description, is_active, created_at, updated_at, deleted_at) VALUES
(1, 'Lực lượng tuyến đầu phòng, chống dịch', '<p>Lực lượng tuyến đầu ph&ograve;ng, chống dịch, gồm:<br />\n- Người l&agrave;m việc trong c&aacute;c cơ sở y tế;<br />\n- Người tham gia ph&ograve;ng chống dịch (Th&agrave;nh vi&ecirc;n Ban chỉ đạo ph&ograve;ng, chống dịch c&aacute;c cấp, người l&agrave;m việc ở c&aacute;c khu c&aacute;ch ly, l&agrave;m nhiệm vụ truy vết, điều tra dịch tễ, tổ covid dựa v&agrave;o cộng đồng, t&igrave;nh nguyện vi&ecirc;n, ph&oacute;ng vi&ecirc;n...);<br />\n- Qu&acirc;n đội; C&ocirc;ng an.</p>', 1, '2022-03-24 08:05:46', '2022-03-24 08:05:46', NULL),
(2, 'Nhân viên, cán bộ ngoại giao của Việt Nam được cử đi nước ngoài; hải quan, cán bộ làm công tác xuất nhập cảnh;', '<p>Nh&acirc;n vi&ecirc;n, c&aacute;n bộ ngoại giao của Việt Nam được cử đi nước ngo&agrave;i; hải quan, c&aacute;n bộ l&agrave;m c&ocirc;ng t&aacute;c xuất nhập cảnh;</p>', 1, '2022-03-24 08:06:16', '2022-03-24 08:06:16', NULL),
(3, 'Người cung cấp dịch vụ thiết yếu: hàng không, vận tải, du lịch; cung cấp dịch vụ điện, nước...;', '<p>Người cung cấp dịch vụ thiết yếu: h&agrave;ng kh&ocirc;ng, vận tải, du lịch; cung cấp dịch vụ điện, nước...;</p>', 1, '2022-03-24 08:06:25', '2022-03-24 08:06:25', NULL),
(4, 'Giáo viên, người làm việc tại các cơ sở giáo dục, đào tạo; người làm việc tại các cơ quan, đơn vị hành chính thường xuyên tiếp xúc với nhiều người;', '<p>Gi&aacute;o vi&ecirc;n, người l&agrave;m việc tại c&aacute;c cơ sở gi&aacute;o dục, đ&agrave;o tạo; người l&agrave;m việc tại c&aacute;c cơ quan, đơn vị h&agrave;nh ch&iacute;nh thường xuy&ecirc;n tiếp x&uacute;c với nhiều người;</p>', 1, '2022-03-24 08:06:38', '2022-03-24 08:06:38', NULL),
(5, 'Người mắc các bệnh mạn tính, người trên 65 tuổi;', '<p>Người mắc c&aacute;c bệnh mạn t&iacute;nh, người tr&ecirc;n 65 tuổi;</p>', 1, '2022-03-24 08:06:48', '2022-03-24 08:06:48', NULL),
(6, 'Người sinh sống tại các vùng có dịch;', '<p>Người sinh sống tại c&aacute;c v&ugrave;ng c&oacute; dịch;</p>', 1, '2022-03-24 08:06:58', '2022-03-24 08:06:58', NULL),
(7, 'Người nghèo, các đối tượng chính sách xã hội;', '<p>Người ngh&egrave;o, c&aacute;c đối tượng ch&iacute;nh s&aacute;ch x&atilde; hội;</p>', 1, '2022-03-24 08:07:07', '2022-03-24 08:07:07', NULL),
(8, 'Người được cơ quan nhà nước có thẩm quyền cử đi công tác, học tập, lao động ở nước ngoài.', '<p>Người được cơ quan nh&agrave; nước c&oacute; thẩm quyền cử đi c&ocirc;ng t&aacute;c, học tập, lao động ở nước ngo&agrave;i.</p>', 1, '2022-03-24 08:07:17', '2022-03-24 08:07:17', NULL),
(9, 'Các đối tượng khác do Bộ Y tế quyết định căn cứ yêu cầu phòng chống dịch', '<p>C&aacute;c đối tượng kh&aacute;c do Bộ Y tế quyết định căn cứ y&ecirc;u cầu ph&ograve;ng chống dịch</p>', 1, '2022-03-24 08:07:28', '2022-03-24 08:07:28', NULL),
(10, 'Công nhân KCN, khu chế xuất, nhà máy', '<p>C&ocirc;ng nh&acirc;n KCN, khu chế xuất, nh&agrave; m&aacute;y</p>', 1, '2022-03-24 08:07:39', '2022-03-24 08:07:39', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
