<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Apple</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include("conexion.php");
    ?>
    <div class="contenedor-tabla">
        <div class="utilidades">
            <button class="btn-crear">Crear</button>
            <button class="btn-login">Login</button>
        </div>
        <table>
            <tr class="encabezado">
                <td>ID</td>
                <td>Nombre del Producto</td>
                <td>Precio</td>
                <td></td>
            </tr>
            <?php
            /*para mostrar los productos he creado una sentencia preparada en el archivo conexion.php el cualhace un fetchAll 
            de todos los registros de la base de datos de los productos y en el index llamamos a la funcion y con un foreach vamos 
            imprimiendo producto por producto */
            $productos = mostrarProductos($conexdb);
            foreach ($productos as $producto) {
                echo
                '<tr>
                    <td>' . $producto["idproductos"] . '</td>
                    <td>' . $producto["nombre_prod"] . '</td>
                    <td>' . $producto["precio_prod"] . ' €</td>
                    <td>
                        <button class="btn-modificar">Modificar</button>
                        <button class="btn-borrar">Borrar</button>
                    </td>
                </tr>';
            }
            ?>

        </table>
    </div>
</body>

</html>