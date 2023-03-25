<?php 
session_start();
if($_SESSION['logged_in'] != true){
    header('Location: index.php');
}

$title = "Encuestas Database Manager";
$rand_text = ["espero que pases un gran dia" , "disfruta de tu estancia", "las bases de datos no son tan dificiles como suenan", "¿Que tal tu dia?", "nada mejor que una encuesta para obtener datos", "recuerda comentar si encuentras algun error en la página"];
$banner = "Bienvenid@ " . $_SESSION['username'] . " " . $rand_text[random_int(0,5)];
include "includes/header.php";
include "includes/db.php";

    
$stmt = $conn->prepare("SELECT cliente FROM clinical_histories");
$stmt->execute();
$clients = $stmt->fetchAll();
$id = $_GET['id'];
$client = $_GET['client'];

?>  
    <div id="home-main-container">

        <nav id="home-nav">

            <a id="nav-object" class="default-flex" href="home.php" >Home</a>
            <a id="nav-object" class="default-flex" href="home.php?id=2" >Add client</a>
            <a id="nav-object" class="default-flex" href="add_user.php">Add administrator</a>
            
        </nav>

        <div id="dinamyc-zone" class="default-flex">
        
            <?php if(empty($id)){ 
            
            echo '<div id="table_selector">';

            for($i=0;$i<count($clients);$i++){
                $client_name = $clients[$i][0];
                
                echo "<a class='default-flex hover' style='color: white' href='home.php?client=" . $client_name  . "&id=1'>" . $client_name . "</a>";
            }
            echo '</div>';
        
        }

        if($id == 1){           
        
        $stmt = $conn->prepare("select column_name from information_schema.columns where table_name = 'clinical_histories' and table_schema = 'clinical_history'");
        $stmt->execute();
        $columns = $stmt->fetchAll();

        $stmt = $conn->prepare("select * from clinical_histories where cliente = :client_name");
        $stmt->bindParam(":client_name", $client);
        $stmt->execute();
        $data = $stmt->fetchAll();

        
        $columns_name = [];

        for($i=0;$i<count($columns);$i++){
            $column_name = $columns[$i][0];
            
            array_push($columns_name, $column_name);
        }

        for($i=0;$i<count($columns_name);$i++){

            if ($columns_name[$i] == "history_text"){
                continue;
            }

            if ($columns_name[$i] == "id"){
                $id = $data[0][$columns_name[$i]];
                continue;
            }

            echo '<div class="show-block">
                    <h1 class="question" style="text-decoration: underline">' . $columns_name[$i] . " :" . '</h1>
                </div>
                <div class="show-block">
                    <div class="answer">' . $data[0][$columns_name[$i]] . '</div>
                </div>
                <div style="height:8px"></div>';

        }
        
        echo "<div style='height:50px'></div>";
        ?>
        <div id="clinical" onclick="location.href='history.php?id=<?php echo $id ?>'"> CLINICAL HISTORY </div>
        <?php
    
    echo "</div>";
    }elseif($id == 2){

        echo '<form action="add.php" method="post" id="add_data" class="default-flex">';
        $stmt = $conn->prepare("select column_name from information_schema.columns where table_name = 'clinical_histories' and table_schema = 'clinical_history'");
        $stmt->execute();
        $columns = $stmt->fetchAll();

        for($i=0;$i<count($columns);$i++){
            $column_name = $columns[$i][0];
            if($column_name == "id"){
                continue;
            }

            if ($column_name == "history_text"){
                continue;
            }

            echo "<div class='add-form-object default-flex'>";
            echo "<label for='$column_name' style='width: 100px'>$column_name</label>";
            echo "<input type='text' style='color: black' name='$column_name' required >";
            echo "</div>";
        }
        echo '<input type="submit" value="add data" id="submit" style="color: black" >';

    echo '</form>';

    }elseif($id == 3){
        echo '<div id="show_data" class="default-flex">';
        echo "</div>";
    }
    
?>
            
            
        </div>





    </div>

    <footer id="home-footer" class="default-flex">Database manager created by &nbsp<a href='https://www.linkedin.com/in/adri%C3%A1n-rojas-61b633226/'> letder40</a></footer>

    </body>
</html>
