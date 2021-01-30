<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>Listado de Categorías</title>
</head>
<body>
<?php
include ('connect-db.php');
echo "<p><a href='index.php'>Volver al inicio</a> </p><br><br>";
try {
    $stmt = $dbh->prepare('select * from categorias');
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<p><b>Ver todos</b> | <a href='viewpaginated.php?page=1'>Ver paginados</a></p>";
    echo "<table border='1' cellpaddiing='10'>";
    echo "<tr> <th>ID</th> <th>Descripción</th>";

    foreach ($resultado as $categoria){
        echo "<tr>";
        echo '<td>'.$categoria['idCategoria'].'</td>';
        echo '<td>'.$categoria['Descripcion'].'</td>';
        echo "</tr>";
    }
    echo "</table>";
}catch (PDOException $e){
    echo "ERROR: ".$e->getMessage();
}
?>
<p><a href="nuevaCategoria.php">Añadir un nuevo registro</a> </p>
</body>
</html>