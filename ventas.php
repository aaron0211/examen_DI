<?php
ob_start();
require_once ('Sesion.php');
$sesion = new Sesion();
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
    <title>Lista de la Compra</title>
</head>
<body>
<?php
include ('connect-db.php');
echo "<p><a href='index.php'>Volver al inicio</a> </p><br><br>";
try {
    $stmt = $dbh->prepare('select * from productos');
    $stmt->execute();

    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1' cellpaddiing='10' align='center'>";
    echo "<tr> <th>ID</th> <th>NOMBRE</th> <th>Precio</th><th></th><th></th>";

    foreach ($resultado as $producto) {
        echo "<tr>";
        echo '<td>' . $producto['idProducto'] . '</td>';
        echo '<td>' . $producto['Nombre'] . '</td>';
        echo '<td>' . $producto['Precio'] . '</td>';
        echo '<td><a href="editarProductos.php?id=' . $producto['idProducto'] . '">Editar</a></td>';
        if (isset($_SESSION['usuario'])) {
            echo '<td><a href="ventas.php?nombre=' . $producto['Nombre'] . '&precio=' . $producto['Precio'] . '">Añadir</a></td>';
        }
        echo "</tr>";
    }
    echo "</table>";
    echo "<br>";
    echo "<br>";
} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}
if (isset($_POST['cliente'])){
    $nCliente = $_POST['cliente'][0];
    setcookie('cliente', $nCliente);
    header('Location: ticket.php');
}else {
    if (isset($_COOKIE['contador'])) {
        echo "<h2 align='center'>Cesta de la compra</h2>";
        echo "<div align='center'>";
        for ($i = 0; $i < $_COOKIE['contador']; $i++) {
            $nombre = 'nombre' . $i;
            $precio = 'precio' . $i;
            echo $_COOKIE[$nombre] . ' ' . $_COOKIE[$precio];
            echo "<br>";
        }
        if (isset($_GET['nombre'])) {
            setcookie('contador', $_COOKIE['contador'] + 1);
            $nombre = 'nombre';
            $nombre .= $_COOKIE['contador'];
            $precio = 'precio';
            $precio .= $_COOKIE['contador'];
            $nombreProducto = $_GET['nombre'];
            $precioProducto = $_GET['precio'];
            setcookie($nombre, $nombreProducto);
            setcookie($precio, $precioProducto);
            echo $_GET['nombre'] . ' ' . $_GET['precio'];
            echo "<br>";
        }
        echo "</div>";
        if (isset($_COOKIE['total'])) {
            $inicial = $_COOKIE['total'];
            if (isset($_GET['nombre'])) {
                $total = $inicial + $_GET['precio'];
                setcookie('total', $total);
                echo "<br>";
                echo "<div align='center'>";
                echo "El precio total es: " . $total;
                echo "</div>";
                echo "<br><br>";
            } else {
                echo "<br>";
                echo "<div align='center'>";
                echo "El precio total es: " . $inicial;
                echo "</div>";
                echo "<br><br>";
            }
        } else {
            setcookie('total', $_GET['precio']);
        }
    } else {
        setcookie('contador', 0);
    }
}
?>
        <div align="center">
            <form method="post">
            <p>Seleccione un cliente del menú:</p>
            <p>Clientes:
                <select name="cliente[]">
                    <option value="0">Seleccione:</option>
                    <?php
                    $stmt = $dbh->prepare('select * from clientes');
                    $stmt->execute();

                    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultado as $cliente){
                        echo '<option value="'.$cliente['nombre'].'" name="cliente">'.$cliente['nombre'].'</option>';
                    }
                    ?>
                </select>
                <input type="submit" value="Cliente" name="nombre">
            </form>
            </p>
        </div>
</body>
</html>
<?php
ob_end_flush();
?>