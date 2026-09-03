<?php
function obtenerCarrito() {
    if (isset($_SESSION["carrito"])) {
        return unserialize($_SESSION["carrito"]);
    }
    return new Carrito();
}
function guardarCarrito($carrito) {
    $_SESSION["carrito"] = serialize($carrito);
}
function mostrarMensaje() {
    if (isset($_SESSION["mensaje"])) {
        $mensaje = $_SESSION["mensaje"];
        unset($_SESSION["mensaje"]);
        return $mensaje;
    }
    return "";
}
?>