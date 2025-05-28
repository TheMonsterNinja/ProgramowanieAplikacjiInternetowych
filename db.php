<?php
// Struktura bazy danych:
/*
CREATE DATABASE bank_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE bank_app;

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(255) NOT NULL,
    operation_type ENUM('deposit', 'withdraw') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    balance_after DECIMAL(10, 2) NOT NULL,
    operation_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
*/

$host = 'localhost';
$user = 'root';
$password = '';
$database = 'bank_app';

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}
