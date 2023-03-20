<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include "includes/db.php";
    $first = true;
    $id = 0;

       
    foreach ($_POST as $column => $value){

        if($first){
            $stmt = $conn->prepare("INSERT INTO clinical_histories ($column) VALUES (:To_insert)");
            $stmt->bindParam(':To_insert', $value);
            $stmt->execute();
            $first = false;
            $id = $conn->lastInsertId();
            continue;
        }
        
        try{
            $stmt = $conn->prepare("UPDATE clinical_histories SET $column = :To_insert WHERE id = :id");
            $stmt->bindParam(":To_insert", $value);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        }catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
            echo "You need to declare an id with AUTO INCREMENT in your table!!!\n";
        }
    }
    
}    

header('Location: home.php');

