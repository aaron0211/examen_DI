<?php

function renderForm($descripcion,$error){
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
        <title>Nuevo Registro</title>
    </head>
    <body>
    <?php
    if ($error != ''){
        echo '<div style="padding 4px; border:1px solid red; color:#ff0000;">'.$error.'</div>';
    }
    ?>
    <form action="" method="post">
        <div>
            <strong>Descripción: *</strong><input type="text" name="desc" value="<?php echo $descripcion; ?>"/><br/>
            <p>* Requerido</p>
            <input type="submit" name="submit" value="Submit">
        </div>
    </form>
    </body>
    </html>
    <?php
}

include ('connect-db.php');

if (isset($_POST['submit'])){
    $descripcion = htmlspecialchars($_POST['desc']);

    if ($descripcion == ''){
        $error = 'Error: Por favor, introduce todos los campos requeridos.';
        renderForm($descripcion,$error);
    }else{
        try {
            $stmt = $dbh->prepare("insert into categorias (descripcion) values (:desc)");
            $stmt->bindParam(':desc',$_POST['desc']);
            $stmt->execute();
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
        header("Location: vistaCategorias.php");
    }
}else{
    renderForm('','');
}
?>