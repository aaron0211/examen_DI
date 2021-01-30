<?php
function renderForm($usuario,$pass,$error){
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
require_once ('Sesion.php');

if (isset($_POST['submit'])){
    $usuario = htmlspecialchars($_POST['usuario']);
    $pass = htmlspecialchars($_POST['pass']);

    if ($usuario == ''  || $pass==''){
        $error = 'Error: Por favor, introduce todos los campos requeridos.';
    }else{
        try {
            $result = $dbh->query("select * from empleados");
            $empleados = array();
            while ($empleado = $result->fetch())
                if (($empleado['usuario'] == $usuario && $empleado['password'] == $pass) ||($empleado['usuario'] == $usuario && password_verify($pass,$empleado['password']))){
                    $nombre = $empleado['NombreCompleto'];
                    $sesion = new Sesion();
                    $sesion->set('usuario',$usuario);
                    $sesion->set('nombre',$nombre);
                }
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
        header("Location: index.php");
    }
}else{
    renderForm('','','');
}
?>