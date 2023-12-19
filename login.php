<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <?php
    include("conexion.php");
    if (isset($_GET['errorform']) && $_GET['errorform'] === 'true') {
        echo "<p class='check'>Registro realizado correctamente</p>";
    }
    ?>
    <!-- RECUERDA METER EL ACTION CON LA PAGINA A DONDE QUIERES IR CON EL USUARIO -->
    <form action="" method="post">
        <p>Correo electronico</p>
        <input type="email" name="email" required><br>
        <p>Contraseña</p>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="iniciar" value="Iniciar">
    </form>
    <br><br>
    <a href="/registro.php">No estoy registrado. Ir al registro</a>
</body>

</html>