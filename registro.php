<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
</head>

<body>
    <?php
    include("funciones.php");
    /* aqui realizamos el formulario de registro que tomará los datos para gestionarlo
    desde la pagina funciones.php y creará al usuario en la base de datos */
    ?>
    <form action="registro.php" method="post">
        <p>Correo Electronico</p>
        <input type="email" name="emailregistro" required><br>
        <p>Contraseña</p>
        <input type="password" name="passregistro" required><br>
        <p>Confirmar contraseña</p>
        <input type="password" name="passregistrodos" required><br><br>
        <input type="submit" name="registro" value="REGISTRO"><br><br>
        <a href="/index.php">Acceso: Ya estoy registrado en el sistema</a>
    </form>


</body>


</html>