<?php

function renderForm($id,$nombre,$precio,$error){
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
            <strong>Precio: *</strong><input type="text" name="precio" value="<?php echo $precio; ?>">
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
        $precio = htmlspecialchars($_POST['precio']);

        try {
            $stmt = $dbh->prepare("update productos set Nombre=:nombre, Precio=:precio where idProducto=:id");

            $stmt->bindParam(':nombre',$_POST['nombre']);
            $stmt->bindParam(':precio',$_POST['precio']);
            $stmt->bindParam(':id',$_POST['id']);
            $stmt->execute();
        }catch (PDOException $e){
            echo "ERROR: ".$e->getMessage();
        }
        header("Location: vistaProductos.php");
    }else{
        echo "ERROR!";
    }
}else{
    if (isset($_GET['id'])&& is_numeric($_GET['id'])&& $_GET['id']>0){
        $id = $_GET['id'];

        try {
            $stmt = $dbh->prepare('select * from productos where idProducto=:id');
            $stmt->bindParam(':id',$_GET['id']);
            $stmt->execute();

            $resultado = $stmt->fetchAll();

            if ($resultado){
                foreach ($resultado as $producto){
                    $nombre = $producto['Nombre'];
                    $precio = $producto['Precio'];
                }
                renderForm($id,$nombre,$precio,"");
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