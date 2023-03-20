<?php
session_start();
$username = $_SESSION["username"];
$logged_in = $_SESSION["logged_in"];

if($logged_in != true){
    header('Location: index.php');    
    die();
}

if($_SERVER['REQUEST_METHOD'] == "POST"){
    include "includes/db.php";
    
    $add_username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
    $stmt = $conn->prepare("INSERT INTO administrators (username,password) VALUES (:username,:password)");
    $stmt->bindParam(":username", $add_username);
    $stmt->bindParam(":password", $hashed_password);
    $stmt->execute();

    header('Location: home.php');
    die();
}
$banner="Hola $username desde aqui puedes añadir un nuevo administrador";
include "includes/header.php";

?>
<div id="index-main-container" class="default-flex">
<div id="separator-top"></div>
    <form action="" method="post" id="login-form">
    <div id="login-header" class="default-flex">AÑADIR ADMINISTRADOR</div>
        <div id="form-object-1" class="default-flex"> 
            <label for="username">Username :</label>
            <input type="text" name="username" required>
        </div>  
        <div id="form-object-2" class="default-flex"> 
            <label for="username">Password :</label>
            <input type="text" name="password" required>
        </div>
        <div id="form-object-3" class="default-flex"> 
            <input type="submit" value="add user" id="login-buttom">
        </div>  
        <div id="form-object-4" class="default-flex"><a class="link default-flex" href="home.php">volver a home</a></div>
    </form>

    <div id="separator-bottom"></div>
</div>
