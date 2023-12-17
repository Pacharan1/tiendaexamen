<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Crear Registro</title>
</head>

<body>
    <?php
    /*Aqui introducimos los GET que nos llegan de los header que vienen de los condicionales de conexion.php
    Y creamos el formulacio de registro de productos*/
    include("conexion.php");
    if (isset($_GET['vacio']) && $_GET['vacio'] === 'true') {
        echo "<p class='error'>Hay campos vacios</p>";
    }
    if (isset($_GET['nonum']) && $_GET['nonum'] === 'true') {
        echo "<p class='error'>El precio debe de ser un numero</p>";
    }
    ?>
    <form action="" method="post">
        <label for="">Nombre</label>
        <input type="text" name="nombre">
        <label for="">precio</label>
        <input type="number" name="precio">
        <input type="submit" name="crear" value="crear">
    </form>

</body>

</html>