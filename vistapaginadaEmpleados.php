<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>Paginación de Empleados</title>
</head>
<body>
<?php
include ('connect-db.php');

$per_page=4;

$page=1;
$inicio=0;

if (isset($_GET["page"])){
    $page=$_GET["page"];
    $inicio=($page-1)*$per_page;
}

try {
    $stmt = $dbh->prepare("select * from empleados");
    $stmt->execute();
    $total_results = $stmt->rowCount();
}catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
}

$total_pages = ceil($total_results/$per_page);
try {
    $ssql = "select * from empleados limit ".$inicio.",".$per_page;
    $rs = $dbh->prepare($ssql);
    $rs->execute();
}catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
}
echo "<p><a href='vistaEmpleados.php'>ver todas</a> | <b>Ver página:</b> ";

if ($total_pages>1){
    for ($i = 1;$i<=$total_pages;$i++){
        if ($page==$i)
            echo $page." ";
        else
            echo "<a href='vistapaginadaEmpleados.php?page=".$i."'>".$i."</a>";
    }
}
echo "</p>";

echo "<table dorder='1' cellpadding='10'>";
echo "<tr><th>ID</th> <th>Nombre</th><th>Apellido</th><th></th><th></th>";

while ($fila = $rs->fetchAll(PDO::FETCH_ASSOC)){
    foreach ($fila as $empleado){
        echo "<tr>";
        echo '<td>'.$empleado['idEmpleado'].'</td>';
        echo '<td>'.$empleado['NombreCompleto'].'</td>';
        echo '<td>'.$empleado['usuario'].'</td>';
        echo '<td><a href="editarEmpleados.php?idEmpleado='.$empleado['idEmpleado'].'">Editar</a></td>';
        echo '<td><a href="eliminarEmpleados.php?id='.$empleado['idEmpleado'].'">Eliminar</a></td>';
        echo "</tr>";
    }
}
echo "</table>";
?>
</body>
</html>