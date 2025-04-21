-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2025 at 09:09 AM
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
  `username` varchar(70) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`username`, `password`) VALUES
('Admin_Amit', 'Amit77');

-- --------------------------------------------------------

--
-- Table structure for table `medications`
--

CREATE TABLE `medications` (
  `medication_id` int(11) NOT NULL,
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

INSERT INTO `medications` (`medication_id`, `name`, `generic_name`, `dosage`, `manufacturer`, `category`, `expiry_date`, `stock_quantity`, `unit_price`) VALUES
(1, 'Paracetamol', 'Acetaminophen', '500mg', 'Cipla', 'Pain Reliever', '2026-12-31', 190, 200),
(2, 'Amoxicillin', 'Amoxicillin Trihydrate', '250mg', 'Sun Pharma', 'Antibiotic', '2025-08-07', 150, 250),
(3, 'Cetirizine', 'Cetirizine Hydrochloride', '10mg', 'Zydus', 'Antihistamine', '2026-08-15', 180, 250),
(4, 'Ibuprofen', 'Ibuprofen', '400mg', 'Dr. Reddy\'s', 'Pain Reliever', '2027-03-20', 220, 250),
(5, 'Azithromycin', 'Azithromycin', '500mg', 'Torrent', 'Antibiotic', '2025-09-10', 165, 250),
(6, 'Pantoprazole', 'Pantoprazole Sodium', '40mg', 'Intas', 'Acid Reducer', '2026-05-30', 190, 230),
(7, 'Dolo 650', 'Paracetamol', '650mg', 'Micro Labs', 'Fever Reducer', '2026-02-28', 250, 150),
(8, 'Ciprofloxacin', 'Ciprofloxacin', '500mg', 'Ranbaxy', 'Antibiotic', '2025-07-31', 130, 300),
(9, 'Loratadine', 'Loratadine', '10mg', 'Lupin', 'Allergy Relief', '2026-10-01', 160, 240),
(10, 'Metformin', 'Metformin Hydrochloride', '500mg', 'Cipla', 'Diabetes', '2027-01-01', 300, 250),
(11, 'Amlodipine', 'Amlodipine Besylate', '5mg', 'Sun Pharma', 'Blood Pressure', '2025-08-31', 210, 270),
(12, 'Atorvastatin', 'Atorvastatin Calcium', '10mg', 'Zydus', 'Cholesterol', '2026-06-15', 180, 220),
(13, 'Ranitidine', 'Ranitidine Hydrochloride', '150mg', 'Dr. Reddy\'s', 'Acidity', '2025-10-20', 120, 215),
(14, 'Losartan', 'Losartan Potassium', '50mg', 'Intas', 'Blood Pressure', '2026-03-30', 130, 330),
(15, 'Montelukast', 'Montelukast Sodium', '10mg', 'Torrent', 'Allergy', '2025-12-01', 140, 220),
(16, 'Clopidogrel', 'Clopidogrel Bisulfate', '75mg', 'Lupin', 'Blood Thinner', '2026-07-10', 150, 230),
(17, 'Levothyroxine', 'Levothyroxine Sodium', '100mcg', 'Alkem', 'Thyroid', '2027-04-05', 160, 230),
(18, 'Domperidone', 'Domperidone Maleate', '10mg', 'Sun Pharma', 'Nausea', '2026-09-12', 180, 260),
(19, 'Omeprazole', 'Omeprazole', '20mg', 'Dr. Reddy\'s', 'Acid Reducer', '2026-11-20', 200, 280),
(20, 'Salbutamol', 'Salbutamol Sulfate', '100mcg', 'Cipla', 'Asthma Inhaler', '2025-06-30', 95, 250);

-- --------------------------------------------------------

--
-- Table structure for table `sales_records`
--

CREATE TABLE `sales_records` (
  `id` int(11) NOT NULL,
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

INSERT INTO `sales_records` (`id`, `medication_id`, `staff_id`, `quantity_sold`, `total_price`, `customer_name`, `date_sold`, `payment_method`) VALUES
(11, 5, 1, 5, 1250.00, 'Amit', '2025-04-21 05:10:57', 'UPI'),
(12, 1, 1, 10, 2000.00, 'Deepak', '2025-04-21 05:17:21', 'UPI');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
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

INSERT INTO `staff` (`staff_id`, `name`, `email`, `phone`, `date_joined`, `total_sales`) VALUES
(1, 'ram', 'ram108@gmail.com', '1234567890', '2025-04-19 05:58:24', 3250);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `password` (`password`) USING HASH;

--
-- Indexes for table `medications`
--
ALTER TABLE `medications`
  ADD PRIMARY KEY (`medication_id`);

--
-- Indexes for table `sales_records`
--
ALTER TABLE `sales_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medication_id` (`medication_id`),
  ADD KEY `staff_id_ibfk` (`staff_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `medications`
--
ALTER TABLE `medications`
  MODIFY `medication_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sales_records`
--
ALTER TABLE `sales_records`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sales_records`
--
ALTER TABLE `sales_records`
  ADD CONSTRAINT `sales_records_ibfk_1` FOREIGN KEY (`medication_id`) REFERENCES `medications` (`medication_id`),
  ADD CONSTRAINT `staff_id_ibfk` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
