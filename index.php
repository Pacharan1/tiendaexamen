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
    if (isset($_GET['registro']) && $_GET['registro'] === 'true') {
        echo "<p class='check'>Registro realizado correctamente</p>";
    }

    ?>
    <div class="contenedor-tabla">
        <form class="utilidades" action="" method="post">
            <button class="btn-crear" name="ir_crear">Crear</button>
            <div class="acceso">
                <?php
                session_start();
                if (isset($_SESSION['usuario'])) {
                    echo '
                        <h4>Hola, ' . ($_SESSION['usuario']) . '</h4>
                        <button class="btn-registro" name="ir_carrito">Carrito</button>
                        <button class="btn-login" name="logout">Logout</button>';
                } else {
                    echo '
                        <button class="btn-registro" name="ir_registro">Registro</button>
                        <button class="btn-login" name="ir_login">Login</button>
                        ';
                }
                ?>
            </div>
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
                            ' . (isset($_SESSION['usuario']) ? '<button class="btn-anadir" name="anadir">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"><path fill="#000000" d="M10 0v4H8l4 4l4-4h-2V0M1 2v2h2l3.6 7.6L5.2 14c-.1.3-.2.6-.2 1c0 1.1.9 2 2 2h12v-2H7.4c-.1 0-.2-.1-.2-.2v-.1l.9-1.7h7.4c.7 0 1.4-.4 1.7-1l3.9-7l-1.7-1l-3.9 7h-7L4.3 2M7 18c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2m10 0c-1.1 0-2 .9-2 2s.9 2 2 2s2-.9 2-2s-.9-2-2-2"/></svg>
                            </button>' : '') . '
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