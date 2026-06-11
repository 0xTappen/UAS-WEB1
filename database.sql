CREATE DATABASE IF NOT EXISTS uasweb1;
USE uasweb1;

CREATE TABLE IF NOT EXISTS mahasiswa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    npm VARCHAR(30) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO mahasiswa (npm, nama, password) VALUES
('24312093', 'Mahasiswa Teknokrat', 'Tekno123@')
ON DUPLICATE KEY UPDATE nama = VALUES(nama), password = VALUES(password);
