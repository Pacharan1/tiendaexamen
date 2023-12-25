<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Carrito</title>
</head>


<?php
/*Esta es la pagina del carrito, en la cabecera tambien ponemos las cookies para el modo oscuro y sus botones*/
session_start();
if (isset($_COOKIE['modoOscuro']) && $_COOKIE['modoOscuro'] == 'true') {
    echo '<body class="modo-oscuro">';
} else {
    echo '<body>';
}

//si la sesion no esta iniciada, redirigimos a la pagina principal
if (!$_SESSION['usuario']) {
    header("Location: index.php?logeate=true");
}
?>
<form action="" method="post">
    <button name="modoOscuro"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 14 14">
            <path fill="#000000" fill-rule="evenodd" d="M0 7a7 7 0 1 1 14 0A7 7 0 0 1 0 7m7-.019a2.46 2.46 0 0 1 2.46-2.459c.25 0 .441-.3.258-.47a3.996 3.996 0 1 0 0 5.86c.183-.17-.008-.471-.258-.471A2.46 2.46 0 0 1 7 6.98Z" clip-rule="evenodd" />
        </svg></button>
    <button name="modoClaro"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
            <path fill="#000000" d="M12 16q-1.671 0-2.836-1.164T8 12q0-1.671 1.164-2.836T12 8q1.671 0 2.836 1.164T16 12q0 1.671-1.164 2.836T12 16M2 12.5q-.213 0-.356-.144Q1.5 12.212 1.5 12t.144-.356Q1.788 11.5 2 11.5h2.5q.213 0 .356.144Q5 11.788 5 12t-.144.356q-.143.143-.356.143zm17.5 0q-.213 0-.356-.144Q19 12.212 19 12t.144-.356q.144-.143.356-.143H22q.213 0 .356.144q.144.144.144.357t-.144.356q-.143.143-.356.143zM12 5q-.213 0-.357-.144q-.143-.143-.143-.356V2q0-.213.144-.356q.144-.144.357-.144t.356.144q.143.144.143.356v2.5q0 .213-.144.356Q12.212 5 12 5m0 17.5q-.212 0-.356-.144q-.143-.143-.143-.356v-2.5q0-.213.144-.356Q11.788 19 12 19t.356.144q.143.144.143.356V22q0 .213-.144.356q-.144.144-.357.144M6.362 7.03l-1.44-1.395q-.147-.14-.144-.345q.003-.203.149-.369q.16-.165.354-.165q.194 0 .354.165L7.05 6.342q.16.166.16.354q0 .189-.15.354t-.342.153q-.191-.013-.356-.172m12.003 12.048l-1.415-1.421q-.16-.166-.16-.357q0-.191.16-.351q.13-.165.327-.153t.361.172l1.44 1.396q.147.14.144.345q-.003.203-.149.369q-.16.165-.354.165q-.194 0-.354-.165M16.95 7.059q-.165-.15-.153-.34t.172-.357l1.396-1.44q.14-.147.345-.144q.203.003.369.149q.165.16.165.354q0 .194-.165.354L17.658 7.05q-.166.16-.354.16q-.189 0-.354-.15M4.921 19.083q-.165-.17-.165-.364q0-.194.165-.354l1.421-1.415q.166-.16.357-.16q.191 0 .351.16q.146.13.134.327t-.153.361l-1.396 1.44q-.16.166-.354.163q-.194-.003-.36-.158" />
        </svg></button>
</form>
<h1>Carrito</h1>


<!-- aqui hacemos la CONSULTA a la base de datos para mostrar los productos que hay en el carrito -->
<table>
    <tr class="encabezado">
        <td>Nombre del Producto</td>
        <td>Cantidad</td>
        <td></td>
    </tr>
    <?php
    include("conexion.php");
    //GET para confirmar si hemos eliminado algo del carrito
    if (isset($_GET['borrado']) && $_GET['borrado'] === 'true') {
        echo "<p class='check'>Registro borrado correctamente</p>";
    }
    $usuario = $_SESSION['id'];
    $carrito = mostrarCarrito($conexdb, $usuario);
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
<form action="index.php" method="post">
    <button name="volver">Volver al inicio</button>
    </body>

</html>