<?php

require_once "Producto.php";

function obtenerCatalogo() {
    $productos = [];
    $productos[] = new Producto("P01", "Teclado mecanico RGB", "Perifericos", 320.00, 12);
    $productos[] = new Producto("P02", "Mouse inalambrico", "Perifericos", 145.50, 8);
    $productos[] = new Producto("P03", "Monitor 24 pulgadas", "Pantallas", 1250.00, 5);
    $productos[] = new Producto("P04", "Monitor curvo 27 pulg.", "Pantallas", 2100.00, 0);
    $productos[] = new Producto("P05", "Disco solido 480 GB", "Almacenamiento", 380.00, 20);
    $productos[] = new Producto("P06", "Memoria USB 64 GB", "Almacenamiento", 75.00, 35);
    $productos[] = new Producto("P07", "Audifonos con microfono", "Perifericos", 210.00, 0);
    $productos[] = new Producto("P08", "Disco externo 1 TB", "Almacenamiento", 640.00, 6);

    return $productos;
}

function obtenerCategorias() {
    return [
        "Perifericos" => "Perifericos",
        "Pantallas" => "Pantallas",
        "Almacenamiento" => "Almacenamiento"
    ];
}

function filtrarPorCategoria(array $productos, $categoria) {
    if ($categoria == "") {
        return $productos;
    }

    $resultado = [];
    foreach ($productos as $p) {
        if ($p->getCategoria() == $categoria) {
            $resultado[] = $p;
        }
    }

    return $resultado;
}

function estadisticas(array $productos) {
    $precios = array_map(function ($p) {
        return $p->getPrecio();
    }, $productos);

    $stocks = array_map(function ($p) {
        return $p->getStock();
    }, $productos);

    $total = count($productos);
    $stock = array_sum($stocks);
    $promedio = $total > 0 ? array_sum($precios) / $total : 0;
    $mayor = $total > 0 ? max($precios) : 0;
    $menor = $total > 0 ? min($precios) : 0;

    return [
        "total" => $total,
        "stock" => $stock,
        "promedio" => round($promedio, 2),
        "mayor" => $mayor,
        "menor" => $menor
    ];
}

function contarPorCategoria(array $productos) {
    $conteo = [];
    foreach ($productos as $p) {
        $categoria = $p->getCategoria();
        if (isset($conteo[$categoria])) {
            $conteo[$categoria]++;
        } else {
            $conteo[$categoria] = 1;
        }
    }

    return $conteo;
}
