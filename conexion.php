<?php
//CONEXION
try {
    $conexion = "mysql:host=localhost;dbname=tiendaexamen";
    $conexdb = new PDO($conexion, "root", "sF@94pkgPB,");
    $conexdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getmessage(); //si no nos entra en la BBDD, nos sacaria un error
}


//EVENTOS AISLADOS
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ir_crear'])) {
    header("location: crear.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ir_login'])) {
    header("location: login.php");
}



//FUNCIONES
function mostrarProductos($conexdb)
{
    try {
        $query = "SELECT * FROM productos";
        $stm = $conexdb->prepare($query);
        $stm->execute();
        $productos = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    } catch (PDOException $e) {
        echo $e->getmessage();
    }
}

//el siguiente condicional y funcion es para crear un producto. Dentro del condicional se evalua el precio que sea un numero y que no está vacio
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear'])) {
    $nombre = $_POST["nombre"];
    $precio = $_POST["precio"];
    if (empty($nombre) || empty($precio)) {
        header("Location: crear.php?vacio=true");
        exit;
    }
    if (!is_int($precio)) {
        header("Location: crear.php?nonum=true");
        exit;
    } else {
        crear($conexdb, $nombre, $precio);
    }
}
function crear($conexdb, $nombre, $precio)
{

    try {
        $query = "INSERT INTO productos(nombre_prod, precio_prod) VALUES (:nombre, :precio)";
        $stm = $conexdb->prepare($query);
        $stm->bindParam(":nombre", $nombre, PDO::PARAM_STR, 255);
        $stm->bindParam(":precio", $precio, PDO::PARAM_INT);
        $stm->execute();
        header("Location: index.php?creado=true");
    } catch (PDOException $e) {
        header("Location: index.php?error=true");
    }
}
//el siguiente condicional y funcion es para borrar productos de la base de datos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrar'])) {
    $idprod = $_POST["idprod"];
    borrar($conexdb, $idprod);
}

function borrar($conexdb, $idprod)
{
    try {
        $query = "DELETE FROM productos WHERE idproductos = :idprod";
        $stm = $conexdb->prepare($query);
        $stm->bindParam(":idprod", $idprod, PDO::PARAM_INT);
        $stm->execute();
        header("Location: index.php?borrado=true");
    } catch (PDOException $e) {
        header("Location: index.php?error=true");
    }
}
