<?php
/*cuando le demos al boton de cerrar sesion este nos enviará a esta pagina donde ejecutara la siguiente condicion.
para poder finalizar sesion y BORRAR LA COOKIE he sacado este codigo de la documentacion oficial de PHP */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_start();
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
