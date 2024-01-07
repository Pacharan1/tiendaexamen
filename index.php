<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Apple</title>
    <link rel="stylesheet" href="style.css">
</head>


<?php
//aqui establecemos un condicional para que en funcion de si pulsamos el modo oscuro o el claro nos modifique la clase del body
include("conexion.php");
if (isset($_COOKIE['modoOscuro']) && $_COOKIE['modoOscuro'] == 'true') {
    echo '<body class="modo-oscuro">';
} else {
    echo '<body>';
}

?>
<!-- botones modo oscuro y claro -->
<form action="" method="post">
    <button name="modoOscuro"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 14 14">
            <path fill="#000000" fill-rule="evenodd" d="M0 7a7 7 0 1 1 14 0A7 7 0 0 1 0 7m7-.019a2.46 2.46 0 0 1 2.46-2.459c.25 0 .441-.3.258-.47a3.996 3.996 0 1 0 0 5.86c.183-.17-.008-.471-.258-.471A2.46 2.46 0 0 1 7 6.98Z" clip-rule="evenodd" />
        </svg></button>
    <button name="modoClaro"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="#000000" d="M12 16q-1.671 0-2.836-1.164T8 12q0-1.671 1.164-2.836T12 8q1.671 0 2.836 1.164T16 12q0 1.671-1.164 2.836T12 16M2 12.5q-.213 0-.356-.144Q1.5 12.212 1.5 12t.144-.356Q1.788 11.5 2 11.5h2.5q.213 0 .356.144Q5 11.788 5 12t-.144.356q-.143.143-.356.143zm17.5 0q-.213 0-.356-.144Q19 12.212 19 12t.144-.356q.144-.143.356-.143H22q.213 0 .356.144q.144.144.144.357t-.144.356q-.143.143-.356.143zM12 5q-.213 0-.357-.144q-.143-.143-.143-.356V2q0-.213.144-.356q.144-.144.357-.144t.356.144q.143.144.143.356v2.5q0 .213-.144.356Q12.212 5 12 5m0 17.5q-.212 0-.356-.144q-.143-.143-.143-.356v-2.5q0-.213.144-.356Q11.788 19 12 19t.356.144q.143.144.143.356V22q0 .213-.144.356q-.144.144-.357.144M6.362 7.03l-1.44-1.395q-.147-.14-.144-.345q.003-.203.149-.369q.16-.165.354-.165q.194 0 .354.165L7.05 6.342q.16.166.16.354q0 .189-.15.354t-.342.153q-.191-.013-.356-.172m12.003 12.048l-1.415-1.421q-.16-.166-.16-.357q0-.191.16-.351q.13-.165.327-.153t.361.172l1.44 1.396q.147.14.144.345q-.003.203-.149.369q-.16.165-.354.165q-.194 0-.354-.165M16.95 7.059q-.165-.15-.153-.34t.172-.357l1.396-1.44q.14-.147.345-.144q.203.003.369.149q.165.16.165.354q0 .194-.165.354L17.658 7.05q-.166.16-.354.16q-.189 0-.354-.15M4.921 19.083q-.165-.17-.165-.364q0-.194.165-.354l1.421-1.415q.166-.16.357-.16q.191 0 .351.16q.146.13.134.327t-.153.361l-1.396 1.44q-.16.166-.354.163q-.194-.003-.36-.158" />
        </svg></button>
</form>

<?php
/*Aqui introducimos los GET que nos llegan de los header que vienen de los condicionales de conexion.php*/

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
if (isset($_GET['logeate']) && $_GET['logeate'] === 'true') {
    echo "<p class='error'>Primero tienes que iniciar sesion</p>";
}
?>



<div class="contenedor-tabla">
    <form class="utilidades" action="" method="post">
        <button class="btn-crear" name="ir_crear">Crear</button>
        <div class="acceso">
            <?php
            //***aqui creo un condicional que me muestre diferentes botones en funcion de si esta iniciada la sesion o no***
            session_start();
            if (isset($_SESSION['usuario'])) {
                echo '
                        <form action="" method="post">
                        <input type="text" name="buscar">
                        <input type="submit" value="Buscar">
                        </form>
                        <h4>Hola, ' . ($_SESSION['usuario']) . '</h4>
                        <button class="btn-registro" name="ir_carrito">Carrito</button>
                        <button class="btn-login" name="logout">Logout</button>';
            } else {
                echo '
                        <form action="" method="post">
                        <input type="text" name="buscar">
                        <input type="submit" value="Buscar">
                        </form>
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

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
            if (empty($_POST['buscar'])) {
                echo "No has introducido ningun producto";
            } else {
                $busqueda = $_POST['buscar'];
                $productos = mostrarProductosBuscados($conexdb, $busqueda);
                if (empty($productos)) {
                    echo "No se ha encontrado ningun producto";
                } else {
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
                            <input type="hidden" name="nombreprod" value="' . $producto["nombre_prod"] . '">
                            <input type="hidden" name="precioprod" value="' . $producto["precio_prod"] . '">
                        </form>
                    </td>
                </tr>';
                    }
                }
            }
        } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrar_filtro'])) {
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
                            <input type="hidden" name="nombreprod" value="' . $producto["nombre_prod"] . '">
                            <input type="hidden" name="precioprod" value="' . $producto["precio_prod"] . '">
                        </form>
                    </td>
                </tr>';
            }
        } else {
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
                            <input type="hidden" name="nombreprod" value="' . $producto["nombre_prod"] . '">
                            <input type="hidden" name="precioprod" value="' . $producto["precio_prod"] . '">
                        </form>
                    </td>
                </tr>';
            }
        }


        ?>

    </table>
</div>
<form action="" method="post">
    <button name="borrar_filtro">Reset</button>
</form>
</div>
</body>

</html>