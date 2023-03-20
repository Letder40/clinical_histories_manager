<?php 
session_start();
if($_SESSION['logged_in'] != true){
    header('Location: index.php');
}

$title = "Encuestas Database Manager";
$rand_text = ["espero que pases un gran dia" , "disfruta de tu estancia", "las bases de datos no son tan dificiles como suenan", "¿Que tal tu dia?", "nada mejor que una encuesta para obtener datos", "recuerda comentar si encuentras algun error en la página"];
$banner = "Bienvenid@ " . $_SESSION['username'] . " " . $rand_text[random_int(0,5)];
$id = $_GET["id"];
include "includes/header.php";
include "includes/db.php";

try {
    $stmt = $conn->prepare("SELECT history_text FROM clinical_histories WHERE id=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}catch (PDOException $e) {
    die("DB ERROR!  =>  " . $e->getMessage());
}

$columns = $stmt->fetchAll();

$text = $columns[0]["history_text"];

echo $text; 