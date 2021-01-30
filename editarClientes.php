<?php

function renderForm($id,$nombre,$apellidos,$cod,$error){
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
        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
        <div>
            <p><strong>ID:</strong><?php echo $id; ?></p>
            <strong>Nombre: *</strong><input type="text" name="nombre" value="<?php echo $nombre; ?>">
            <strong>Apellidos: *</strong><input type="text" name="apellidos" value="<?php echo $apellidos; ?>">
            <strong>Código Postal: *</strong><input type="text" name="cod" value="<?php echo $cod; ?>">
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
    if (is_numeric($_POST['id'])){
        $id = $_POST['id'];
        $nombre = htmlspecialchars($_POST['nombre']);
        $apellidos = htmlspecialchars($_POST['apellidos']);
        $cod = htmlspecialchars($_POST['cod']);

        try {
            $stmt = $dbh->prepare("update clientes set nombre=:nombre, apellidos=:apellidos, codPostal=:cod where idCliente=:id");

            $stmt->bindParam(':nombre',$_POST['nombre']);
            $stmt->bindParam(':apellidos',$_POST['apellidos']);
            $stmt->bindParam(':cod',$_POST['cod']);
            $stmt->bindParam(':id',$_POST['id']);
            $stmt->execute();
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
        header("Location: vistaClientes.php");
    }else{
        echo "ERROR!";
    }
}else{
    if (isset($_GET['id'])&& is_numeric($_GET['id'])&& $_GET['id']>0){
        $id = $_GET['id'];

        try {
            $stmt = $dbh->prepare('select * from clientes where idCliente=:id');
            $stmt->bindParam(':id',$_GET['id']);
            $stmt->execute();

            $resultado = $stmt->fetchAll();

            if ($resultado){
                foreach ($resultado as $cliente){
                    $nombre = $cliente['nombre'];
                    $apellidos = $cliente['apellidos'];
                    $cod = $cliente['codPostal'];
                }
                renderForm($id,$nombre,$apellidos,$cod,"");
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