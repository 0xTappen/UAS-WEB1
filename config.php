<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'uasweb1';

$koneksi = mysqli_connect($host, $user, $password);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_query($koneksi, "CREATE DATABASE IF NOT EXISTS {$database}");
mysqli_select_db($koneksi, $database);

mysqli_query($koneksi, "
    CREATE TABLE IF NOT EXISTS mahasiswa (
        id INT AUTO_INCREMENT PRIMARY KEY,
        npm VARCHAR(30) NOT NULL UNIQUE,
        nama VARCHAR(100) NOT NULL,
        password VARCHAR(100) NOT NULL DEFAULT '123456',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$cekPassword = mysqli_query($koneksi, "SHOW COLUMNS FROM mahasiswa LIKE 'password'");
if (mysqli_num_rows($cekPassword) === 0) {
    mysqli_query($koneksi, "
        ALTER TABLE mahasiswa
        ADD COLUMN password VARCHAR(100) NOT NULL DEFAULT '123456'
    ");
}

mysqli_query($koneksi, "
    INSERT INTO mahasiswa (npm, nama, password)
    VALUES ('24312092', 'Erwin Wijaya', 'Tekno123@')
    ON DUPLICATE KEY UPDATE nama = VALUES(nama), password = VALUES(password)
");
