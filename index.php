<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include "includes/db.php";
    $username_Provided = $_POST["username"];
    $password_Provided = $_POST["password"];
    
    $stmt = $conn->prepare("SELECT username,password from administrators WHERE username = :username");
    
    $stmt->bindParam(':username',$username_Provided);
    $stmt->execute();

    $data = $stmt->fetch();
    $password = $data['password'];

    if(!password_verify($password_Provided, $password)){
        $error_text = "invalid credentials";
    }else{
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username_Provided;
        header('Location: home.php');
        exit;
    }
    
}

$title = "Login";
$banner = "Access prohibited without authorization";
include "includes/header.php";

?>
<div id="index-main-container" class="default-flex">
<div id="separator-top"></div>
    <form action="" method="post"id="login-form">
    <div id="login-header" class="default-flex">INICIAR SESIÓN</div>
        <div id="form-object-1" class="default-flex"> 
            <label for="username">Username :</label>
            <input type="text" name="username" style="color: black">
        </div>  
        <div id="form-object-2" class="default-flex"> 
            <label for="username">Password :</label>
            <input type="password" name="password" style="color: black">
        </div>
        <div id="form-object-3" class="default-flex"> 
            <input type="submit" value="login" id="login-buttom" style="color: black">
        </div>  
        <div id="form-object-4" class="default-flex"><?php echo $error_text ?></div>
    </form>

    <div id="separator-bottom"></div>
</div>


</body>
</html>