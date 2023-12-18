<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Modificar</title>
</head>

<body>
    <?php
    include("conexion.php");
    if (isset($_GET['id'])) {
        $idprod = $_GET['id'];
        echo $idprod;
    }

    ?>
    <form action="" method="post">
        <label for="">Nuevo nombre</label>
        <input type="text" name="nombre"><br>
        <label for="">Nuevo precio</label>
        <input type="number" name="precio"><br>
        <input type="submit" name="modificar" value="modificar">
    </form>

</body>

</html>