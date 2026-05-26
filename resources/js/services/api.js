import axios from 'axios';

// Instancia de axios configurada para consumir nuestra API REST de Laravel
const api = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
});

export default {
    // Obtener todos los productos
    getProductos() {
        return api.get('/productos');
    },

    // Obtener todas las ventas registradas
    getVentas() {
        return api.get('/ventas');
    },

    // Registrar una venta
    registrarVenta(datos) {
        return api.post('/ventas', datos);
    }
};
