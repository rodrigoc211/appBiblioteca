<?php
// 1. Build the DSN from the Aiven connection URI.
$uri = "mysql://avnadmin:AVNS_-vZr6yahtjBMy9jl3Fy@mybibliovirtual-bibliotecavirtual.c.aivencloud.com:12055/defaultdb?ssl-mode=REQUIRED";
$fields = parse_url($uri);

// Construct the PDO DSN string (with SSL).
$dsn = "mysql:host={$fields['host']};port={$fields['port']};dbname=defaultdb;charset=utf8mb4";

// Make sure you have ca.pem in the same folder; adjust path if needed.
$options = [
    PDO::MYSQL_ATTR_SSL_CA => __DIR__ . "/ca.pem",
    PDO::ATTR_ERRMODE      => PDO::ERRMODE_EXCEPTION // throw exceptions on error
];
