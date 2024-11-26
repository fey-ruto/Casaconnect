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
CREATE TABLE `admin` (
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



