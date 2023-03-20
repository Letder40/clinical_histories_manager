<?php
$host = '127.0.0.1';
$dbname = 'clinical_history';
$dbusername = 'letder';
$dbpassword = '!_letder_$';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
