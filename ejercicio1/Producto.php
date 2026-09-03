<?php

class Producto {
    private $codigo;
    private $nombre;
    private $categoria;
    private $precio;
    private $stock;

    public function __construct($codigo, $nombre, $categoria, $precio, $stock) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function getCodigo() {
        return $this->codigo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCategoria() {
        return $this->categoria;
    }

    public function getPrecio() {
        return $this->precio;
    }

    public function getStock() {
        return $this->stock;
    }

    public function getPrecioConDescuento($porcentaje = 10) {
        $descuento = $this->precio * ($porcentaje / 100);
        return round($this->precio - $descuento, 2);
    }

    public function hayStock() {
        return $this->stock > 0;
    }

    public function mostrarTarjeta() {
        $etiquetaStock = "Stock disponible: " . $this->stock . " unidades";
        if (!$this->hayStock()) {
            $etiquetaStock = '<span class="agotado">AGOTADO</span>';
        }

        $html = '<div class="tarjeta">';
        $html .= '<div class="codigo">' . htmlspecialchars($this->codigo) . '</div>';
        $html .= '<div class="categoria">' . htmlspecialchars($this->categoria) . '</div>';
        $html .= '<div>' . htmlspecialchars($this->nombre) . '</div>';
        $html .= '<div class="precio">Bs ' . number_format($this->precio, 2) . '</div>';
        $html .= '<div class="descuento">Con 10% de descuento: Bs ' . number_format($this->getPrecioConDescuento(), 2) . '</div>';
        $html .= '<div class="stock">' . $etiquetaStock . '</div>';
        $html .= '</div>';

        return $html;
    }
}
