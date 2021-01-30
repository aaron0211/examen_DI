<?php

function renderForm($nombre,$usuario,$pass,$error){
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
            <strong>Usuario: *</strong><input type="text" name="usuario" value="<?php echo $usuario; ?>"/><br/>
            <strong>Password: *</strong><input type="password" name="pass" value="<?php echo $pass; ?>"/><br/>
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
    $usuario = htmlspecialchars($_POST['usuario']);
    $pass = password_hash(htmlspecialchars($_POST['pass']),PASSWORD_DEFAULT);

    if ($nombre == ''  || $usuario=='' || $pass==''){
        $error = 'Error: Por favor, introduce todos los campos requeridos.';
        renderForm($nombre,$usuario,$pass,$error);
    }else{
        try {
            $stmt = $dbh->prepare("insert into empleados (NombreCompleto,usuario,password) values (:nombre,:usuario,:password)");
            $stmt->bindParam(':nombre',$_POST['nombre']);
            $stmt->bindParam(':usuario',$_POST['usuario']);
            $stmt->bindParam(':password',$pass);
            $stmt->execute();
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
        header("Location: vistaEmpleados.php");
    }
}else{
    renderForm('','','','');
}
?>