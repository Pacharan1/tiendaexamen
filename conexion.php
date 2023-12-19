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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ir_modificar'])) {
    header("location: modificar.php");
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
    $precio = intval($_POST["precio"]);
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
//el siguiente condicional y funcion es para modificar productos de la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modificar'])) {
    $idprod = intval($_GET['id']);
    $nombre = $_POST["nombre"];
    $precio = intval($_POST["precio"]);
    modificar($conexdb, $nombre, $precio, $idprod);
}
function modificar($conexdb, $nombre, $precio, $idprod)
{
    try {
        $query = "UPDATE productos SET nombre_prod = :nombre, precio_prod = :precio WHERE idproductos = :idprod;";
        $stm = $conexdb->prepare($query);
        $stm->bindParam(":nombre", $nombre, PDO::PARAM_STR, 255);
        $stm->bindParam(":precio", $precio, PDO::PARAM_INT);
        $stm->bindParam(":idprod", $idprod, PDO::PARAM_INT);
        $stm->execute();
        header("Location: index.php?modificado=true");
    } catch (PDOException $e) {
        header("Location: index.php?error=true");
    }
}

// aqui recibimos los datos de registro y ejecutamos la funcion definida a continuacion
if (isset($_POST["registro"])) {
    $usuario = $_POST["emailregistro"];
    $contrasena1 = $_POST["passregistro"];
    $contrasena2 = $_POST["passregistrodos"];
    registro($conexdb, $usuario, $contrasena1, $contrasena2);
}

/* la funcion registro recibe los datos y ejecuta el INSERT.
Por seguridad, utiliza la funcion password_hash para encriptar la contraseña que se almacena
despues volvemos a la pagina index con un GET para que ejecute el mensaje en verde de que esta correcto */
function registro($conexion, $usuario, $contrasena1, $contraseña2)
{
    try {
        if ($contrasena1 == $contraseña2) {

            $stm = $conexion->prepare("INSERT INTO usuarios(correo_electronico, contrasena) VALUES (:usuario, :contrasena)");
            $stm->bindParam(":usuario", $usuario, PDO::PARAM_STR, 255);
            $stm->bindParam(":contrasena", hashContrasenia($contrasena1), PDO::PARAM_STR, 255);
            $stm->execute();
            header("location: index.php?errorform=true");
        }
    } catch (PDOException $e) {
        echo $e->getmessage();
    }
}
//funcion para encriptar la contraseña
function hashContrasenia($contrasenia)
{
    return password_hash($contrasenia, PASSWORD_BCRYPT);
};
