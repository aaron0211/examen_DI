<?php

function renderForm($nombre,$apellidos,$cod,$error){
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
            <strong>Apellidos: *</strong><input type="text" name="apellidos" value="<?php echo $apellidos; ?>"/><br/>
            <strong>Código Postal: *</strong><input type="text" name="cod" value="<?php echo $cod; ?>"/><br/>
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
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $cod = htmlspecialchars($_POST['cod']);

    if ($nombre == ''  || $apellidos==''){
        $error = 'Error: Por favor, introduce todos los campos requeridos.';
        renderForm($nombre,$apellidos,$cod,$error);
    }else{
        try {
            $stmt = $dbh->prepare("insert into clientes (nombre,apellidos,codPostal) values (:nombre,:apellidos,:cod)");
            $stmt->bindParam(':nombre',$_POST['nombre']);
            $stmt->bindParam(':apellidos',$_POST['apellidos']);
            $stmt->bindParam(':cod',$_POST['cod']);
            $stmt->execute();
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
        header("Location: vistaClientes.php");
    }
}else{
    renderForm('','','','');
}
?>