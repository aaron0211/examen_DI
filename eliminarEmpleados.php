<?php

include ('connect-db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];

    try {
        $stmt = $dbh->prepare('delete from empleados where idEmpleado =:id');
        $stmt->bindParam(':id',$_GET['id']);
        $stmt->execute();
    }catch (PDOException $e){
        echo "ERROR: ".$e->getMessage();
    }
    header("Location: vistaEmpleados.php");
}else{
    header("Location: vistaEmpleados.php");
}
?>