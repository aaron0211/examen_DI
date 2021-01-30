<?php

function renderForm($id,$nombre,$usuario,$pass,$error){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
        <title>Listado de Resgistros</title>
    </head>
    <body>
    <?php
    if ($error !=''){
        echo '<div style="padding:4px; border:1px solid red; color:red;">'.$error.'</div>';
    }
    ?>
    <form action="" method="post">
        <input type="hidden" name="idEmpleado" value="<?php echo $id; ?>"/>
        <div>
            <p><strong>ID:</strong><?php echo $id; ?></p>
            <strong>Nombre: *</strong><input type="text" name="nombre" value="<?php echo $nombre; ?>">
            <strong>Usuario: *</strong><input type="text" name="usuario" value="<?php echo $usuario; ?>">
            <strong>Password: *</strong><input type="password" name="password" value="<?php echo $pass; ?>">
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
    if (is_numeric($_POST['idEmpleado'])){
        $id = $_POST['idEmpleado'];
        $nombre = htmlspecialchars($_POST['nombre']);
        $usuario = htmlspecialchars($_POST['usuario']);
        $password = password_hash(htmlspecialchars($_POST['password']),PASSWORD_DEFAULT);

        try {
            $stmt = $dbh->prepare("update empleados set NombreCompleto=:nombre, usuario=:usuario, password=:password where idEmpleado=:id");

            $stmt->bindParam(':nombre',$_POST['nombre']);
            $stmt->bindParam(':usuario',$_POST['usuario']);
            $stmt->bindParam(':password',$password);
            $stmt->bindParam(':id',$_POST['idEmpleado']);
            $stmt->execute();
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
        header("Location: vistaEmpleados.php");
    }else{
        echo "ERROR!";
    }
}else{
    if (isset($_GET['idEmpleado'])&& is_numeric($_GET['idEmpleado'])&& $_GET['idEmpleado']>0){
        $id = $_GET['idEmpleado'];

        try {
            $stmt = $dbh->prepare('select * from empleados where idEmpleado=:id');
            $stmt->bindParam(':id',$_GET['idEmpleado']);
            $stmt->execute();

            $resultado = $stmt->fetchAll();

            if ($resultado){
                foreach ($resultado as $empleado){
                    $nombre = $empleado['NombreCompleto'];
                    $usuario = $empleado['usuario'];
                    $password = $empleado['password'];
                }
                renderForm($id,$nombre,$usuario,$password,"");
            }else{
                echo "No hay resultados";
            }
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
    }else{
        echo "ERROR!";
    }
}
?>