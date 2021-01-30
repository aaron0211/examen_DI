<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>Listado de Registros</title>
</head>
<body>
<?php
include ('connect-db.php');
echo "<p><a href='index.php'>Volver al inicio</a> </p><br><br>";
try {
    $stmt = $dbh->prepare('select * from clientes');
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<p><b>Ver todos</b> | <a href='vistapaginadaClientes.php?page=1'>Ver paginados</a></p>";
    echo "<table border='1' cellpaddiing='10'>";
    echo "<tr> <th>ID</th> <th>NOMBRE</th> <th>APELLIDO</th><th></th><th></th><th></th>";

    foreach ($resultado as $cliente){
        echo "<tr>";
        echo '<td>'.$cliente['idCliente'].'</td>';
        echo '<td>'.$cliente['nombre'].'</td>';
        echo '<td>'.$cliente['apellidos'].'</td>';
        echo '<td>'.$cliente['codPostal'].'</td>';
        echo '<td><a href="editarClientes.php?id='.$cliente['idCliente'].'">Editar</a></td>';
        echo '<td><a href="eliminarClientes.php?id='.$cliente['idCliente'].'">Eliminar</a></td>';
        echo "</tr>";
    }
    echo "</table>";
}catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
}
?>
<p><a href="nuevoCliente.php">Añadir un nuevo registro</a> </p>
</body>
</html>