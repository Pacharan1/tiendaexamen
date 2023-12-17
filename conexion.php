<?php
try {
    $conexion = "mysql:host=localhost;dbname=tiendaexamen";
    $conexdb = new PDO($conexion, "root", "sF@94pkgPB,");
    $conexdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getmessage(); //si no nos entra en la BBDD, nos sacaria un error
}

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
