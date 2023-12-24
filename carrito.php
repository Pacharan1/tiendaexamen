<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Carrito</title>
</head>

<body>
    <h1>Carrito</h1>
    <table>
        <tr class="encabezado">
            <td>Nombre del Producto</td>
            <td>Cantidad</td>
            <td></td>
        </tr>
        <?php
        include("conexion.php");
        if (isset($_GET['borrado']) && $_GET['borrado'] === 'true') {
            echo "<p class='check'>Registro borrado correctamente</p>";
        }
        $carrito = mostrarCarrito($conexdb);
        foreach ($carrito as $producto) {
            echo
            '<tr>
                    <td>' . $producto["nombre_prod"] . '</td>
                    <td>' . $producto["cantidad"] . '</td>
                    <td>
                        <form action="" method="post">
                            <button class="btn-borrar" name="borrarCarrito">Borrar</button>
                            <input type="hidden" name="nombreProd" value="' . $producto["nombre_prod"] . '">
                        </form>
                    </td>
                </tr>';
        }
        ?>
    </table>

</body>

</html>