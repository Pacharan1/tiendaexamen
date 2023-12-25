<?php

//CONEXION
try {
    $conexion = "mysql:host=localhost;dbname=tiendaexamen";
    $conexdb = new PDO($conexion, "root", "sF@94pkgPB,");
    $conexdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getmessage(); //si no nos entra en la BBDD, nos sacaria un error
}

//----------------------------------------------------------------------------------

//EVENTOS que redireccionan a las distintas paginas de la web
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ir_crear'])) {
    header("location: crear.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ir_login'])) {
    header("location: login.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ir_modificar'])) {
    header("location: modificar.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ir_registro'])) {
    header("location: registro.php");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ir_carrito'])) {
    header("location: carrito.php");
}
// este evento es exclusivo para DESTRUIR LA SESION y volver a la pagina principal
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['logout'])) {

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    //DESTRUIMOS SESION Y VOLVEMOS A LA PAGINA PRINCIPAL
    session_destroy();

    header("Location: index.php");
}

//----------------------------------------------------------------------------------


//Con el siguiente condicional, vamos a controlar las COOKIES que definen el modo oscuro y modo claro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modoOscuro'])) {
    setcookie("modoOscuro", "true", time() + 60 * 60 * 24 * 30);
    header("Location: {$_SERVER['PHP_SELF']}");
} elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modoClaro'])) {
    setcookie("modoOscuro", "false", time() + 60 * 60 * 24 * 30);
    header("Location: {$_SERVER['PHP_SELF']}");
}

//----------------------------------------------------------------------------------

//***FUNCIONES***
//***La siguiente funcion es para mostrar los productos en la pagina principal***
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

//----------------------------------------------------------------------------------

//***El siguiente condicional y funcion es para CREAR un producto.***
//Dentro del condicional se evalua el precio que sea un numero y que no está vacio
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

//----------------------------------------------------------------------------------

//***el siguiente condicional y funcion es para BORRAR productos de la base de datos***
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

//----------------------------------------------------------------------------------

//***el siguiente condicional y funcion es para MODIFICAR productos de la base de datos UTILIZANDO UN GET***
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

//----------------------------------------------------------------------------------

