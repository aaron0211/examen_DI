<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>Paginación de Productos</title>
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
    $stmt = $dbh->prepare("select * from productos");
    $stmt->execute();
    $total_results = $stmt->rowCount();
}catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
}

$total_pages = ceil($total_results/$per_page);
try {
    $ssql = "select * from productos limit ".$inicio.",".$per_page;
    $rs = $dbh->prepare($ssql);
    $rs->execute();
}catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
}
echo "<p><a href='vistaProductos.php'>ver todas</a> | <b>Ver página:</b> ";

if ($total_pages>1){
    for ($i = 1;$i<=$total_pages;$i++){
        if ($page==$i)
            echo $page." ";
        else
            echo "<a href='vistapaginadaProductos.php?page=".$i."'>".$i."</a>";
    }
}
echo "</p>";

echo "<table dorder='1' cellpadding='10'>";
echo "<tr><th>ID</th> <th>Nombre</th><th>Precio</th><th></th>";

while ($fila = $rs->fetchAll(PDO::FETCH_ASSOC)){
    foreach ($fila as $producto){
        echo "<tr>";
        echo '<td>'.$producto['idProducto'].'</td>';
        echo '<td>'.$producto['Nombre'].'</td>';
        echo '<td>'.$producto['Precio'].'</td>';
        echo '<td><a href="editarProductos.php?id='.$producto['idProducto'].'">Editar</a></td>';
        echo "</tr>";
    }
}
echo "</table>";
?>
</body>
</html>