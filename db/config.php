<?php

$DB_HOST = 'localhost';   
$DB_NAME = 'nutri_db';      
$DB_USER = 'root';        
$DB_PASS = '';           
$DB_CHARSET = 'utf8mb4';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_CHARSET";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, $options);
} catch (PDOException $e) {
    exit('Database connection failed: ' . $e->getMessage());
}


//FTP Username : if0_40031431 
//FTP Password : NutriLab2025X  
//FTP Hostname : ftpupload.net
//FTP Port (optional) : 21
