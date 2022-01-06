-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2022 at 09:54 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `capstone_irs`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `subject_id`, `causer_type`, `causer_id`, `properties`, `created_at`, `updated_at`) VALUES
(1, 'default', 'created', 'App\\Models\\Resource', 1, NULL, NULL, '{\"attributes\":{\"course_id\":14,\"user_id\":13,\"batch_id\":\"8e094912-f3dc-3705-ae15-1de816af1c08\",\"is_syllabus\":0}}', '2021-12-07 09:06:11', '2021-12-07 09:06:11'),
(2, 'default', 'created', 'App\\Models\\Resource', 2, NULL, NULL, '{\"attributes\":{\"course_id\":27,\"user_id\":9,\"batch_id\":\"1c955047-b5eb-3383-8ad6-9b95a67cdeee\",\"is_syllabus\":0}}', '2021-12-07 09:06:12', '2021-12-07 09:06:12'),
(3, 'default', 'created', 'App\\Models\\Resource', 3, NULL, NULL, '{\"attributes\":{\"course_id\":14,\"user_id\":13,\"batch_id\":\"5cf05a54-2c6e-3c85-85b0-2f32d5ffedd4\",\"is_syllabus\":0}}', '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(4, 'default', 'created', 'App\\Models\\Resource', 4, NULL, NULL, '{\"attributes\":{\"course_id\":29,\"user_id\":9,\"batch_id\":\"c65d65d7-4b7b-3511-95fc-a76a43d75801\",\"is_syllabus\":0}}', '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(5, 'default', 'created', 'App\\Models\\Resource', 5, NULL, NULL, '{\"attributes\":{\"course_id\":30,\"user_id\":13,\"batch_id\":\"ae0a4603-e7f0-3968-831e-e89c411c6eb3\",\"is_syllabus\":0}}', '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(6, 'default', 'created', 'App\\Models\\Resource', 6, NULL, NULL, '{\"attributes\":{\"course_id\":16,\"user_id\":13,\"batch_id\":\"b0bac09e-32f3-355d-8ba3-d0a7625166a2\",\"is_syllabus\":0}}', '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(7, 'default', 'created', 'App\\Models\\Resource', 7, NULL, NULL, '{\"attributes\":{\"course_id\":7,\"user_id\":13,\"batch_id\":\"45100dc7-b404-320c-82eb-5f6606e28120\",\"is_syllabus\":0}}', '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(8, 'default', 'created', 'App\\Models\\Resource', 8, NULL, NULL, '{\"attributes\":{\"course_id\":17,\"user_id\":9,\"batch_id\":\"6fbf4db9-68af-3f04-aa25-dd12d3c9db66\",\"is_syllabus\":0}}', '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(9, 'default', 'created', 'App\\Models\\Resource', 9, NULL, NULL, '{\"attributes\":{\"course_id\":14,\"user_id\":13,\"batch_id\":\"0542e1e2-83ca-3a96-bfe8-345bed413b2c\",\"is_syllabus\":0}}', '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(10, 'default', 'created', 'App\\Models\\Resource', 10, NULL, NULL, '{\"attributes\":{\"course_id\":9,\"user_id\":2,\"batch_id\":\"81f3ba5a-24bf-36c8-a0c6-db64ec1045b2\",\"is_syllabus\":0}}', '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(11, 'default', 'created', 'App\\Models\\Resource', 11, NULL, NULL, '{\"attributes\":{\"course_id\":8,\"user_id\":2,\"batch_id\":\"667a8694-83cb-3ed8-a065-07dc6b94b164\",\"is_syllabus\":0}}', '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(12, 'default', 'created', 'App\\Models\\Resource', 12, NULL, NULL, '{\"attributes\":{\"course_id\":10,\"user_id\":13,\"batch_id\":\"4ea57f48-981c-380c-922a-58973e3108ee\",\"is_syllabus\":0}}', '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(13, 'default', 'created', 'App\\Models\\Resource', 13, NULL, NULL, '{\"attributes\":{\"course_id\":29,\"user_id\":2,\"batch_id\":\"67ed58c6-7b65-3193-9e4b-a6c86456321f\",\"is_syllabus\":0}}', '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(14, 'default', 'created', 'App\\Models\\Resource', 14, NULL, NULL, '{\"attributes\":{\"course_id\":8,\"user_id\":9,\"batch_id\":\"9d61c699-4278-3f39-98c2-e5f4a67da0f4\",\"is_syllabus\":0}}', '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(15, 'default', 'created', 'App\\Models\\Resource', 15, NULL, NULL, '{\"attributes\":{\"course_id\":7,\"user_id\":13,\"batch_id\":\"c521731c-78cd-365c-bb33-72182a62db84\",\"is_syllabus\":0}}', '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(16, 'default', 'created', 'App\\Models\\Resource', 16, NULL, NULL, '{\"attributes\":{\"course_id\":22,\"user_id\":13,\"batch_id\":\"280b4522-331b-3757-8bce-b0d38d4575bb\",\"is_syllabus\":0}}', '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(17, 'default', 'created', 'App\\Models\\Resource', 17, NULL, NULL, '{\"attributes\":{\"course_id\":27,\"user_id\":2,\"batch_id\":\"81eb75b8-9ab8-34ec-a99a-ac18b3971597\",\"is_syllabus\":0}}', '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(18, 'default', 'created', 'App\\Models\\Resource', 18, NULL, NULL, '{\"attributes\":{\"course_id\":21,\"user_id\":9,\"batch_id\":\"7d297eca-ce09-3222-96c0-f8434ca56475\",\"is_syllabus\":0}}', '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(19, 'default', 'created', 'App\\Models\\Resource', 19, NULL, NULL, '{\"attributes\":{\"course_id\":2,\"user_id\":9,\"batch_id\":\"61096824-fe05-350c-9b10-7fe2103478b3\",\"is_syllabus\":0}}', '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(20, 'default', 'created', 'App\\Models\\Resource', 20, NULL, NULL, '{\"attributes\":{\"course_id\":17,\"user_id\":9,\"batch_id\":\"9004f545-73dc-3d6a-91eb-90aa345a4b37\",\"is_syllabus\":0}}', '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(21, 'default', 'created', 'App\\Models\\Resource', 21, NULL, NULL, '{\"attributes\":{\"course_id\":29,\"user_id\":2,\"batch_id\":\"bb2ca4b8-a885-3c9b-a25d-b3e58ca8d0f2\",\"is_syllabus\":0}}', '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(22, 'default', 'created', 'App\\Models\\Resource', 22, NULL, NULL, '{\"attributes\":{\"course_id\":21,\"user_id\":2,\"batch_id\":\"64ce3f6e-c1ba-32d3-809d-f8f0206c5fa0\",\"is_syllabus\":0}}', '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(23, 'default', 'created', 'App\\Models\\Resource', 23, NULL, NULL, '{\"attributes\":{\"course_id\":29,\"user_id\":2,\"batch_id\":\"1431c235-d23f-3962-a836-2ea6b72d3589\",\"is_syllabus\":0}}', '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(24, 'default', 'created', 'App\\Models\\Resource', 24, NULL, NULL, '{\"attributes\":{\"course_id\":3,\"user_id\":9,\"batch_id\":\"d97844ed-f042-3f2a-b4f8-1b0254ac8702\",\"is_syllabus\":0}}', '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(25, 'default', 'created', 'App\\Models\\Resource', 25, NULL, NULL, '{\"attributes\":{\"course_id\":30,\"user_id\":13,\"batch_id\":\"4e7930a9-22cd-3361-be7b-d383696f3afb\",\"is_syllabus\":0}}', '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(26, 'default', 'created', 'App\\Models\\Resource', 26, NULL, NULL, '{\"attributes\":{\"course_id\":3,\"user_id\":2,\"batch_id\":\"02d997e8-51c2-3551-a094-d92119aa29a7\",\"is_syllabus\":0}}', '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(27, 'default', 'created', 'App\\Models\\Resource', 27, NULL, NULL, '{\"attributes\":{\"course_id\":21,\"user_id\":2,\"batch_id\":\"689c2314-4d73-348d-860e-f5035cfd91fb\",\"is_syllabus\":0}}', '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(28, 'default', 'created', 'App\\Models\\Resource', 28, NULL, NULL, '{\"attributes\":{\"course_id\":30,\"user_id\":13,\"batch_id\":\"174393a2-3331-3e33-a514-32508e86ed01\",\"is_syllabus\":0}}', '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(29, 'default', 'created', 'App\\Models\\Resource', 29, NULL, NULL, '{\"attributes\":{\"course_id\":27,\"user_id\":2,\"batch_id\":\"461a5240-8af5-33d6-9a32-624b8946e1e7\",\"is_syllabus\":0}}', '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(30, 'default', 'created', 'App\\Models\\Resource', 30, NULL, NULL, '{\"attributes\":{\"course_id\":6,\"user_id\":2,\"batch_id\":\"9e7e8ffd-2676-3fed-b82f-7d73e8244d12\",\"is_syllabus\":0}}', '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(31, 'default', 'created', 'App\\Models\\Resource', 31, NULL, NULL, '{\"attributes\":{\"course_id\":18,\"user_id\":2,\"batch_id\":\"021f5152-6f28-31c8-a460-629f0e3fe14a\",\"is_syllabus\":0}}', '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(32, 'default', 'created', 'App\\Models\\Resource', 32, NULL, NULL, '{\"attributes\":{\"course_id\":4,\"user_id\":2,\"batch_id\":\"25c9e75e-c92a-3949-a7ee-02cf0eb3d1ee\",\"is_syllabus\":0}}', '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(33, 'default', 'created', 'App\\Models\\Resource', 33, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"82ba025c-1c32-46cb-a18c-ad4c2fc0cab5\",\"is_syllabus\":1}}', '2021-12-07 11:42:11', '2021-12-07 11:42:11'),
(34, 'default', 'created', 'App\\Models\\Resource', 34, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"dd0a7eee-e633-414c-a924-d6a62c1fd9d7\",\"is_syllabus\":1}}', '2021-12-07 11:42:51', '2021-12-07 11:42:51'),
(35, 'default', 'created', 'App\\Models\\Resource', 35, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"420f41d3-054b-405c-aab3-62dc47122920\",\"is_syllabus\":1}}', '2021-12-07 12:16:35', '2021-12-07 12:16:35'),
(36, 'default', 'created', 'App\\Models\\Resource', 36, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"436496e3-5b8b-40cd-b637-12b229f9c594\",\"is_syllabus\":1}}', '2021-12-07 12:17:44', '2021-12-07 12:17:44'),
(37, 'default', 'created', 'App\\Models\\Resource', 37, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"2ca326a4-7914-45d1-878d-d45ba8f199a7\",\"is_syllabus\":1}}', '2021-12-07 12:18:06', '2021-12-07 12:18:06'),
(38, 'default', 'created', 'App\\Models\\Resource', 38, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"7ee293ce-db74-49f9-a454-029985765b89\",\"is_syllabus\":1}}', '2021-12-07 12:18:18', '2021-12-07 12:18:18'),
(39, 'default', 'created', 'App\\Models\\Resource', 39, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"3e0bfa09-76d3-464e-bec3-37dd3e322a8d\",\"is_syllabus\":1}}', '2021-12-07 12:19:49', '2021-12-07 12:19:49'),
(40, 'default', 'created', 'App\\Models\\Resource', 40, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"004ef128-ee7d-4722-9930-daf10adb3b9e\",\"is_syllabus\":1}}', '2021-12-07 12:20:54', '2021-12-07 12:20:54'),
(41, 'default', 'created', 'App\\Models\\Resource', 41, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"3690d522-1332-4d4f-a392-3258a3358b90\",\"is_syllabus\":1}}', '2021-12-07 12:21:29', '2021-12-07 12:21:29'),
(42, 'default', 'created', 'App\\Models\\Resource', 42, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"59218914-9d50-4f6e-a591-69536db2abaa\",\"is_syllabus\":1}}', '2021-12-07 12:21:52', '2021-12-07 12:21:52'),
(43, 'default', 'created', 'App\\Models\\Resource', 43, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"094bfa03-c6cd-4e6d-85e0-8e312d68a73d\",\"is_syllabus\":1}}', '2021-12-07 12:22:54', '2021-12-07 12:22:54'),
(44, 'default', 'created', 'App\\Models\\Resource', 44, 'App\\Models\\User', 15, '{\"attributes\":{\"course_id\":2,\"user_id\":15,\"batch_id\":\"7edb1d19-8b72-4998-9f35-d98f48a71ef3\",\"is_syllabus\":1}}', '2021-12-07 12:28:36', '2021-12-07 12:28:36'),
(45, 'default', 'approved', 'App\\Models\\Resource', 42, 'App\\Models\\User', 1, '[]', '2022-01-05 05:40:59', '2022-01-05 05:40:59');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `resource_id` bigint(20) UNSIGNED NOT NULL,
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `resource_id`, `comment`, `comment_type`, `created_at`, `updated_at`) VALUES
(1, 1, 42, '', 'approved', '2022-01-05 05:40:58', '2022-01-05 05:40:58'),
(2, 1, 42, 'wqeq', 'regular', '2022-01-05 05:42:37', '2022-01-05 05:42:37');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `year_level` int(11) NOT NULL,
  `semester` int(11) NOT NULL,
  `term` int(11) NOT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `code`, `title`, `program_id`, `year_level`, `semester`, `term`, `archived_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'SC', 'Missouri', 2, 3, 2, 2, NULL, NULL, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(2, 'ME', 'Alabama', 1, 4, 2, 2, NULL, NULL, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(3, 'VA', 'West Virginia', 1, 4, 2, 2, NULL, NULL, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(4, 'WY', 'Indiana', 2, 1, 2, 1, NULL, NULL, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(5, 'AL', 'Illinois', 2, 1, 2, 2, NULL, NULL, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(6, 'WY', 'Colorado', 1, 3, 1, 2, NULL, NULL, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(7, 'LA', 'Kentucky', 2, 4, 1, 2, NULL, NULL, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(8, 'UT', 'Wyoming', 1, 3, 2, 2, NULL, NULL, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(9, 'MO', 'Rhode Island', 1, 3, 2, 2, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(10, 'TN', 'Maryland', 2, 2, 2, 2, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(11, 'KS', 'Pennsylvania', 1, 4, 2, 1, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(12, 'FL', 'Oklahoma', 2, 2, 1, 2, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(13, 'TX', 'North Dakota', 2, 1, 1, 1, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(14, 'IN', 'Arizona', 2, 3, 2, 1, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(15, 'ME', 'Maine', 1, 2, 1, 2, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(16, 'PA', 'Wisconsin', 2, 4, 2, 1, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(17, 'MA', 'Colorado', 1, 1, 1, 2, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(18, 'TX', 'New York', 2, 1, 1, 1, NULL, NULL, '2021-12-07 09:06:09', '2021-12-07 09:06:09'),
(19, 'ME', 'Arizona', 2, 2, 2, 2, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(20, 'CA', 'Arkansas', 2, 3, 2, 2, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(21, 'NE', 'Wisconsin', 1, 2, 2, 2, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(22, 'UT', 'Virginia', 2, 2, 1, 2, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(23, 'CO', 'Wyoming', 1, 2, 2, 1, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(24, 'WA', 'Texas', 2, 1, 1, 1, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(25, 'OH', 'Missouri', 2, 3, 2, 2, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(26, 'MS', 'California', 2, 2, 2, 2, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(27, 'KY', 'North Carolina', 1, 4, 2, 1, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(28, 'HI', 'Alabama', 2, 4, 1, 2, NULL, NULL, '2021-12-07 09:06:10', '2021-12-07 09:06:10'),
(29, 'RI', 'Ohio', 1, 4, 1, 1, NULL, NULL, '2021-12-07 09:06:11', '2021-12-07 09:06:11'),
(30, 'NH', 'South Carolina', 2, 4, 2, 2, NULL, NULL, '2021-12-07 09:06:11', '2021-12-07 09:06:11');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `collection_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mime_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `disk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `conversions_disk` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `model_type`, `model_id`, `uuid`, `collection_name`, `name`, `file_name`, `mime_type`, `disk`, `conversions_disk`, `size`, `manipulations`, `custom_properties`, `generated_conversions`, `responsive_images`, `order_column`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Resource', 1, '0256a7ac-8b2c-4b70-94e3-4ed521b6dd54', 'default', 'fak6D63', 'fak6D63.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 1, '2021-12-07 09:06:18', '2021-12-07 09:06:18'),
(2, 'App\\Models\\Resource', 2, 'e0473327-e0c6-4d33-a00a-4cfa344e725c', 'default', 'fak7244', 'fak7244.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 2, '2021-12-07 09:06:19', '2021-12-07 09:06:19'),
(3, 'App\\Models\\Resource', 3, '0513b1e4-073e-45d4-8323-a237cb465c89', 'default', 'fak76E7', 'fak76E7.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 3, '2021-12-07 09:06:20', '2021-12-07 09:06:20'),
(4, 'App\\Models\\Resource', 4, '15e19dc1-8dd5-4d8c-aada-c3f560d52dc6', 'default', 'fak77B3', 'fak77B3.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 4, '2021-12-07 09:06:20', '2021-12-07 09:06:20'),
(5, 'App\\Models\\Resource', 5, '012b5611-c2c7-4460-971c-3146c4d9c788', 'default', 'fak78AD', 'fak78AD.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 5, '2021-12-07 09:06:20', '2021-12-07 09:06:20'),
(6, 'App\\Models\\Resource', 6, '7873fdf4-1551-46cd-88ab-dfa5cbee4d67', 'default', 'fak7BBA', 'fak7BBA.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 6, '2021-12-07 09:06:21', '2021-12-07 09:06:21'),
(7, 'App\\Models\\Resource', 7, '0f49a7d3-1b56-4a04-ab8f-a5e1bab4dbfe', 'default', 'fak7DBE', 'fak7DBE.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 7, '2021-12-07 09:06:22', '2021-12-07 09:06:22'),
(8, 'App\\Models\\Resource', 8, '6f3b80e3-f1ac-440b-8293-36b3eeb4f6c9', 'default', 'fak7FF1', 'fak7FF1.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 8, '2021-12-07 09:06:22', '2021-12-07 09:06:22'),
(9, 'App\\Models\\Resource', 9, 'e27293fe-3624-4991-a327-f0a5fce0f4fb', 'default', 'fak80FB', 'fak80FB.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 9, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(10, 'App\\Models\\Resource', 10, 'a8dc8645-3ba2-44a4-9d7e-b8b79831aee5', 'default', 'fak81A8', 'fak81A8.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 10, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(11, 'App\\Models\\Resource', 11, '5fa4d6d4-e088-42ec-889b-e8fe76da723a', 'default', 'fak8273', 'fak8273.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 11, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(12, 'App\\Models\\Resource', 12, '4ba18f20-e19e-4599-a01e-e5304bfd1536', 'default', 'fak836E', 'fak836E.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 12, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(13, 'App\\Models\\Resource', 13, '69ad209e-37e8-4edf-be5c-82bf1561d83c', 'default', 'fak8449', 'fak8449.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 13, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(14, 'App\\Models\\Resource', 14, '9902e8cc-4877-4100-80de-7c1cdd5eee0d', 'default', 'fak8515', 'fak8515.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 14, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(15, 'App\\Models\\Resource', 15, '60f66b97-b8ae-482e-86c6-5b6910a7c41d', 'default', 'fak85B2', 'fak85B2.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 15, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(16, 'App\\Models\\Resource', 16, 'f79c4556-8f32-44b1-a1dd-1ff0bf85a2d4', 'default', 'fak8620', 'fak8620.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 16, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(17, 'App\\Models\\Resource', 17, 'ef9416a6-6808-4e5d-a25d-9dc2ea9551c4', 'default', 'fak87A7', 'fak87A7.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 17, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(18, 'App\\Models\\Resource', 18, '6662229a-2b98-480a-946d-1b06d1db0bd0', 'default', 'fak8854', 'fak8854.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 18, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(19, 'App\\Models\\Resource', 19, '4698389e-d1b1-4dba-8a95-eec9b65daf78', 'default', 'fak898D', 'fak898D.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 19, '2021-12-07 09:06:25', '2021-12-07 09:06:25'),
(20, 'App\\Models\\Resource', 20, '92c7f3db-d79c-4b0e-a48b-5bf30399fc05', 'default', 'fak8A2A', 'fak8A2A.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 20, '2021-12-07 09:06:25', '2021-12-07 09:06:25'),
(21, 'App\\Models\\Resource', 21, 'e2249b59-cc8f-4aab-9ac6-f4ac10c8b52d', 'default', 'fak8B44', 'fak8B44.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 21, '2021-12-07 09:06:25', '2021-12-07 09:06:25'),
(22, 'App\\Models\\Resource', 22, '75449156-d42b-42b5-91f0-7caa041ee9a6', 'default', 'fak8DB5', 'fak8DB5.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 22, '2021-12-07 09:06:26', '2021-12-07 09:06:26'),
(23, 'App\\Models\\Resource', 23, 'a2bf241b-4e4d-47dd-9497-818eb1f97b83', 'default', 'fak90A3', 'fak90A3.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 23, '2021-12-07 09:06:27', '2021-12-07 09:06:27'),
(24, 'App\\Models\\Resource', 24, 'd711d26b-1c3b-473e-851a-fe680ad206a4', 'default', 'fak91AD', 'fak91AD.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 24, '2021-12-07 09:06:27', '2021-12-07 09:06:27'),
(25, 'App\\Models\\Resource', 25, '6933bad3-f731-45f6-9bcb-234649dc5b58', 'default', 'fak9315', 'fak9315.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 25, '2021-12-07 09:06:27', '2021-12-07 09:06:27'),
(26, 'App\\Models\\Resource', 26, 'f7f2d10d-65b0-46c3-8b4a-84b2f567b774', 'default', 'fak9373', 'fak9373.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 26, '2021-12-07 09:06:27', '2021-12-07 09:06:27'),
(27, 'App\\Models\\Resource', 27, 'e8360e6c-a863-401d-a78c-a5e7d093c3cf', 'default', 'fak947E', 'fak947E.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 27, '2021-12-07 09:06:28', '2021-12-07 09:06:28'),
(28, 'App\\Models\\Resource', 28, '79db1d78-e85e-42ae-9d6d-69ce6190d098', 'default', 'fak9559', 'fak9559.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 28, '2021-12-07 09:06:28', '2021-12-07 09:06:28'),
(29, 'App\\Models\\Resource', 29, 'b0345e2e-03b0-4d6d-b66e-e38c47c789e3', 'default', 'fak96F0', 'fak96F0.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 29, '2021-12-07 09:06:28', '2021-12-07 09:06:28'),
(30, 'App\\Models\\Resource', 30, 'b900599a-99b5-4a97-9427-b396f2fba876', 'default', 'fak97BB', 'fak97BB.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 30, '2021-12-07 09:06:28', '2021-12-07 09:06:28'),
(31, 'App\\Models\\Resource', 31, '9a077e5b-5afe-4528-b279-9fec40ca672a', 'default', 'fak98B6', 'fak98B6.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 31, '2021-12-07 09:06:29', '2021-12-07 09:06:29'),
(32, 'App\\Models\\Resource', 32, '448fd186-b424-438f-b67b-afa45f5e5c0f', 'default', 'fak99D0', 'fak99D0.tmp', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 32, '2021-12-07 09:06:29', '2021-12-07 09:06:29'),
(33, 'App\\Models\\Resource', 34, '43b0bf63-4c55-437b-b02c-588319649c64', 'default', 'medC4E5', 'syllabus-20211207-1638877371.pdf', 'application/x-empty', 'public', 'public', 0, '[]', '[]', '[]', '[]', 33, '2021-12-07 11:42:51', '2021-12-07 11:42:51'),
(34, 'App\\Models\\Resource', 38, '07b303a2-e4c0-4f6c-ac31-1e76f6c43205', 'default', 'test2', 'syllabus-20211207-1638879497.pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'public', 'public', 78152, '[]', '[]', '[]', '[]', 34, '2021-12-07 12:18:18', '2021-12-07 12:18:18'),
(35, 'App\\Models\\Resource', 39, 'f81e2aec-6968-466e-9aef-d80e1910801a', 'default', 'test2', 'syllabus-20211207-1638879589.pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'public', 'public', 78152, '[]', '[]', '[]', '[]', 35, '2021-12-07 12:19:50', '2021-12-07 12:19:50'),
(36, 'App\\Models\\Resource', 42, '628348ab-9b0e-4819-a2d1-9f713f3732f8', 'default', 'test2', 'syllabus-20211207-1638879712.pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'public', 'public', 78152, '[]', '[]', '[]', '[]', 36, '2021-12-07 12:21:53', '2021-12-07 12:21:53'),
(37, 'App\\Models\\Resource', 43, 'ab2a67cd-a2f9-41ae-bc49-17d44e041318', 'default', 'test2', 'syllabus-20211207-1638879774.pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'public', 'public', 78152, '[]', '[]', '[]', '[]', 37, '2021-12-07 12:22:55', '2021-12-07 12:22:55'),
(38, 'App\\Models\\Resource', 44, 'a31e38c7-5544-45e3-b31a-fd1851eacca2', 'default', 'test2', 'syllabus-20211207-1638880116.pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'public', 'public', 78152, '[]', '[]', '[]', '[]', 38, '2021-12-07 12:28:36', '2021-12-07 12:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2021_07_25_184738_create_temporary_uploads_table', 1),
(3, '2021_07_26_070250_create_roles_table', 1),
(4, '2021_07_27_142849_create_programs_table', 1),
(5, '2021_07_27_142906_create_courses_table', 1),
(6, '2021_07_28_000000_create_users_table', 1),
(7, '2021_08_26_202708_create_resources_table', 1),
(8, '2021_08_28_014729_create_syllabi_table', 1),
(9, '2021_09_02_023451_create_resource_user_table', 1),
(10, '2021_09_02_061510_create_media_table', 1),
(11, '2021_09_05_184441_create_activity_log_table', 1),
(12, '2021_09_07_012420_create_notifications_table', 1),
(13, '2021_09_20_153844_create_comments_table', 1),
(14, '2021_09_27_164451_create_program_user_table', 1),
(15, '2021_11_20_194154_create_resource_downloads_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint(20) UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('0cffdc07-5748-4ba4-abd9-d4e589f82aa2', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 12, '{\"user\":\"Renee McDermott\",\"resource_id\":44,\"file_name\":\"syllabus-20211207-1638880116.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:28:37', '2021-12-07 12:28:37'),
('223ffa7c-f442-4512-985f-8e1f4b532d3e', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 3, '{\"user\":\"Renee McDermott\",\"resource_id\":34,\"file_name\":\"syllabus-20211207-1638877371.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 11:42:52', '2021-12-07 11:42:52'),
('60ce0e94-f18d-4ae0-a395-6a0c40743b12', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 12, '{\"user\":\"Renee McDermott\",\"resource_id\":34,\"file_name\":\"syllabus-20211207-1638877371.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 11:42:53', '2021-12-07 11:42:53'),
('72eed0f9-24ba-40f3-ab6c-910c095fb523', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 12, '{\"user\":\"Renee McDermott\",\"resource_id\":42,\"file_name\":\"syllabus-20211207-1638879712.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:21:53', '2021-12-07 12:21:53'),
('7fc938e1-7502-4778-b178-3e635d2a6d5e', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 3, '{\"user\":\"Renee McDermott\",\"resource_id\":44,\"file_name\":\"syllabus-20211207-1638880116.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:28:36', '2021-12-07 12:28:36'),
('9c41f7b7-f269-431b-bdb5-f71f85f2224b', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 12, '{\"user\":\"Renee McDermott\",\"resource_id\":43,\"file_name\":\"syllabus-20211207-1638879774.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:22:56', '2021-12-07 12:22:56'),
('a6754f3e-24e0-479a-9f3e-aa46fb7a270e', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 3, '{\"user\":\"Renee McDermott\",\"resource_id\":42,\"file_name\":\"syllabus-20211207-1638879712.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:21:53', '2021-12-07 12:21:53'),
('a846439f-96b4-48c5-b831-f338792de1bd', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 1, '{\"user\":\"Renee McDermott\",\"resource_id\":42,\"file_name\":\"syllabus-20211207-1638879712.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', '2022-01-05 05:40:49', '2021-12-07 12:21:53', '2022-01-05 05:40:49'),
('aeceb718-64e9-47e8-99fb-ee22ea734a21', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 1, '{\"user\":\"Renee McDermott\",\"resource_id\":34,\"file_name\":\"syllabus-20211207-1638877371.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 11:42:52', '2021-12-07 11:42:52'),
('b560a388-55ef-4215-b1b9-c286512ed430', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 8, '{\"user\":\"Renee McDermott\",\"resource_id\":44,\"file_name\":\"syllabus-20211207-1638880116.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:28:37', '2021-12-07 12:28:37'),
('b8dafdc6-0022-4568-959d-299175abc1f0', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 1, '{\"user\":\"Renee McDermott\",\"resource_id\":43,\"file_name\":\"syllabus-20211207-1638879774.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:22:55', '2021-12-07 12:22:55'),
('c05d4395-a110-404d-af57-b8f8f56c34e3', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 8, '{\"user\":\"Renee McDermott\",\"resource_id\":34,\"file_name\":\"syllabus-20211207-1638877371.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 11:42:52', '2021-12-07 11:42:52'),
('ce5c63a5-e83f-47c1-957c-a6ab2ee7bb95', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 8, '{\"user\":\"Renee McDermott\",\"resource_id\":43,\"file_name\":\"syllabus-20211207-1638879774.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:22:55', '2021-12-07 12:22:55'),
('eba8f8a2-2850-4b69-8c58-f0c38004ff48', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 8, '{\"user\":\"Renee McDermott\",\"resource_id\":42,\"file_name\":\"syllabus-20211207-1638879712.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:21:53', '2021-12-07 12:21:53'),
('f320d0b8-5c59-475d-bb98-d73148295437', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 3, '{\"user\":\"Renee McDermott\",\"resource_id\":43,\"file_name\":\"syllabus-20211207-1638879774.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:22:55', '2021-12-07 12:22:55'),
('f9ea1666-60ee-4366-9473-6ef91a8c104d', 'App\\Notifications\\NewResourceNotification', 'App\\Models\\User', 1, '{\"user\":\"Renee McDermott\",\"resource_id\":44,\"file_name\":\"syllabus-20211207-1638880116.pdf\",\"program_id\":1,\"course_code\":\"ME\",\"is_syllabus\":1}', NULL, '2021-12-07 12:28:36', '2021-12-07 12:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `programs`
--

CREATE TABLE `programs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `programs`
--

INSERT INTO `programs` (`id`, `code`, `title`, `created_at`, `updated_at`) VALUES
(1, 'BSIT', 'Bachelor of Science in Information Technology', '2021-12-07 09:06:01', '2021-12-07 09:06:01'),
(2, 'BSHM', 'Bachelor of Science in Hospitality Management', '2021-12-07 09:06:02', '2021-12-07 09:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `program_user`
--

CREATE TABLE `program_user` (
  `program_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `program_user`
--

INSERT INTO `program_user` (`program_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2021-12-07 09:06:05', '2021-12-07 09:06:05'),
(1, 2, '2021-12-07 09:06:06', '2021-12-07 09:06:06'),
(1, 3, '2021-12-07 09:06:06', '2021-12-07 09:06:06'),
(2, 4, '2021-12-07 09:06:06', '2021-12-07 09:06:06'),
(1, 5, '2021-12-07 09:06:06', '2021-12-07 09:06:06'),
(2, 5, '2021-12-07 09:06:06', '2021-12-07 09:06:06'),
(2, 6, '2021-12-07 09:06:06', '2021-12-07 09:06:06'),
(1, 7, '2021-12-07 09:06:07', '2021-12-07 09:06:07'),
(2, 7, '2021-12-07 09:06:07', '2021-12-07 09:06:07'),
(1, 8, '2021-12-07 09:06:07', '2021-12-07 09:06:07'),
(1, 9, '2021-12-07 09:06:07', '2021-12-07 09:06:07'),
(1, 10, '2021-12-07 09:06:07', '2021-12-07 09:06:07'),
(2, 10, '2021-12-07 09:06:07', '2021-12-07 09:06:07'),
(1, 11, '2021-12-07 09:06:07', '2021-12-07 09:06:07'),
(2, 11, '2021-12-07 09:06:07', '2021-12-07 09:06:07'),
(1, 12, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(2, 13, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(2, 14, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(1, 15, '2021-12-07 09:06:08', '2021-12-07 09:06:08'),
(2, 15, '2021-12-07 09:06:08', '2021-12-07 09:06:08');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_syllabus` tinyint(1) NOT NULL DEFAULT 0,
  `downloads` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `rejected_at` timestamp NULL DEFAULT NULL,
  `archived_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `course_id`, `user_id`, `batch_id`, `title`, `description`, `is_syllabus`, `downloads`, `views`, `approved_at`, `rejected_at`, `archived_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 14, 13, '8e094912-f3dc-3705-ae15-1de816af1c08', 'qui', 'Hic exercitationem vel totam et.', 0, 74, 465, '2021-06-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:11', '2021-12-07 09:06:11'),
(2, 27, 9, '1c955047-b5eb-3383-8ad6-9b95a67cdeee', 'est', 'Necessitatibus incidunt deserunt molestiae vitae.', 0, 16, 34, '2021-08-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:12', '2021-12-07 09:06:12'),
(3, 14, 13, '5cf05a54-2c6e-3c85-85b0-2f32d5ffedd4', 'voluptates', 'Aut laudantium sit est ipsam.', 0, 342, 391, '2021-09-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(4, 29, 9, 'c65d65d7-4b7b-3511-95fc-a76a43d75801', 'delectus', 'Eligendi maiores et magnam aut eligendi eius.', 0, 158, 272, '2021-06-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(5, 30, 13, 'ae0a4603-e7f0-3968-831e-e89c411c6eb3', 'ut', 'Facilis expedita veritatis repellat at.', 0, 52, 117, '2021-06-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(6, 16, 13, 'b0bac09e-32f3-355d-8ba3-d0a7625166a2', 'natus', 'Autem dolor ea dolores ratione cumque autem.', 0, 497, 499, '2021-08-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(7, 7, 13, '45100dc7-b404-320c-82eb-5f6606e28120', 'ut', 'Nihil voluptatem beatae rem est voluptatem.', 0, 244, 46, '2021-08-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(8, 17, 9, '6fbf4db9-68af-3f04-aa25-dd12d3c9db66', 'quae', 'Non quia accusamus quas natus dolor.', 0, 117, 163, '2021-07-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:13', '2021-12-07 09:06:13'),
(9, 14, 13, '0542e1e2-83ca-3a96-bfe8-345bed413b2c', 'at', 'Omnis fuga sed iusto unde sequi.', 0, 135, 215, '2021-07-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(10, 9, 2, '81f3ba5a-24bf-36c8-a0c6-db64ec1045b2', 'voluptate', 'Alias nulla dolor aut error ratione placeat.', 0, 429, 413, '2021-09-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(11, 8, 2, '667a8694-83cb-3ed8-a065-07dc6b94b164', 'ea', 'Dolore in eos ut nesciunt beatae cumque.', 0, 495, 383, '2021-06-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(12, 10, 13, '4ea57f48-981c-380c-922a-58973e3108ee', 'assumenda', 'Non tempore ex a et amet.', 0, 147, 306, '2021-07-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(13, 29, 2, '67ed58c6-7b65-3193-9e4b-a6c86456321f', 'ut', 'Qui saepe cumque enim possimus commodi.', 0, 275, 174, '2021-09-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(14, 8, 9, '9d61c699-4278-3f39-98c2-e5f4a67da0f4', 'sint', 'Facere dolores blanditiis adipisci libero.', 0, 390, 146, '2021-09-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(15, 7, 13, 'c521731c-78cd-365c-bb33-72182a62db84', 'eos', 'Dolorem quo quos dolorem praesentium.', 0, 133, 57, '2021-06-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:14', '2021-12-07 09:06:14'),
(16, 22, 13, '280b4522-331b-3757-8bce-b0d38d4575bb', 'dolorum', 'Blanditiis qui sunt et sunt et qui.', 0, 46, 138, '2021-08-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(17, 27, 2, '81eb75b8-9ab8-34ec-a99a-ac18b3971597', 'totam', 'Voluptatem provident in dicta minus.', 0, 162, 54, '2021-07-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(18, 21, 9, '7d297eca-ce09-3222-96c0-f8434ca56475', 'quia', 'Animi ducimus facilis et quae quam ut veritatis.', 0, 437, 297, '2021-07-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(19, 2, 9, '61096824-fe05-350c-9b10-7fe2103478b3', 'aut', 'Et non repudiandae eveniet in eveniet enim quia.', 0, 468, 335, '2021-08-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(20, 17, 9, '9004f545-73dc-3d6a-91eb-90aa345a4b37', 'blanditiis', 'Doloremque sunt tempora perferendis sed quae.', 0, 216, 135, '2021-06-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(21, 29, 2, 'bb2ca4b8-a885-3c9b-a25d-b3e58ca8d0f2', 'numquam', 'Deleniti dolorem quam non pariatur tempore.', 0, 439, 234, '2021-09-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:15', '2021-12-07 09:06:15'),
(22, 21, 2, '64ce3f6e-c1ba-32d3-809d-f8f0206c5fa0', 'rerum', 'Perspiciatis ipsa quasi excepturi quidem esse.', 0, 356, 84, '2021-07-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(23, 29, 2, '1431c235-d23f-3962-a836-2ea6b72d3589', 'et', 'Aut et esse mollitia aliquid ad.', 0, 273, 473, '2021-07-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(24, 3, 9, 'd97844ed-f042-3f2a-b4f8-1b0254ac8702', 'laboriosam', 'Sunt quia ut eius aliquid.', 0, 252, 121, '2021-06-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(25, 30, 13, '4e7930a9-22cd-3361-be7b-d383696f3afb', 'incidunt', 'Accusamus officia beatae reprehenderit corporis.', 0, 193, 101, '2021-08-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(26, 3, 2, '02d997e8-51c2-3551-a094-d92119aa29a7', 'aspernatur', 'Consequatur veritatis rerum esse velit et.', 0, 433, 168, '2021-10-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(27, 21, 2, '689c2314-4d73-348d-860e-f5035cfd91fb', 'unde', 'Accusamus qui laudantium eum esse.', 0, 384, 357, '2021-09-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:16', '2021-12-07 09:06:16'),
(28, 30, 13, '174393a2-3331-3e33-a514-32508e86ed01', 'quis', 'Ea architecto ipsum ut provident.', 0, 84, 223, '2021-08-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(29, 27, 2, '461a5240-8af5-33d6-9a32-624b8946e1e7', 'molestiae', 'Harum inventore aut culpa qui ipsa blanditiis.', 0, 148, 286, '2021-08-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(30, 6, 2, '9e7e8ffd-2676-3fed-b82f-7d73e8244d12', 'minima', 'Quia ut optio ut officia.', 0, 415, 97, '2021-10-07 09:06:11', NULL, NULL, NULL, '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(31, 18, 2, '021f5152-6f28-31c8-a460-629f0e3fe14a', 'et', 'Quia ut alias a recusandae natus et.', 0, 467, 339, '2021-08-07 09:06:17', NULL, NULL, '2021-12-07 09:06:17', '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(32, 4, 2, '25c9e75e-c92a-3949-a7ee-02cf0eb3d1ee', 'et', 'Natus repellendus ipsum impedit debitis.', 0, 325, 187, '2021-06-07 09:06:17', NULL, NULL, NULL, '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(33, 2, 15, '82ba025c-1c32-46cb-a18c-ad4c2fc0cab5', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 11:42:11', '2021-12-07 11:42:11'),
(34, 2, 15, 'dd0a7eee-e633-414c-a924-d6a62c1fd9d7', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 11:42:51', '2021-12-07 11:42:51'),
(35, 2, 15, '420f41d3-054b-405c-aab3-62dc47122920', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:16:34', '2021-12-07 12:16:34'),
(36, 2, 15, '436496e3-5b8b-40cd-b637-12b229f9c594', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:17:44', '2021-12-07 12:17:44'),
(37, 2, 15, '2ca326a4-7914-45d1-878d-d45ba8f199a7', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:18:05', '2021-12-07 12:18:05'),
(38, 2, 15, '7ee293ce-db74-49f9-a454-029985765b89', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:18:17', '2021-12-07 12:18:17'),
(39, 2, 15, '3e0bfa09-76d3-464e-bec3-37dd3e322a8d', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:19:49', '2021-12-07 12:19:49'),
(40, 2, 15, '004ef128-ee7d-4722-9930-daf10adb3b9e', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:20:54', '2021-12-07 12:20:54'),
(41, 2, 15, '3690d522-1332-4d4f-a392-3258a3358b90', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:21:29', '2021-12-07 12:21:29'),
(42, 2, 15, '59218914-9d50-4f6e-a591-69536db2abaa', NULL, 'lorem', 1, NULL, NULL, NULL, '2022-01-05 05:41:10', NULL, NULL, '2021-12-07 12:21:52', '2022-01-05 05:41:10'),
(43, 2, 15, '094bfa03-c6cd-4e6d-85e0-8e312d68a73d', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:22:54', '2021-12-07 12:22:54'),
(44, 2, 15, '7edb1d19-8b72-4998-9f35-d98f48a71ef3', NULL, 'lorem', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:28:36', '2021-12-07 12:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `resource_downloads`
--

CREATE TABLE `resource_downloads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `resource_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resource_downloads`
--

INSERT INTO `resource_downloads` (`id`, `resource_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 13, 10, '2021-12-07 09:06:29', '2021-12-07 09:06:29'),
(2, 28, 4, '2021-12-07 09:06:29', '2021-12-07 09:06:29'),
(3, 14, 5, '2021-12-07 09:06:30', '2021-12-07 09:06:30'),
(4, 3, 8, '2021-12-07 09:06:30', '2021-12-07 09:06:30'),
(5, 23, 5, '2021-12-07 09:06:30', '2021-12-07 09:06:30'),
(6, 5, 7, '2021-12-07 09:06:30', '2021-12-07 09:06:30'),
(7, 3, 9, '2021-12-07 09:06:30', '2021-12-07 09:06:30'),
(8, 17, 12, '2021-12-07 09:06:31', '2021-12-07 09:06:31'),
(9, 1, 8, '2021-12-07 09:06:31', '2021-12-07 09:06:31'),
(10, 14, 14, '2021-12-07 09:06:31', '2021-12-07 09:06:31'),
(11, 29, 6, '2021-12-07 09:06:31', '2021-12-07 09:06:31'),
(12, 28, 6, '2021-12-07 09:06:31', '2021-12-07 09:06:31'),
(13, 7, 14, '2021-12-07 09:06:31', '2021-12-07 09:06:31'),
(14, 19, 15, '2021-12-07 09:06:32', '2021-12-07 09:06:32'),
(15, 18, 11, '2021-12-07 09:06:33', '2021-12-07 09:06:33'),
(16, 29, 1, '2021-12-07 09:06:33', '2021-12-07 09:06:33'),
(17, 18, 3, '2021-12-07 09:06:34', '2021-12-07 09:06:34'),
(18, 14, 2, '2021-12-07 09:06:35', '2021-12-07 09:06:35'),
(19, 27, 11, '2021-12-07 09:06:35', '2021-12-07 09:06:35'),
(20, 15, 13, '2021-12-07 09:06:35', '2021-12-07 09:06:35'),
(21, 5, 8, '2021-12-07 09:06:35', '2021-12-07 09:06:35'),
(22, 4, 12, '2021-12-07 09:06:35', '2021-12-07 09:06:35'),
(23, 15, 9, '2021-12-07 09:06:35', '2021-12-07 09:06:35'),
(24, 15, 10, '2021-12-07 09:06:35', '2021-12-07 09:06:35'),
(25, 9, 14, '2021-12-07 09:06:35', '2021-12-07 09:06:35'),
(26, 18, 10, '2021-12-07 09:06:36', '2021-12-07 09:06:36'),
(27, 2, 2, '2021-12-07 09:06:36', '2021-12-07 09:06:36'),
(28, 21, 1, '2021-12-07 09:06:36', '2021-12-07 09:06:36'),
(29, 7, 4, '2021-12-07 09:06:36', '2021-12-07 09:06:36'),
(30, 25, 3, '2021-12-07 09:06:36', '2021-12-07 09:06:36'),
(31, 9, 5, '2021-12-07 09:06:36', '2021-12-07 09:06:36'),
(32, 21, 6, '2021-12-07 09:06:36', '2021-12-07 09:06:36'),
(33, 15, 2, '2021-12-07 09:06:37', '2021-12-07 09:06:37'),
(34, 13, 4, '2021-12-07 09:06:37', '2021-12-07 09:06:37'),
(35, 4, 15, '2021-12-07 09:06:37', '2021-12-07 09:06:37'),
(36, 24, 2, '2021-12-07 09:06:37', '2021-12-07 09:06:37'),
(37, 32, 13, '2021-12-07 09:06:37', '2021-12-07 09:06:37'),
(38, 30, 11, '2021-12-07 09:06:37', '2021-12-07 09:06:37'),
(39, 20, 5, '2021-12-07 09:06:38', '2021-12-07 09:06:38'),
(40, 11, 12, '2021-12-07 09:06:38', '2021-12-07 09:06:38'),
(41, 3, 3, '2021-12-07 09:06:38', '2021-12-07 09:06:38'),
(42, 3, 10, '2021-12-07 09:06:38', '2021-12-07 09:06:38'),
(43, 15, 3, '2021-12-07 09:06:38', '2021-12-07 09:06:38'),
(44, 26, 8, '2021-12-07 09:06:38', '2021-12-07 09:06:38'),
(45, 27, 12, '2021-12-07 09:06:39', '2021-12-07 09:06:39'),
(46, 30, 6, '2021-12-07 09:06:39', '2021-12-07 09:06:39'),
(47, 32, 8, '2021-12-07 09:06:39', '2021-12-07 09:06:39'),
(48, 27, 5, '2021-12-07 09:06:39', '2021-12-07 09:06:39'),
(49, 24, 4, '2021-12-07 09:06:39', '2021-12-07 09:06:39'),
(50, 28, 2, '2021-12-07 09:06:39', '2021-12-07 09:06:39'),
(51, 24, 11, '2021-12-07 09:06:39', '2021-12-07 09:06:39'),
(52, 11, 4, '2021-12-07 09:06:40', '2021-12-07 09:06:40'),
(53, 30, 9, '2021-12-07 09:06:40', '2021-12-07 09:06:40'),
(54, 9, 4, '2021-12-07 09:06:40', '2021-12-07 09:06:40'),
(55, 6, 10, '2021-12-07 09:06:40', '2021-12-07 09:06:40'),
(56, 10, 13, '2021-12-07 09:06:40', '2021-12-07 09:06:40'),
(57, 7, 1, '2021-12-07 09:06:40', '2021-12-07 09:06:40'),
(58, 20, 6, '2021-12-07 09:06:40', '2021-12-07 09:06:40'),
(59, 1, 15, '2021-12-07 09:06:41', '2021-12-07 09:06:41'),
(60, 18, 1, '2021-12-07 09:06:41', '2021-12-07 09:06:41'),
(61, 30, 5, '2021-12-07 09:06:41', '2021-12-07 09:06:41'),
(62, 9, 1, '2021-12-07 09:06:41', '2021-12-07 09:06:41'),
(63, 18, 14, '2021-12-07 09:06:41', '2021-12-07 09:06:41'),
(64, 7, 11, '2021-12-07 09:06:41', '2021-12-07 09:06:41'),
(65, 23, 13, '2021-12-07 09:06:41', '2021-12-07 09:06:41'),
(66, 22, 14, '2021-12-07 09:06:41', '2021-12-07 09:06:41'),
(67, 12, 9, '2021-12-07 09:06:42', '2021-12-07 09:06:42'),
(68, 2, 8, '2021-12-07 09:06:42', '2021-12-07 09:06:42'),
(69, 14, 11, '2021-12-07 09:06:42', '2021-12-07 09:06:42'),
(70, 30, 14, '2021-12-07 09:06:42', '2021-12-07 09:06:42'),
(71, 32, 4, '2021-12-07 09:06:42', '2021-12-07 09:06:42'),
(72, 22, 6, '2021-12-07 09:06:42', '2021-12-07 09:06:42'),
(73, 30, 9, '2021-12-07 09:06:42', '2021-12-07 09:06:42'),
(74, 14, 1, '2021-12-07 09:06:43', '2021-12-07 09:06:43'),
(75, 6, 13, '2021-12-07 09:06:43', '2021-12-07 09:06:43'),
(76, 21, 4, '2021-12-07 09:06:43', '2021-12-07 09:06:43'),
(77, 19, 2, '2021-12-07 09:06:43', '2021-12-07 09:06:43'),
(78, 13, 1, '2021-12-07 09:06:43', '2021-12-07 09:06:43'),
(79, 30, 13, '2021-12-07 09:06:43', '2021-12-07 09:06:43'),
(80, 24, 13, '2021-12-07 09:06:43', '2021-12-07 09:06:43'),
(81, 9, 6, '2021-12-07 09:06:44', '2021-12-07 09:06:44'),
(82, 14, 1, '2021-12-07 09:06:44', '2021-12-07 09:06:44'),
(83, 14, 14, '2021-12-07 09:06:45', '2021-12-07 09:06:45'),
(84, 22, 1, '2021-12-07 09:06:45', '2021-12-07 09:06:45'),
(85, 25, 3, '2021-12-07 09:06:45', '2021-12-07 09:06:45'),
(86, 12, 8, '2021-12-07 09:06:45', '2021-12-07 09:06:45'),
(87, 10, 10, '2021-12-07 09:06:45', '2021-12-07 09:06:45'),
(88, 8, 6, '2021-12-07 09:06:46', '2021-12-07 09:06:46'),
(89, 30, 2, '2021-12-07 09:06:46', '2021-12-07 09:06:46'),
(90, 21, 5, '2021-12-07 09:06:46', '2021-12-07 09:06:46'),
(91, 28, 10, '2021-12-07 09:06:46', '2021-12-07 09:06:46'),
(92, 27, 11, '2021-12-07 09:06:46', '2021-12-07 09:06:46'),
(93, 22, 2, '2021-12-07 09:06:46', '2021-12-07 09:06:46'),
(94, 7, 1, '2021-12-07 09:06:47', '2021-12-07 09:06:47'),
(95, 5, 15, '2021-12-07 09:06:47', '2021-12-07 09:06:47'),
(96, 9, 4, '2021-12-07 09:06:47', '2021-12-07 09:06:47'),
(97, 21, 4, '2021-12-07 09:06:47', '2021-12-07 09:06:47'),
(98, 19, 6, '2021-12-07 09:06:47', '2021-12-07 09:06:47'),
(99, 23, 12, '2021-12-07 09:06:47', '2021-12-07 09:06:47'),
(100, 3, 7, '2021-12-07 09:06:47', '2021-12-07 09:06:47'),
(101, 24, 13, '2021-12-07 09:06:47', '2021-12-07 09:06:47'),
(102, 22, 14, '2021-12-07 09:06:48', '2021-12-07 09:06:48'),
(103, 12, 3, '2021-12-07 09:06:49', '2021-12-07 09:06:49'),
(104, 12, 8, '2021-12-07 09:06:49', '2021-12-07 09:06:49'),
(105, 7, 10, '2021-12-07 09:06:49', '2021-12-07 09:06:49'),
(106, 4, 10, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(107, 18, 3, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(108, 2, 9, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(109, 23, 11, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(110, 14, 9, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(111, 27, 2, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(112, 17, 3, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(113, 29, 8, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(114, 20, 3, '2021-12-07 09:06:50', '2021-12-07 09:06:50'),
(115, 32, 9, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(116, 10, 5, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(117, 28, 13, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(118, 18, 10, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(119, 7, 3, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(120, 19, 11, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(121, 3, 11, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(122, 21, 14, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(123, 18, 15, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(124, 5, 10, '2021-12-07 09:06:51', '2021-12-07 09:06:51'),
(125, 6, 14, '2021-12-07 09:06:52', '2021-12-07 09:06:52'),
(126, 28, 1, '2021-12-07 09:06:52', '2021-12-07 09:06:52'),
(127, 1, 6, '2021-12-07 09:06:52', '2021-12-07 09:06:52'),
(128, 3, 9, '2021-12-07 09:06:52', '2021-12-07 09:06:52'),
(129, 1, 7, '2021-12-07 09:06:53', '2021-12-07 09:06:53'),
(130, 12, 7, '2021-12-07 09:06:53', '2021-12-07 09:06:53'),
(131, 15, 13, '2021-12-07 09:06:53', '2021-12-07 09:06:53'),
(132, 30, 11, '2021-12-07 09:06:53', '2021-12-07 09:06:53'),
(133, 14, 15, '2021-12-07 09:06:53', '2021-12-07 09:06:53'),
(134, 14, 4, '2021-12-07 09:06:53', '2021-12-07 09:06:53'),
(135, 21, 11, '2021-12-07 09:06:53', '2021-12-07 09:06:53'),
(136, 30, 7, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(137, 17, 14, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(138, 23, 4, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(139, 4, 6, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(140, 29, 8, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(141, 25, 11, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(142, 32, 13, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(143, 10, 11, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(144, 27, 14, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(145, 23, 7, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(146, 8, 2, '2021-12-07 09:06:54', '2021-12-07 09:06:54'),
(147, 13, 5, '2021-12-07 09:06:55', '2021-12-07 09:06:55'),
(148, 27, 8, '2021-12-07 09:06:55', '2021-12-07 09:06:55'),
(149, 8, 2, '2021-12-07 09:06:55', '2021-12-07 09:06:55'),
(150, 5, 3, '2021-12-07 09:06:55', '2021-12-07 09:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `resource_user`
--

CREATE TABLE `resource_user` (
  `resource_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `batch_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_important` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `resource_user`
--

INSERT INTO `resource_user` (`resource_id`, `user_id`, `batch_id`, `is_important`, `created_at`, `updated_at`) VALUES
(1, 13, '8e094912-f3dc-3705-ae15-1de816af1c08', 1, '2021-12-07 09:06:17', '2021-12-07 09:06:17'),
(2, 9, '1c955047-b5eb-3383-8ad6-9b95a67cdeee', 1, '2021-12-07 09:06:19', '2021-12-07 09:06:19'),
(3, 13, '5cf05a54-2c6e-3c85-85b0-2f32d5ffedd4', 0, '2021-12-07 09:06:19', '2021-12-07 09:06:19'),
(4, 9, 'c65d65d7-4b7b-3511-95fc-a76a43d75801', 1, '2021-12-07 09:06:20', '2021-12-07 09:06:20'),
(5, 13, 'ae0a4603-e7f0-3968-831e-e89c411c6eb3', 1, '2021-12-07 09:06:20', '2021-12-07 09:06:20'),
(6, 13, 'b0bac09e-32f3-355d-8ba3-d0a7625166a2', 1, '2021-12-07 09:06:21', '2021-12-07 09:06:21'),
(7, 13, '45100dc7-b404-320c-82eb-5f6606e28120', 1, '2021-12-07 09:06:21', '2021-12-07 09:06:21'),
(8, 9, '6fbf4db9-68af-3f04-aa25-dd12d3c9db66', 1, '2021-12-07 09:06:22', '2021-12-07 09:06:22'),
(9, 13, '0542e1e2-83ca-3a96-bfe8-345bed413b2c', 1, '2021-12-07 09:06:22', '2021-12-07 09:06:22'),
(10, 2, '81f3ba5a-24bf-36c8-a0c6-db64ec1045b2', 1, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(11, 2, '667a8694-83cb-3ed8-a065-07dc6b94b164', 0, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(12, 13, '4ea57f48-981c-380c-922a-58973e3108ee', 1, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(13, 2, '67ed58c6-7b65-3193-9e4b-a6c86456321f', 0, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(14, 9, '9d61c699-4278-3f39-98c2-e5f4a67da0f4', 0, '2021-12-07 09:06:23', '2021-12-07 09:06:23'),
(15, 13, 'c521731c-78cd-365c-bb33-72182a62db84', 0, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(16, 13, '280b4522-331b-3757-8bce-b0d38d4575bb', 0, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(17, 2, '81eb75b8-9ab8-34ec-a99a-ac18b3971597', 0, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(18, 9, '7d297eca-ce09-3222-96c0-f8434ca56475', 0, '2021-12-07 09:06:24', '2021-12-07 09:06:24'),
(19, 9, '61096824-fe05-350c-9b10-7fe2103478b3', 0, '2021-12-07 09:06:25', '2021-12-07 09:06:25'),
(20, 9, '9004f545-73dc-3d6a-91eb-90aa345a4b37', 0, '2021-12-07 09:06:25', '2021-12-07 09:06:25'),
(21, 2, 'bb2ca4b8-a885-3c9b-a25d-b3e58ca8d0f2', 1, '2021-12-07 09:06:25', '2021-12-07 09:06:25'),
(22, 2, '64ce3f6e-c1ba-32d3-809d-f8f0206c5fa0', 1, '2021-12-07 09:06:25', '2021-12-07 09:06:25'),
(23, 2, '1431c235-d23f-3962-a836-2ea6b72d3589', 1, '2021-12-07 09:06:26', '2021-12-07 09:06:26'),
(24, 9, 'd97844ed-f042-3f2a-b4f8-1b0254ac8702', 1, '2021-12-07 09:06:27', '2021-12-07 09:06:27'),
(25, 13, '4e7930a9-22cd-3361-be7b-d383696f3afb', 1, '2021-12-07 09:06:27', '2021-12-07 09:06:27'),
(26, 2, '02d997e8-51c2-3551-a094-d92119aa29a7', 1, '2021-12-07 09:06:27', '2021-12-07 09:06:27'),
(27, 2, '689c2314-4d73-348d-860e-f5035cfd91fb', 1, '2021-12-07 09:06:27', '2021-12-07 09:06:27'),
(28, 13, '174393a2-3331-3e33-a514-32508e86ed01', 1, '2021-12-07 09:06:28', '2021-12-07 09:06:28'),
(29, 2, '461a5240-8af5-33d6-9a32-624b8946e1e7', 1, '2021-12-07 09:06:28', '2021-12-07 09:06:28'),
(30, 2, '9e7e8ffd-2676-3fed-b82f-7d73e8244d12', 0, '2021-12-07 09:06:28', '2021-12-07 09:06:28'),
(31, 2, '021f5152-6f28-31c8-a460-629f0e3fe14a', 1, '2021-12-07 09:06:29', '2021-12-07 09:06:29'),
(32, 2, '25c9e75e-c92a-3949-a7ee-02cf0eb3d1ee', 1, '2021-12-07 09:06:29', '2021-12-07 09:06:29'),
(33, 15, '82ba025c-1c32-46cb-a18c-ad4c2fc0cab5', 0, '2021-12-07 11:42:11', '2021-12-07 11:42:11'),
(34, 15, 'dd0a7eee-e633-414c-a924-d6a62c1fd9d7', 0, '2021-12-07 11:42:51', '2021-12-07 11:42:51'),
(35, 15, '420f41d3-054b-405c-aab3-62dc47122920', 0, '2021-12-07 12:16:35', '2021-12-07 12:16:35'),
(36, 15, '436496e3-5b8b-40cd-b637-12b229f9c594', 0, '2021-12-07 12:17:44', '2021-12-07 12:17:44'),
(37, 15, '2ca326a4-7914-45d1-878d-d45ba8f199a7', 0, '2021-12-07 12:18:06', '2021-12-07 12:18:06'),
(38, 15, '7ee293ce-db74-49f9-a454-029985765b89', 0, '2021-12-07 12:18:18', '2021-12-07 12:18:18'),
(39, 15, '3e0bfa09-76d3-464e-bec3-37dd3e322a8d', 0, '2021-12-07 12:19:49', '2021-12-07 12:19:49'),
(40, 15, '004ef128-ee7d-4722-9930-daf10adb3b9e', 0, '2021-12-07 12:20:54', '2021-12-07 12:20:54'),
(41, 15, '3690d522-1332-4d4f-a392-3258a3358b90', 0, '2021-12-07 12:21:29', '2021-12-07 12:21:29'),
(42, 15, '59218914-9d50-4f6e-a591-69536db2abaa', 0, '2021-12-07 12:21:53', '2021-12-07 12:21:53'),
(43, 15, '094bfa03-c6cd-4e6d-85e0-8e312d68a73d', 0, '2021-12-07 12:22:54', '2021-12-07 12:22:54'),
(44, 15, '7edb1d19-8b72-4998-9f35-d98f48a71ef3', 0, '2021-12-07 12:28:36', '2021-12-07 12:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ADMIN', '2021-12-07 09:06:02', '2021-12-07 09:06:02'),
(2, 'PROGRAM DEAN', '2021-12-07 09:06:02', '2021-12-07 09:06:02'),
(3, 'SECRETARY', '2021-12-07 09:06:02', '2021-12-07 09:06:02'),
(4, 'INSTRUCTOR', '2021-12-07 09:06:02', '2021-12-07 09:06:02');

-- --------------------------------------------------------

--
-- Table structure for table `syllabi`
--

CREATE TABLE `syllabi` (
  `resource_id` bigint(20) UNSIGNED NOT NULL,
  `course_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_allotment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `professor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `course_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`course_description`)),
  `course_outcomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`course_outcomes`)),
  `learning_outcomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`learning_outcomes`)),
  `learning_plan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`learning_plan`)),
  `student_outputs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`student_outputs`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `syllabi`
--

INSERT INTO `syllabi` (`resource_id`, `course_code`, `course_title`, `credit`, `time_allotment`, `professor`, `course_description`, `course_outcomes`, `learning_outcomes`, `learning_plan`, `student_outputs`, `created_at`, `updated_at`) VALUES
(34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 11:42:51', '2021-12-07 11:42:51'),
(38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:18:18', '2021-12-07 12:18:18'),
(39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:19:50', '2021-12-07 12:19:50'),
(40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:20:54', '2021-12-07 12:20:54'),
(41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:21:30', '2021-12-07 12:21:30'),
(42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:21:53', '2021-12-07 12:21:53'),
(43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:22:54', '2021-12-07 12:22:54'),
(44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-12-07 12:28:36', '2021-12-07 12:28:36');

-- --------------------------------------------------------

--
-- Table structure for table `temporary_uploads`
--

CREATE TABLE `temporary_uploads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `folder_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `temporary_uploads`
--

INSERT INTO `temporary_uploads` (`id`, `folder_name`, `file_name`, `created_at`, `updated_at`) VALUES
(1, '61af26a90a348-1638868649', '3RD-ROUTING-PERFORMANCE-MGT-PRAC-AND-WORK-WELL-ALL-2-7-1631706010-Copy.docx', '2021-12-07 09:17:29', '2021-12-07 09:17:29'),
(41, '61af4f05d8810-1638878981', 'test2.docx', '2021-12-07 12:09:41', '2021-12-07 12:09:41'),
(42, '61af507c1f338-1638879356', 'test2.docx', '2021-12-07 12:15:56', '2021-12-07 12:15:56'),
(43, '61af509470800-1638879380', 'test2.docx', '2021-12-07 12:16:20', '2021-12-07 12:16:20'),
(44, '61af5158cc4c0-1638879576', 'test2.docx', '2021-12-07 12:19:36', '2021-12-07 12:19:36'),
(45, '61af51db3fea8-1638879707', 'test2.docx', '2021-12-07 12:21:47', '2021-12-07 12:21:47'),
(46, '61af51fd809d0-1638879741', 'test.docx', '2021-12-07 12:22:21', '2021-12-07 12:22:21'),
(47, '61af5219e62d0-1638879769', 'test2.docx', '2021-12-07 12:22:49', '2021-12-07 12:22:49'),
(48, '61af532f65450-1638880047', 'test.docx', '2021-12-07 12:27:27', '2021-12-07 12:27:27'),
(49, '61af53542b688-1638880084', 'test.docx', '2021-12-07 12:28:04', '2021-12-07 12:28:04'),
(50, '61af5361692d0-1638880097', 'test2.docx', '2021-12-07 12:28:17', '2021-12-07 12:28:17'),
(51, '61af538c01a90-1638880140', 'test.docx', '2021-12-07 12:29:00', '2021-12-07 12:29:00'),
(52, '61af64fbf1a68-1638884603', 'test2.docx', '2021-12-07 13:43:24', '2021-12-07 13:43:24'),
(53, '61af678ad41c0-1638885258', 'test2.docx', '2021-12-07 13:54:18', '2021-12-07 13:54:18'),
(54, '61af67a3bbb20-1638885283', 'test2.docx', '2021-12-07 13:54:43', '2021-12-07 13:54:43'),
(55, '61af67d3d3220-1638885331', 'test2.docx', '2021-12-07 13:55:31', '2021-12-07 13:55:31'),
(56, '61af67f15e308-1638885361', 'test2.docx', '2021-12-07 13:56:01', '2021-12-07 13:56:01'),
(57, '61af67fc82528-1638885372', 'test2.docx', '2021-12-07 13:56:12', '2021-12-07 13:56:12'),
(58, '61af6819cb908-1638885401', 'test2.docx', '2021-12-07 13:56:41', '2021-12-07 13:56:41'),
(59, '61af6829cc4c0-1638885417', 'test2.docx', '2021-12-07 13:56:57', '2021-12-07 13:56:57'),
(60, '61af684dc0940-1638885453', 'test2.docx', '2021-12-07 13:57:33', '2021-12-07 13:57:33'),
(61, '61af68ce644b0-1638885582', 'test2.docx', '2021-12-07 13:59:42', '2021-12-07 13:59:42'),
(62, '61af68e213f88-1638885602', 'test2.docx', '2021-12-07 14:00:02', '2021-12-07 14:00:02'),
(63, '61af6938ce7e8-1638885688', 'test2.docx', '2021-12-07 14:01:28', '2021-12-07 14:01:28'),
(64, '61af6987e4778-1638885767', 'test2.docx', '2021-12-07 14:02:47', '2021-12-07 14:02:47'),
(65, '61af6aebc3820-1638886123', 'test2.docx', '2021-12-07 14:08:43', '2021-12-07 14:08:43'),
(66, '61af6af7baf68-1638886135', 'test2.docx', '2021-12-07 14:08:55', '2021-12-07 14:08:55'),
(67, '61af6afcae448-1638886140', 'test2.docx', '2021-12-07 14:09:00', '2021-12-07 14:09:00'),
(68, '61af6b1268b00-1638886162', 'test2.docx', '2021-12-07 14:09:22', '2021-12-07 14:09:22'),
(69, '61af6b71affa0-1638886257', 'test2.docx', '2021-12-07 14:10:57', '2021-12-07 14:10:57'),
(70, '61af6b9375620-1638886291', 'test2.docx', '2021-12-07 14:11:31', '2021-12-07 14:11:31'),
(71, '61af6bc2b1710-1638886338', 'test2.docx', '2021-12-07 14:12:18', '2021-12-07 14:12:18'),
(72, '61af6c04012c0-1638886404', 'test2.docx', '2021-12-07 14:13:24', '2021-12-07 14:13:24'),
(73, '61af6c18ca198-1638886424', 'test2.docx', '2021-12-07 14:13:44', '2021-12-07 14:13:44'),
(74, '61af6c2333f40-1638886435', 'test2.docx', '2021-12-07 14:13:55', '2021-12-07 14:13:55'),
(75, '61af6c6660e00-1638886502', 'test2.docx', '2021-12-07 14:15:02', '2021-12-07 14:15:02'),
(76, '61af6cb85f690-1638886584', 'test3.docx', '2021-12-07 14:16:24', '2021-12-07 14:16:24'),
(77, '61af6ccc9f9e8-1638886604', 'test2.docx', '2021-12-07 14:16:44', '2021-12-07 14:16:44'),
(78, '61af6d026f090-1638886658', 'test3.docx', '2021-12-07 14:17:38', '2021-12-07 14:17:38'),
(79, '61af6db8e5b00-1638886840', 'test3.docx', '2021-12-07 14:20:40', '2021-12-07 14:20:40'),
(80, '61af6e02c1110-1638886914', 'test3.docx', '2021-12-07 14:21:54', '2021-12-07 14:21:54'),
(81, '61af6e1fe08f8-1638886943', 'test3.docx', '2021-12-07 14:22:23', '2021-12-07 14:22:23'),
(82, '61af6e57765c0-1638886999', 'test3.docx', '2021-12-07 14:23:19', '2021-12-07 14:23:19'),
(83, '61af6e7685bd8-1638887030', 'test3.docx', '2021-12-07 14:23:50', '2021-12-07 14:23:50'),
(84, '61af6e842f120-1638887044', 'test2.docx', '2021-12-07 14:24:04', '2021-12-07 14:24:04'),
(85, '61af6e8fc72b8-1638887055', 'test.docx', '2021-12-07 14:24:15', '2021-12-07 14:24:15'),
(86, '61af6f46769a8-1638887238', 'test3.docx', '2021-12-07 14:27:18', '2021-12-07 14:27:18'),
(87, '61bb7202ba608-1639674370', 'test3.docx', '2021-12-16 17:06:10', '2021-12-16 17:06:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `password`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 'Joseph', 'Carter', 'jaylan12', '$2y$10$QOWr3yMWDKgyi1Jj7pBBp.0awL6qhg9HBaGUctKKbjCWY1LP76.2C', 2, '2021-12-07 09:06:03', '2021-12-07 09:06:03'),
(2, 'Carmella', 'Eichmann', 'clement.sipes', '$2y$10$zLf4zjVw1bAh8QX2H0tUvuSsvLYdD/9MilJyJ8EzIAzrzfCt3Ar66', 4, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(3, 'Johnson', 'Greenholt', 'macy00', '$2y$10$6xYxdauaQPbAWVlfE.NEpOEsZMTqywTchXOA9TbGxsr4KcG0CWJVy', 2, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(4, 'Novella', 'Macejkovic', 'crona.hilma', '$2y$10$h3u5EGXGODkXLEssi1766OUpM6k9HAs1uxXf7uir3jKDRSfKO/Yxi', 2, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(5, 'Hilton', 'McDermott', 'colton.fahey', '$2y$10$FGndLFwu.tEZbaZVgzyAPOWgpyRNukSTb7GwNXjFy4Zqu.sukzkiq', 3, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(6, 'Ivory', 'Kautzer', 'kathleen.boehm', '$2y$10$OMLRJseMoW/BJjjFGEVDruQcqJIwBOIOpRTCteic7gb2gZkiQIHji', 2, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(7, 'Verona', 'McClure', 'phintz', '$2y$10$v9o0D9rhf0k5zb/nOG0GU.TfVHkrfsJMU0tpgjyLinAvu.PpkKXVy', 3, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(8, 'Krystal', 'Dietrich', 'clint60', '$2y$10$R5C/DpjwtWgmSwdp7C4LI.P1muMgt6DW3p9E.zRWJkuUhS2qoe/3S', 2, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(9, 'Cleta', 'Ledner', 'brekke.rowland', '$2y$10$o9H35gq4WK0DWZm7gkjgjus1I/eO8DP9zUizyZFAVeaerqdjQDc9e', 4, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(10, 'Nayeli', 'Steuber', 'ceichmann', '$2y$10$mKiRcbsgpdMoweUPxmOGt./I7z/XP/7es7WNvMXwqmpD7CLFeiC8q', 3, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(11, 'Ethan', 'Marvin', 'mertz.rosina', '$2y$10$bY1eoQvqgPzpSQY6OXEJfOFjJrjl.mlI1keqR4n8Eh/xoBSZ0vkdK', 3, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(12, 'Golda', 'Walsh', 'pfranecki', '$2y$10$plnE9nnrLNOGZBXWASVoaORVIDiWbcPGCgjTkAKa1h77rjPu7af6q', 2, '2021-12-07 09:06:04', '2021-12-07 09:06:04'),
(13, 'Adolfo', 'Gaylord', 'gerhold.lora', '$2y$10$jilsXUV8tnwHUCXuUHu.he9xsdYJk6OIM5tnl0JlW9SwVcvuBsGHu', 4, '2021-12-07 09:06:05', '2021-12-07 09:06:05'),
(14, 'Crystal', 'Treutel', 'xlangosh', '$2y$10$M0UgTdVwJJXAX0cXhQH/bO.znTAUkA3c8noHm6/VaoCF86q/meE2C', 2, '2021-12-07 09:06:05', '2021-12-07 09:06:05'),
(15, 'Renee', 'McDermott', 'juanita65', '$2y$10$DUAcjif2FNcpJ.Lgvr.vruUFXsGHbD4wh630880eNqWx3to2j72Zm', 1, '2021-12-07 09:06:05', '2021-12-07 09:06:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `comments_user_id_foreign` (`user_id`),
  ADD KEY `comments_resource_id_foreign` (`resource_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `courses_program_id_foreign` (`program_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `program_user`
--
ALTER TABLE `program_user`
  ADD KEY `program_user_program_id_foreign` (`program_id`),
  ADD KEY `program_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resources_course_id_foreign` (`course_id`),
  ADD KEY `resources_user_id_foreign` (`user_id`);

--
-- Indexes for table `resource_downloads`
--
ALTER TABLE `resource_downloads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_downloads_resource_id_foreign` (`resource_id`),
  ADD KEY `resource_downloads_user_id_foreign` (`user_id`);

--
-- Indexes for table `resource_user`
--
ALTER TABLE `resource_user`
  ADD PRIMARY KEY (`resource_id`,`user_id`),
  ADD KEY `resource_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `syllabi`
--
ALTER TABLE `syllabi`
  ADD PRIMARY KEY (`resource_id`);

--
-- Indexes for table `temporary_uploads`
--
ALTER TABLE `temporary_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `programs`
--
ALTER TABLE `programs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `resource_downloads`
--
ALTER TABLE `resource_downloads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `temporary_uploads`
--
ALTER TABLE `temporary_uploads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`),
  ADD CONSTRAINT `comments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`);

--
-- Constraints for table `program_user`
--
ALTER TABLE `program_user`
  ADD CONSTRAINT `program_user_program_id_foreign` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`),
  ADD CONSTRAINT `program_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`),
  ADD CONSTRAINT `resources_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `resource_downloads`
--
ALTER TABLE `resource_downloads`
  ADD CONSTRAINT `resource_downloads_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`),
  ADD CONSTRAINT `resource_downloads_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `resource_user`
--
ALTER TABLE `resource_user`
  ADD CONSTRAINT `resource_user_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`),
  ADD CONSTRAINT `resource_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `syllabi`
--
ALTER TABLE `syllabi`
  ADD CONSTRAINT `syllabi_resource_id_foreign` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
