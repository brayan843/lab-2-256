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
        return round($this->precio - ($this->precio * $porcentaje / 100), 2);
    }
    public function hayStock() {
        return $this->stock > 0;
    }
    public function mostrarTarjeta() {
        $codigo = htmlspecialchars($this->codigo);
        $categoria = htmlspecialchars($this->categoria);
        $nombre = htmlspecialchars($this->nombre);
        $precio = number_format($this->precio, 2);
        $descuento = number_format($this->getPrecioConDescuento(), 2);
        $stock = htmlspecialchars($this->stock);
        $agotado = $this->hayStock() ? "" : '<p class="agotado">Agotado</p>';
        return "<div class=\"tarjeta\">
            <p>Codigo: $codigo</p>
            <p>Categoria: $categoria</p>
            <h3>$nombre</h3>
            <p>Precio: $precio</p>
            <p>Precio con 10 % de descuento: $descuento</p>
            <p>Stock: $stock</p>
            $agotado
        </div>";
    }
}
?>
