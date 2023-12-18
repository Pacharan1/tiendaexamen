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
    /*Aqui introducimos los GET que nos llegan de los header que vienen de los condicionales de conexion.php*/
    include("conexion.php");
    if (isset($_GET['creado']) && $_GET['creado'] === 'true') {
        echo "<p class='check'>Registro realizado correctamente</p>";
    }
    if (isset($_GET['error']) && $_GET['error'] === 'true') {
        echo "<p class='error'>Hubo un error</p>";
    }
    if (isset($_GET['borrado']) && $_GET['borrado'] === 'true') {
        echo "<p class='check'>Registro borrado correctamente</p>";
    }
    if (isset($_GET['modificado']) && $_GET['modificado'] === 'true') {
        echo "<p class='check'>Registro modificado correctamente</p>";
    }

    ?>
    <div class="contenedor-tabla">
        <form class="utilidades" action="" method="post">
            <button class="btn-crear" name="ir_crear">Crear</button>
            <button class="btn-login" name="ir_login">Login</button>
        </form>

        <table>
            <tr class="encabezado">
                <td>ID</td>
                <td>Nombre del Producto</td>
                <td>Precio</td>
                <td></td>
            </tr>
            <?php
            /*para mostrar los productos he creado una sentencia preparada en el archivo conexion.php el cual hace un fetchAll 
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
                        <form action="" method="post">
                            <a class="btn-modificar" href=modificar.php?id=' . $producto["idproductos"] . '>Modificar</a>
                            <button class="btn-borrar" name="borrar">Borrar</button>
                            <input type="hidden" name="idprod" value="' . $producto["idproductos"] . '"> 
                        </form>
                    </td>
                </tr>';
            }
            ?>

        </table>
    </div>
</body>

</html>