<?php 
session_start();
if($_SESSION['logged_in'] != true){
    header('Location: index.php');
}

include "includes/db.php";

$id = $_GET["id"];

if($_SERVER["REQUEST_METHOD"] == "POST" ){
    $id = $_POST["id"];
    $post_text = $_POST["text"];
    #var_dump($_POST);
    try {
        $stmt = $conn->prepare("UPDATE clinical_histories SET history_text = :post_text WHERE id = :id");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":post_text", $post_text);
        $stmt->execute();
    }catch (PDOException $e) {
        die("DB ERROR!  =>  " . $e->getMessage());
    }
}

$title = "Encuestas Database Manager";
$rand_text = ["espero que pases un gran dia" , "disfruta de tu estancia", "las bases de datos no son tan dificiles como suenan", "¿Que tal tu dia?", "nada mejor que una encuesta para obtener datos", "recuerda comentar si encuentras algun error en la página"];
$banner = "Bienvenid@ " . $_SESSION['username'] . " " . $rand_text[random_int(0,5)];
include "includes/header.php";

try {
    $stmt = $conn->prepare("SELECT history_text FROM clinical_histories WHERE id=:id");
    $stmt->bindParam(":id", $id);
    $stmt->execute();
}catch (PDOException $e) {
    die("DB ERROR!  =>  " . $e->getMessage());
}

$columns = $stmt->fetchAll();
$text = $columns[0]["history_text"];

?>
    <div id="text-main-container">
        <form action="" method="post" id="history_form">
            <textarea id="text-zone" form="history_form" name="text"><?php echo $text ?></textarea>
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <div id="button-zone">
                <input type="button" value="go home" id="goHome" class="history-button" onclick="location.href = 'home.php'">
                <input type="submit" value="update" class="history-button">
            </div>
        </form>
    </div>


    <footer id="home-footer" class="default-flex">Database manager created by &nbsp<a href='https://www.linkedin.com/in/adri%C3%A1n-rojas-61b633226/'> letder40</a></footer>

    </body>
</html>