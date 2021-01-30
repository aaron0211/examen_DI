<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>Listado de Productos</title>
</head>
<body>
<?php
include ('connect-db.php');
echo "<p><a href='index.php'>Volver al inicio</a> </p><br><br>";
try {
    $stmt = $dbh->prepare('select * from productos');
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<p><b>Ver todos</b> | <a href='vistapaginadaProductos.php?page=1'>Ver paginados</a></p>";
    echo "<table border='1' cellpaddiing='10'>";
    echo "<tr> <th>ID</th> <th>NOMBRE</th> <th>Precio</th><th></th>";

    foreach ($resultado as $producto){
        echo "<tr>";
        echo '<td>'.$producto['idProducto'].'</td>';
        echo '<td>'.$producto['Nombre'].'</td>';
        echo '<td>'.$producto['Precio'].'</td>';
        echo '<td><a href="editarProductos.php?id='.$producto['idProducto'].'">Editar</a></td>';
        echo "</tr>";
    }
    echo "</table>";
}catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
}
?>
<p><a href="nuevoProducto.php">Añadir un nuevo registro</a> </p>
</body>
</html>