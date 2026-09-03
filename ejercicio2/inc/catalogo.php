<?php
require_once "Producto.php";
function obtenerCatalogo() {
    return [
        new Producto("001", "producto1", "Computación", 5000, 5),
        new Producto("002", "producto2", "Periféricos", 100, 12),
        new Producto("003", "producto3", "Periféricos", 300, 0),
        new Producto("004", "producto4", "Computación", 1000, 4),
        new Producto("005", "producto5", "Almacenamiento", 700, 8),
        new Producto("006", "producto6", "Almacenamiento", 100, 0)
    ];
}
function buscarProducto(array $catalogo, $codigo) {
    foreach ($catalogo as $producto) {
        if ($producto->getCodigo() === $codigo) {
            return $producto;
        }
    }
    return null;
}
?>
