<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>Listado de Empleados</title>
</head>
<body>
<?php
include ('connect-db.php');
echo "<p><a href='index.php'>Volver al inicio</a> </p><br><br>";
try {
    $stmt = $dbh->prepare('select * from empleados');
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<p><b>Ver todos</b> | <a href='vistapaginadaEmpleados.php?page=1'>Ver paginados</a></p>";
    echo "<table border='1' cellpaddiing='10'>";
    echo "<tr> <th>ID</th> <th>NOMBRE</th> <th>USUARIO</th><th></th><th></th>";

    foreach ($resultado as $empleado){
        echo "<tr>";
        echo '<td>'.$empleado['idEmpleado'].'</td>';
        echo '<td>'.$empleado['NombreCompleto'].'</td>';
        echo '<td>'.$empleado['usuario'].'</td>';
        echo '<td><a href="editarEmpleados.php?idEmpleado='.$empleado['idEmpleado'].'">Editar</a></td>';
        echo '<td><a href="eliminarEmpleados.php?id='.$empleado['idEmpleado'].'">Eliminar</a></td>';
        echo "</tr>";
    }
    echo "</table>";
}catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
}
?>
<p><a href="nuevoEmpleado.php">Añadir un nuevo registro</a> </p>
</body>
</html>