<?php
require_once "catalogo.php";

$categoriaSeleccionada = $_GET["categoria"] ?? "";

$catalogoCompleto = obtenerCatalogo();
$categorias = obtenerCategorias();

if ($categoriaSeleccionada != "" && !isset($categorias[$categoriaSeleccionada])) {
    $categoriaSeleccionada = "";
}

$productosFiltrados = filtrarPorCategoria($catalogoCompleto, $categoriaSeleccionada);
$stats = estadisticas($productosFiltrados);
$conteoCategoriasCompleto = contarPorCategoria($catalogoCompleto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Catalogo</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>

<div class="header">
    <h1>TecnoStore USFX - Catalogo</h1>
    <p>Ejercicio 1 - Clases, objetos y arreglos en PHP</p>
</div>

<div class="contenedor">

    <h2>1. Filtro de productos</h2>
    <form method="get">
        <label>Categoria</label><br>
        <select name="categoria">
            <option value="" <?php if ($categoriaSeleccionada == "") echo "selected"; ?>>-- Todas las categorias --</option>
            <?php foreach ($categorias as $clave => $texto) { ?>
                <option value="<?php echo htmlspecialchars($clave); ?>" <?php if ($categoriaSeleccionada == $clave) echo "selected"; ?>>
                    <?php echo htmlspecialchars($texto); ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">Filtrar</button>
        <p>URL generada: <?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?></p>
    </form>

    <h2>2. Productos (<?php echo count($productosFiltrados); ?> encontrados)</h2>

    <?php if (count($productosFiltrados) == 0) { ?>
        <p>No hay productos para esta categoria.</p>
    <?php } else { ?>
        <div class="galeria">
            <?php foreach ($productosFiltrados as $p) {
                echo $p->mostrarTarjeta();
            } ?>
        </div>
    <?php } ?>

    <h2>3. Resumen calculado con funciones de arreglo</h2>
    <table>
        <tr>
            <th>Indicador</th>
            <th>Valor</th>
        </tr>
        <tr>
            <td>Productos listados</td>
            <td><?php echo $stats["total"]; ?></td>
        </tr>
        <tr>
            <td>Unidades en stock</td>
            <td><?php echo $stats["stock"]; ?></td>
        </tr>
        <tr>
            <td>Precio promedio</td>
            <td>Bs <?php echo number_format($stats["promedio"], 2); ?></td>
        </tr>
        <tr>
            <td>Precio mas alto</td>
            <td>Bs <?php echo number_format($stats["mayor"], 2); ?></td>
        </tr>
        <tr>
            <td>Precio mas bajo</td>
            <td>Bs <?php echo number_format($stats["menor"], 2); ?></td>
        </tr>
        <tr>
            <td>Categorias del catalogo completo</td>
            <td><?php echo count($conteoCategoriasCompleto); ?></td>
        </tr>
    </table>

    <h3>Contenido del arreglo $_GET</h3>
    <pre><?php print_r($_GET); ?></pre>

</div>

<div class="footer">
    SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga
</div>

</body>
</html>
