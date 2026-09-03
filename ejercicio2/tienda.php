<?php
session_start();
require_once "inc/Producto.php";
require_once "inc/Carrito.php";
require_once "inc/catalogo.php";
require_once "inc/funciones.php";
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["nombre"])) {
    $nombre = trim($_POST["nombre"]);
    if ($nombre !== "") {
        setcookie("cliente", $nombre, time() + (7 * 24 * 60 * 60), "/");
        header("Location: tienda.php");
        exit();
    }
}
if (isset($_GET["tema"]) && ($_GET["tema"] === "claro" || $_GET["tema"] === "oscuro")) {
    setcookie("tema", $_GET["tema"], time() + (30 * 24 * 60 * 60), "/");
    header("Location: tienda.php");
    exit();
}
if (isset($_POST["agregar"])) {
    $catalogo = obtenerCatalogo();
    $producto = buscarProducto($catalogo, $_POST["agregar"]);
    if ($producto !== null && $producto->hayStock()) {
        $carrito = obtenerCarrito();
        $carrito->agregar($producto->getCodigo());
        guardarCarrito($carrito);
        $_SESSION["mensaje"] = "Producto agregado";
    }
    header("Location: tienda.php");
    exit();
}
if (!isset($_COOKIE["cliente"])) {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>TecnoStore USFX</title>
        <link rel="stylesheet" href="../estilos.css">
    </head>
    <body>
        <h1>TecnoStore USFX</h1>
        <h2>Identificación</h2>
        <form method="post">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
            <button type="submit">Ingresar</button>
        </form>
    </body>
    </html>
    <?php
    exit();
}
if (!isset($_SESSION["visita_contada"])) {
    $visitas = isset($_COOKIE["visitas"]) ? (int)$_COOKIE["visitas"] + 1 : 1;
    setcookie("visitas", $visitas, time() + (365 * 24 * 60 * 60), "/");
    $_SESSION["visita_contada"] = true;
    header("Location: tienda.php");
    exit();
}
$catalogo = obtenerCatalogo();
$tema = $_COOKIE["tema"] ?? "claro";
$mensaje = mostrarMensaje();
$carrito = obtenerCarrito();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="<?= htmlspecialchars($tema) === "oscuro" ? "oscuro" : "" ?>">
    <h1>TecnoStore USFX</h1>
    <p>Hola <?= htmlspecialchars($_COOKIE["cliente"]) ?></p>
    <p>Número de visita: <?= htmlspecialchars($_COOKIE["visitas"] ?? 1) ?></p>

    <nav>
        <a href="#">Tema claro</a> |
        <a href="#">Tema oscuro</a> |
        <a href="carrito.php">Ver carrito (<?= htmlspecialchars($carrito->cantidadTotal()) ?>)</a> |
        <a href="salir.php">Salir</a>
    </nav>
    <?php if ($mensaje !== ""): ?>
        <p class="mensaje"><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>
    <div class="galeria">
        <?php foreach ($catalogo as $producto): ?>
            <div class="tarjeta">
                <p>Código: <?= htmlspecialchars($producto->getCodigo()) ?></p>
                <p>Categoría: <?= htmlspecialchars($producto->getCategoria()) ?></p>
                <h3><?= htmlspecialchars($producto->getNombre()) ?></h3>
                <p>Precio: <?= htmlspecialchars($producto->getPrecio()) ?> Bs</p>
                <p>Stock: <?= htmlspecialchars($producto->getStock()) ?></p>
                <?php if ($producto->hayStock()): ?>
                    <form method="post">
                        <button type="submit" name="agregar" value="<?= htmlspecialchars($producto->getCodigo()) ?>">Agregar</button>
                    </form>
                <?php else: ?>
                    <p class="agotado">Agotado</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
