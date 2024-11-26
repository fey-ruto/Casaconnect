-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2024 at 8:00 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Create the database
CREATE DATABASE IF NOT EXISTS `casaconnect`;
USE `casaconnect`;

-- Administrators table
CREATE TABLE `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `fname` VARCHAR(100) NOT NULL,
    `lname` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `user_role` TINYINT NOT NULL DEFAULT 1 -- Default to administrator
);

-- Users table
CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `fname` VARCHAR(100) NOT NULL,
    `lname` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `user_role` TINYINT NOT NULL DEFAULT 2 -- Default to regular user
);

-- Listings Table
CREATE TABLE `listings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `property_name` VARCHAR(200) NOT NULL,
    `location` VARCHAR(255) NOT NULL,
    `description` TEXT NOT NULL,
    `price` DECIMAL(15, 2) NOT NULL,
    `images` TEXT -- Comma-separated paths for up to 10 images
);

-- Consultation Slots Table
CREATE TABLE `consultation_slots` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,       -- Unique identifier for each slot
    `date` DATE NOT NULL,                      -- Date of the consultation slot
    `time` TIME NOT NULL,                      -- Time of the consultation slot
    `status` ENUM('available', 'booked') DEFAULT 'available', -- Slot status
    `user_id` INT DEFAULT NULL,                -- ID of the user who booked the slot (NULL if available)
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Slot creation timestamp
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL -- Links to the user who booked the slot
);

-- Property Valuation Slots Table
CREATE TABLE `property_valuation_slots` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,       -- Unique identifier for each slot
    `date` DATE NOT NULL,                      -- Date of the valuation slot
    `time` TIME NOT NULL,                      -- Time of the valuation slot
    `status` ENUM('available', 'booked') DEFAULT 'available', -- Slot status
    `user_id` INT DEFAULT NULL,                -- ID of the user who booked the slot (NULL if available)
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Slot creation timestamp
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL -- Links to the user who booked the slot
);

ALTER TABLE `listings` 
ADD COLUMN `status` ENUM('pending', 'approved', 'rejected') DEFAULT 'pending';

INSERT INTO consultation_slots(date, time, status, user_id) VALUES 
('2024-11-30', '10:00:00', 'available', NULL);
('2024-11-26', '09:00:00', 'available', NULL),
('2024-11-26', '10:00:00', 'available', NULL),
('2024-11-26', '11:00:00', 'available', NULL),
('2024-11-26', '12:00:00', 'available', NULL),
('2024-11-26', '13:00:00', 'available', NULL),
('2024-11-26', '14:00:00', 'available', NULL),
('2024-11-26', '15:00:00', 'available', NULL),
('2024-11-26', '16:00:00', 'available', NULL),
('2024-11-27', '09:00:00', 'available', NULL),
('2024-11-27', '10:00:00', 'available', NULL),
('2024-11-27', '11:00:00', 'available', NULL),
('2024-11-27', '12:00:00', 'available', NULL),
('2024-11-27', '14:00:00', 'available', NULL),
('2024-11-27', '15:00:00', 'available', NULL),
('2024-11-27', '16:00:00', 'available', NULL),
('2024-11-28', '09:00:00', 'available', NULL),
('2024-11-28', '10:00:00', 'available', NULL),
('2024-11-28', '11:00:00', 'available', NULL),
('2024-11-28', '12:00:00', 'available', NULL),
('2024-11-28', '13:00:00', 'available', NULL),
('2024-11-28', '14:00:00', 'available', NULL),
('2024-11-28', '15:00:00', 'available', NULL),
('2024-11-28', '16:00:00', 'available', NULL);


INSERT INTO property_valuation_slots(date, time, status, user_id) VALUES 
('2024-11-26', '09:00:00', 'available', NULL),
('2024-11-26', '10:00:00', 'available', NULL),
('2024-11-26', '11:00:00', 'available', NULL),
('2024-11-26', '12:00:00', 'available', NULL),
('2024-11-26', '13:00:00', 'available', NULL),
('2024-11-27', '09:00:00', 'available', NULL),
('2024-11-27', '10:00:00', 'available', NULL),
('2024-11-27', '11:00:00', 'available', NULL),
('2024-11-27', '12:00:00', 'available', NULL),
('2024-11-27', '13:00:00', 'available', NULL),
('2024-11-28', '09:00:00', 'available', NULL),
('2024-11-28', '10:00:00', 'available', NULL),
('2024-11-28', '11:00:00', 'available', NULL),
('2024-11-28', '12:00:00', 'available', NULL),
('2024-11-28', '13:00:00', 'available', NULL),
('2024-11-29', '09:00:00', 'available', NULL),
('2024-11-29', '10:00:00', 'available', NULL),
('2024-11-29', '11:00:00', 'available', NULL),
('2024-11-29', '12:00:00', 'available', NULL),
('2024-11-29', '13:00:00', 'available', NULL),
('2024-11-30', '09:00:00', 'available', NULL),
('2024-11-30', '10:00:00', 'available', NULL),
('2024-11-30', '11:00:00', 'available', NULL),
('2024-11-30', '12:00:00', 'available', NULL),
('2024-11-30', '13:00:00', 'available', NULL),
('2024-12-01', '09:00:00', 'available', NULL),
('2024-12-01', '10:00:00', 'available', NULL),
('2024-12-01', '11:00:00', 'available', NULL),
('2024-12-01', '12:00:00', 'available', NULL),
('2024-12-01', '13:00:00', 'available', NULL),
('2024-12-02', '09:00:00', 'available', NULL),
('2024-12-02', '10:00:00', 'available', NULL),
('2024-12-02', '11:00:00', 'available', NULL),
('2024-12-02', '12:00:00', 'available', NULL),
('2024-12-02', '13:00:00', 'available', NULL),
('2024-12-03', '09:00:00', 'available', NULL),
('2024-12-03', '10:00:00', 'available', NULL),
('2024-12-03', '11:00:00', 'available', NULL),
('2024-12-03', '12:00:00', 'available', NULL),
('2024-12-03', '13:00:00', 'available', NULL),
('2024-12-04', '09:00:00', 'available', NULL),
('2024-12-04', '10:00:00', 'available', NULL),
('2024-12-04', '11:00:00', 'available', NULL),
('2024-12-04', '12:00:00', 'available', NULL),
('2024-12-04', '13:00:00', 'available', NULL),
('2024-12-05', '09:00:00', 'available', NULL),
('2024-12-05', '10:00:00', 'available', NULL),
('2024-12-05', '11:00:00', 'available', NULL),
('2024-12-05', '12:00:00', 'available', NULL),
('2024-12-05', '13:00:00', 'available', NULL),
('2024-12-06', '09:00:00', 'available', NULL),
('2024-12-06', '10:00:00', 'available', NULL),
('2024-12-06', '11:00:00', 'available', NULL),
('2024-12-06', '12:00:00', 'available', NULL),
('2024-12-06', '13:00:00', 'available', NULL),
('2024-12-07', '09:00:00', 'available', NULL),
('2024-12-07', '10:00:00', 'available', NULL),
('2024-12-07', '11:00:00', 'available', NULL),
('2024-12-07', '12:00:00', 'available', NULL),
('2024-12-07', '13:00:00', 'available', NULL);

CREATE TABLE IF NOT EXISTS `booked_consultations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `slot_id` INT NOT NULL,
    `booking_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`slot_id`) REFERENCES `consultation_slots`(`id`) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS `booked_property_valuations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT NOT NULL,
    `slot_id` INT NOT NULL,
    `booking_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`slot_id`) REFERENCES `property_valuation_slots`(`id`) ON DELETE CASCADE
);
