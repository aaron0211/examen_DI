<?php

include ('connect-db.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])){
    $id = $_GET['id'];

    try {
        $stmt = $dbh->prepare('delete from clientes where idCliente =:id');
        $stmt->bindParam(':id',$_GET['id']);
        $stmt->execute();
    }catch (PDOException $e){
        echo "ERROR: ".$e->getMessage();
    }
    header("Location: vistaClientes.php");
}else{
    header("Location: vistaClientes.php");
}
?>