// ***aqui recibimos los datos de REGISTRO y ejecutamos la funcion definida a continuacion***
if (isset($_POST["registro"])) {
    $usuario = $_POST["emailregistro"];
    $contrasena1 = $_POST["passregistro"];
    $contrasena2 = $_POST["passregistrodos"];
    registro($conexdb, $usuario, $contrasena1, $contrasena2);
}
/* la funcion registro recibe los datos y ejecuta el INSERT.
Por SEGURIDAD, utiliza la funcion password_hash para encriptar la contraseña que se almacena
despues volvemos a la pagina index con un GET para que ejecute el mensaje en verde de que esta correcto */
function registro($conexion, $usuario, $contrasena1, $contraseña2)
{
    try {
        if ($contrasena1 == $contraseña2) {

            $stm = $conexion->prepare("INSERT INTO usuarios(user, contrasena) VALUES (:usuario, :contrasena)");
            $stm->bindParam(":usuario", $usuario, PDO::PARAM_STR, 255);
            $stm->bindParam(":contrasena", hashContrasenia($contrasena1), PDO::PARAM_STR, 255);
            $stm->execute();
            header("Location: index.php?registro=true");
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

//----------------------------------------------------------------------------------

/*esta condicional y la siguiente funcion es para INICIAR SESION que basicamente lo que hace es un SELECT que reciba el usuario 
de la base de datos y compare las contraseñas para darle el acceso*/
if (isset($_POST["iniciar"])) {
    $usuario = $_POST["email"];
    $contrasena = $_POST["password"];
    iniciarSesion($conexdb, $usuario, $contrasena);
};

function iniciarSesion($conexion, $usuario, $contrasena)
{
    try {
        $stm = $conexion->prepare("SELECT * FROM usuarios WHERE user = :usuario;");
        $stm->bindParam(":usuario", $usuario, PDO::PARAM_STR, 255);
        $stm->execute();
        $resultado = $stm->fetch(PDO::FETCH_ASSOC);
        if ($resultado) {
            if (password_verify($contrasena, $resultado['contrasena'])) {
                session_start();
                $_SESSION['usuario'] = $resultado['user'];
                $_SESSION['id'] = $resultado['idusuarios'];
                header("Location: index.php");
            }
        }
    } catch (PDOException $e) {
        echo $e->getmessage();
    }
};

//----------------------------------------------------------------------------------

// el siguiente condicional y la siguiente funcion es para AÑADIR PRODUCTOS AL CARRITO y MOSTRAR CARRITO
//ademas, se comprueba que el producto no este ya en el carrito, si lo esta, se actualiza la cantidad
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['anadir'])) {
    session_start();
    $iduser = $_SESSION['id'];
    $idprod = $_POST["nombreprod"];
    try {
        $stm = $conexdb->prepare("SELECT idusuarios, cantidad FROM carrito WHERE nombre_prod = :idprod");
        $stm->bindParam(":idprod", $idprod, PDO::PARAM_STR, 255);
        $stm->execute();
        $resultado = $stm->fetch(PDO::FETCH_ASSOC);
        if ($resultado['idusuarios'] == $_SESSION['id'] && $resultado['nombre_prod'] == $_POST["nombreprod"]) {
            $cantidad = $resultado['cantidad'] + 1;
            actualizarCarrito($conexdb, $idprod, $cantidad);
        } else {
            $cantidad = 1;
            anadirCarrito($conexdb, $iduser, $idprod, $cantidad);
        }
        header("Location: index.php?registro=true");
    } catch (PDOException $e) {
        echo $e->getmessage();
    }
}

function anadirCarrito($conexion, $iduser, $idprod, $cantidad)
{
    try {
        $stm = $conexion->prepare("INSERT INTO carrito(idusuarios, nombre_prod, cantidad) VALUES (:iduser, :idprod, :cantidad)");
        $stm->bindParam(":iduser", $iduser, PDO::PARAM_INT);
        $stm->bindParam(":idprod", $idprod, PDO::PARAM_STR, 255);
        $stm->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
        $stm->execute();
        header("Location: index.php?registro=true");
    } catch (PDOException $e) {
        echo $e->getmessage();
    }
}

function mostrarCarrito($conexdb, $iduser)
{
    try {
        $query = "SELECT nombre_prod, cantidad FROM carrito WHERE idusuarios = :iduser";
        $stm = $conexdb->prepare($query);
        $stm->bindParam(":iduser", $iduser, PDO::PARAM_INT);
        $stm->execute();
        $productos = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    } catch (PDOException $e) {
        echo $e->getmessage();
    }
}

//----------------------------------------------------------------------------------

//el siguiente condicional y la siguiente funcion es para BORRAR PRODUCTOS DEL CARRITO que se borran de la base de datos en funcion del usuario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['borrarCarrito'])) {
    session_start();
    $iduser = $_SESSION['id'];
    $nombreProd = $_POST["nombreProd"];
    borrarCarrito($conexdb, $nombreProd, $iduser);
}

function borrarCarrito($conexdb, $nombreProd, $iduser)
{
    try {
        $query = "DELETE FROM carrito WHERE nombre_prod = :nombreProd AND idusuarios = :iduser";
        $stm = $conexdb->prepare($query);
        $stm->bindParam(":nombreProd", $nombreProd, PDO::PARAM_STR, 255);
        $stm->bindParam(":iduser", $_SESSION['id'], PDO::PARAM_INT);
        $stm->execute();
        header("Location: carrito.php?borrado=true");
    } catch (PDOException $e) {
        header("Location: index.php?error=true");
    }
}

//----------------------------------------------------------------------------------

//el siguiente condicional y la siguiente funcion es para MODIFICAR LA CANTIDAD DE PRODUCTOS DEL CARRITO si existe el producto en el carrito
function actualizarCarrito($conexdb, $nombreProd, $cantidad)
{
    try {
        $query = "UPDATE carrito SET cantidad = :cantidad WHERE nombre_prod = :nombreProd;";
        $stm = $conexdb->prepare($query);
        $stm->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
        $stm->bindParam(":nombreProd", $nombreProd, PDO::PARAM_STR, 255);
        $stm->execute();
        header("Location: carrito.php?modificado=true");
    } catch (PDOException $e) {
        header("Location: index.php?error=true");
    }
}
