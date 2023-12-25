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

    ?>
    <!-- pagina de LOGIN. hacemos validacion de datos con el tipo email(que no acepte otro tipo de dato). 
    La contraseña se esconde para que no se vean los datos en la pantalla -->
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