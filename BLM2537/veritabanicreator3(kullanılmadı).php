<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'paketler';

try {
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Veritabanı oluştur
    $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Veritabanı oluşturuldu veya zaten mevcut.<br>";

    $conn->exec("USE $dbname");

    // Tablo oluştur
    $sqlCreateTable = "
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        paketler VARCHAR(100) NOT NULL,
        kayit_tarihi TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($sqlCreateTable);
    echo "Tablo oluşturuldu veya zaten mevcut.<br>";
} catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
}
?>
