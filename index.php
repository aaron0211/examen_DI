<?php
ob_start();
require_once ('Sesion.php');
$sesion = new Sesion();
if (isset($_SESSION['usuario'])){
        echo '<a id="nombre">Hola '.$sesion->get('usuario').'</a></a>';
    }else{
        echo '<a id="nombre">Si quieres escribir debes iniciar sesión';
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>EXAMEN</title>
</head>
<body>
<h1>EXAMEN</h1>
<div id="barra">
    <a id="menu" href="vistaEmpleados.php">Empleados</a>
    <a id="menu" href="vistaProductos.php">Productos</a>
    <a id="menu" href="vistaClientes.php">Clientes</a>
    <a id="menu" href="vistaCategorias.php">Categorías</a>
    <?php
    if (isset($_SESSION['usuario'])){
        if (isset($_POST['cerrar'])){
            if (isset($_SERVER['HTTP_COOKIE'])) {
                $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
                foreach($cookies as $cookie) {
                    $parts = explode('=', $cookie);
                    $name = trim($parts[0]);
                    setcookie($name, null, time()-3600);
                    setcookie($name, null, time()-3600, '/');
                }
            }
            $sesion->borrarSesion();
        }?>
        <br>
        <br>
        <form method="post">
            <input id="cerrar" type="submit" value="Cerrar sesión" name="cerrar">
        </form>
        <br>
        <br>
        <a href='ventas.php'>Ventas</a><?php
    }else{
        if (isset($_POST['login'])){
            header('Location: login.php');
        }
        echo "<br>";
        echo "<br>";
        echo "<form method='post'>";
            echo "<input id='login' type='submit' value='Login' name='login'>";
        echo "</form>";
    }
    ?>
</div>
<?php
ob_end_flush();
?>