-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 06:10 PM
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
-- Database: `pharma`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(70) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `username`, `password`) VALUES
(1, 'Admin_Amit', 'Amit77'),
(2, 'Deepak', '7777');

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

CREATE TABLE `medications` (
  `medication_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `generic_name` text NOT NULL,
  `dosage` text NOT NULL,
  `manufacturer` text NOT NULL,
  `category` text NOT NULL,
  `expiry_date` date NOT NULL,
  `stock_quantity` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medications`
--

INSERT INTO `medications` (`medication_id`, `admin_id`, `name`, `generic_name`, `dosage`, `manufacturer`, `category`, `expiry_date`, `stock_quantity`, `unit_price`) VALUES
(27, 1, 'Paracetamol 500mg', 'Paracetamol', '500mg', 'Cipla', 'Tablet', '2025-07-15', 110, 3),
(28, 1, 'Amoxicillin 250mg', 'Amoxicillin', '250mg', 'Sun Pharma', 'Capsule', '2025-05-10', 80, 3),
(29, 1, 'Cetirizine', 'Cetirizine Hydrochloride', '10mg', 'Dr. Reddy\'s', 'Tablet', '2025-06-01', 150, 1),
(30, 1, 'Ibuprofen 200mg', 'Ibuprofen', '200mg', 'GSK', 'Tablet', '2025-12-31', 60, 2),
(31, 1, 'Dolo 650', 'Paracetamol', '650mg', 'Micro Labs', 'Tablet', '2026-01-20', 100, 2),
(32, 1, 'Azithromycin 500mg', 'Azithromycin', '500mg', 'Abbott', 'Tablet', '2025-09-10', 50, 7),
(33, 1, 'Metformin', 'Metformin Hydrochloride', '500mg', 'Zydus', 'Tablet', '2026-03-15', 200, 1),
(34, 1, 'Pantoprazole', 'Pantoprazole Sodium', '40mg', 'Intas', 'Tablet', '2025-08-30', 90, 2),
(35, 1, 'Salbutamol Inhaler', 'Salbutamol', '100mcg/dose', 'Cipla', 'Inhaler', '2025-11-01', 30, 120),
(36, 1, 'ORS Sachet', 'Oral Rehydration Salts', '21g', 'Nestle Health', 'Powder', '2026-04-10', 300, 5),
(37, 2, 'Panadol', 'Paracetamol', '500mg', 'GlaxoSmithKline', 'Pain Reliever', '2025-08-15', 50, 1),
(38, 2, 'Augmentin', 'Amoxicillin + Clavulanic Acid', '625mg', 'GSK', 'Antibiotic', '2024-11-01', 10, 4),
(39, 2, 'Zyrtec', 'Cetirizine', '10mg', 'UCB Pharma', 'Antihistamine', '2026-04-10', 8, 1),
(40, 2, 'Lipitor', 'Atorvastatin', '20mg', 'Pfizer', 'Cholesterol', '2026-01-30', 90, 2),
(41, 2, 'Ventolin Inhaler', 'Salbutamol', '100mcg', 'GlaxoSmithKline', 'Asthma', '2025-12-01', 25, 6),
(42, 2, 'Metformin', 'Metformin Hydrochloride', '500mg', 'Sun Pharma', 'Diabetes', '2026-03-20', 80, 1),
(43, 2, 'Dolo 650', 'Paracetamol', '650mg', 'Micro Labs', 'Pain Reliever', '2025-09-12', 120, 1),
(44, 2, 'Ciplox', 'Ciprofloxacin', '500mg', 'Cipla', 'Antibiotic', '2024-10-05', 30, 2),
(45, 2, 'Allegra', 'Fexofenadine', '180mg', 'Sanofi', 'Antihistamine', '2025-07-14', 15, 2),
(46, 2, 'Amlodipine', 'Amlodipine Besylate', '5mg', 'Torrent Pharma', 'Blood Pressure', '2026-05-01', 90, 1),
(47, 2, 'Diclofenac', 'Diclofenac Sodium', '50 mg', 'Sun Pharma', 'Anti-Inflammatory', '2025-12-25', 120, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sales_records`
--

CREATE TABLE `sales_records` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `medication_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `quantity_sold` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `date_sold` timestamp NOT NULL DEFAULT current_timestamp(),
  `payment_method` enum('Cash','Card','UPI') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales_records`
--

INSERT INTO `sales_records` (`id`, `admin_id`, `medication_id`, `staff_id`, `quantity_sold`, `total_price`, `customer_name`, `date_sold`, `payment_method`) VALUES
(19, 1, 27, 2, 10, 20.00, 'Janvi', '2025-04-21 11:18:50', 'Cash'),
(20, 2, 44, 1, 10, 20.00, 'Amit', '2025-04-21 12:59:25', 'Cash');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `admin_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `date_joined` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_sales` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`admin_id`, `staff_id`, `name`, `email`, `phone`, `date_joined`, `total_sales`) VALUES
(2, 1, 'Ram', 'ram@gmail.com', '12345678', '2025-04-21 12:06:32', 20),
(1, 2, 'Chaman', 'chaman@gmail.com', '123474234', '2025-04-21 11:18:13', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`) USING HASH;

--
-- Indexes for table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`medication_id`),
  ADD KEY `a_id` (`admin_id`);

--
-- Indexes for table `sales_records`
--
ALTER TABLE `sales_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medication_id` (`medication_id`),
  ADD KEY `staff_id_ibfk` (`staff_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `admins_id` (`admin_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `medication_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `sales_records`
--
ALTER TABLE `sales_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `medications`
--
ALTER TABLE `medications`
  ADD CONSTRAINT `a_id` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_records`
--
ALTER TABLE `sales_records`
  ADD CONSTRAINT `admin_id` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_records_ibfk_1` FOREIGN KEY (`medication_id`) REFERENCES `medications` (`medication_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `staff_id_ibfk` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `admins_id` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`admin_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
