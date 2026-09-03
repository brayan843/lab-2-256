<?php
session_start();
require_once "inc/Producto.php";
require_once "inc/Carrito.php";
require_once "inc/catalogo.php";
require_once "inc/funciones.php";
if (!isset($_COOKIE["cliente"])) {
    header("Location: tienda.php");
    exit();
}
$catalogo = obtenerCatalogo();
$carrito = obtenerCarrito();
if (isset($_GET["quitar"])) {
    $carrito->quitar($_GET["quitar"]);
    guardarCarrito($carrito);
    $_SESSION["mensaje"] = "Producto quitado del carrito.";
    header("Location: carrito.php");
    exit();
}
if (isset($_GET["vaciar"])) {
    $carrito->vaciar();
    guardarCarrito($carrito);
    $_SESSION["mensaje"] = "Carrito vacio";
    header("Location: carrito.php");
    exit();
}
$mensaje = mostrarMensaje();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito--USFX</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="<?= isset($_COOKIE["tema"]) && $_COOKIE["tema"] === "oscuro" ? "oscuro" : "" ?>">
    <h1>Carrito de compras</h1>
    <p>Cliente: <?= htmlspecialchars($_COOKIE["cliente"]) ?></p>
    <nav>
        <a href="tienda.php">Volver a la tienda</a> |
        <a href="carrito.php?vaciar=1">Vaciar carrito</a> |
        <a href="salir.php">Salir</a>
    </nav>
    <?php if ($mensaje !== ""): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
    <?php if ($carrito->estaVacio()): ?>
        <p>El carrito esta vacio.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
                <th>Accion</th>
            </tr>
            <?php foreach ($carrito->getItems() as $codigo => $cantidad): ?>
                <?php $producto = buscarProducto($catalogo, $codigo); ?>
                <?php if ($producto !== null): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto->getNombre()) ?></td>
                        <td><?= htmlspecialchars($cantidad) ?></td>
                        <td><?= htmlspecialchars($producto->getPrecio()) ?> Bs</td>
                        <td><?= htmlspecialchars(round($producto->getPrecio() * $cantidad, 2)) ?> Bs</td>
                        <td><a href="carrito.php?quitar=<?= urlencode($codigo) ?>">Quitar</a></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <th colspan="3">Total</th>
                <th><?= htmlspecialchars($carrito->total($catalogo)) ?> Bs</th>
                <th></th>
            </tr>
        </table>
    <?php endif; ?>

    <h2>Comprobacion de sesion</h2>
    <p>session_id(): <?= htmlspecialchars(session_id()) ?></p>
    <pre><?php print_r($_SESSION); ?></pre>

    <h2>Comprobacion de cookies</h2>
    <pre><?php print_r($_COOKIE); ?></pre>
</body>
</html>
