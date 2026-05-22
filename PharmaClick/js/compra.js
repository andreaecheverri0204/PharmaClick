class Compra {
    constructor() {
        this.articulos = JSON.parse(localStorage.getItem('carrito_pharmaclick')) || [];
    }

    obtenerArticulos() {
        return this.articulos;
    }

    actualizarCantidad(id, nuevaCantidad) {
        this.articulos = this.articulos.map(producto => {
            if (producto.id == id) {
                producto.cantidad = parseInt(nuevaCantidad);
            }
            return producto;
        });
        this.guardarStorage();
    }

    eliminarArticulo(id) {
        this.articulos = this.articulos.filter(producto => producto.id != id);
        this.guardarStorage();
    }

    vaciar() {
        this.articulos = [];
        this.guardarStorage();
    }

    guardarStorage() {
        localStorage.setItem('carrito_pharmaclick', JSON.stringify(this.articulos));
    }

    calcularTotal() {
        return this.articulos.reduce((sum, prod) => sum + (prod.precio * prod.cantidad), 0);
    }

    calcularSubtotal(tasaImpuesto = 0.18) {
        return this.calcularTotal() / (1 + tasaImpuesto);
    }

    calcularImpuesto(tasaImpuesto = 0.18) {
        return this.calcularTotal() - this.calcularSubtotal(tasaImpuesto);
    }

    calcularCambio(pagoCon) {
        const total = this.calcularTotal();
        if (isNaN(pagoCon) || pagoCon < total) return 0;
        return pagoCon - total;
    }
}