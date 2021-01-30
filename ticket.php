<?php
ob_start();
require_once ('Sesion.php');
$sesion = new Sesion();
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
        <title>Ticket</title>
    </head>
    <body>
    <?php
    include ('connect-db.php');
    echo "<p><a href='index.php'>Volver al inicio</a> </p><br><br>";
    echo "<h1 align='center'>Ticket de Compra</h1>";
    try {
        $stmt = $dbh->prepare('select * from productos');
        $stmt->execute();

        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<table border='0' cellpaddiing='10' align='center'>";
        echo "<tr> <td colspan='4' align='center'>TICKET EXAMEN</td></tr>";
        echo "<tr> <td colspan='2'>C/ Violeta Parra 9</td>";
        echo "<td colspan='2' align='center'>".date("j/m/Y G:i")."</td></tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "</tr>";

        for ($i=0;$i<$_COOKIE['contador'];$i++) {
            $nombre = 'nombre'.$i;
            $precio = 'precio'.$i;
            echo "<tr>";
            echo '<td colspan="2" align="center">' . $_COOKIE[$nombre] . '</td>';
            echo '<td colspan="2" align="center">' . $_COOKIE[$precio] . '€</td>';
            echo "</tr>";
        }
        echo "<tr>";
        echo "<td colspan='2'>Total</td>";
        echo "<td colspan='2'>".$_COOKIE['total']."€</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='4' align='center'>Información IVA</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>Tasa</td>";
        echo "<td>Base Imp</td>";
        echo "<td>Val. IVA</td>";
        echo "<td>Val. TOTAL</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>10%</td>";
        $base = $_COOKIE['total']*100/110;
        echo "<td>".round($base,2)."</td>";
        $iva = $base/10;
        echo "<td>".round($iva,2)."</td>";
        echo "<td>".$_COOKIE['total']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td></td>";
        echo "</tr>";
        echo "<td colspan='2'>Vendedor</td>";
        echo "<td colspan='2'>".$_SESSION['nombre']."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2'>Cliente</td>";
        echo "<td colspan='2'>".$_COOKIE['cliente']."</td>";
        echo "</tr>";
        echo "</table>";
        echo "<br>";
        echo "<br>";
    } catch (PDOException $e) {
        echo "ERROR: " . $e->getMessage();
    }?>
    </div>
    </body>
    </html>
<?php
ob_end_flush();
?>