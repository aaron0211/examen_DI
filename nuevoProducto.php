<?php

function renderForm($nombre,$precio,$cat,$error){
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
            <strong>Nombre: *</strong><input type="text" name="nombre" value="<?php echo $nombre; ?>"/><br/>
            <strong>Precio: *</strong><input type="text" name="precio" value="<?php echo $precio; ?>"/><br/>
            <strong>Categoría: *</strong><input type="text" name="cat" value="<?php echo $cat; ?>"/><br/>
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
    $nombre = htmlspecialchars($_POST['nombre']);
    $precio = htmlspecialchars($_POST['precio']);
    $cat = htmlspecialchars($_POST['cat']);

    if ($nombre == ''  || $precio==''){
        $error = 'Error: Por favor, introduce todos los campos requeridos.';
        renderForm($nombre,$precio,$cat,$error);
    }else{
        try {
            $stmt = $dbh->prepare("insert into productos (nombre,precio,idCategoria) values (:nombre,:precio,:cat)");
            $stmt->bindParam(':nombre',$_POST['nombre']);
            $stmt->bindParam(':precio',$_POST['precio']);
            $stmt->bindParam(':cat',$_POST['cat']);
            $stmt->execute();
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
        header("Location: vistaProductos.php");
    }
}else{
    renderForm('','','','');
}
?>