<template>
  <div class="min-h-screen bg-slate-50 text-slate-800 antialiased font-sans">
    <!-- Navbar Premium -->
    <header class="bg-white border-b border-slate-100 sticky top-0 z-30">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="bg-indigo-600 text-white p-2.5 rounded-xl shadow-md shadow-indigo-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
          </div>
          <div>
            <h1 class="text-xl font-bold text-slate-900 leading-none">VentasPro</h1>
            <p class="text-xs text-slate-400 font-medium">Gestión de Inventario y Ventas</p>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full mr-1.5 animate-pulse"></span>
            Sistema en Línea
          </span>
        </div>
      </div>
    </header>

    <!-- Contenido Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Fila de Estadísticas Rápidas -->
      <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Tarjeta: Total Productos -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
          <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
          </div>
          <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Productos Totales</p>
            <h3 class="text-2xl font-black text-slate-800">{{ productos.length }}</h3>
          </div>
        </div>

        <!-- Tarjeta: Total Ventas -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
          <div class="p-3 bg-violet-50 text-violet-600 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ventas Realizadas</p>
            <h3 class="text-2xl font-black text-slate-800">{{ ventas.length }}</h3>
          </div>
        </div>

        <!-- Tarjeta: Facturación Total -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
          <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ingresos Totales</p>
            <h3 class="text-2xl font-black text-slate-800">${{ totalFacturado }}</h3>
          </div>
        </div>
      </section>

      <!-- Layout Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Columna Izquierda: Formulario -->
        <section class="lg:col-span-1 space-y-6">
          <FormularioVenta 
            :productos="productos" 
            @venta-registrada="actualizarDatos" 
          />
        </section>

        <!-- Columna Derecha: Listados -->
        <section class="lg:col-span-2 space-y-8">
          <!-- Inventario -->
          <ListadoProductos 
            :productos="productos" 
            :cargando="cargandoProductos" 
          />

          <!-- Historial de Ventas -->
          <ListadoVentas 
            :ventas="ventas" 
            :cargando="cargandoVentas" 
          />
        </section>
      </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 mt-16 py-6 text-center text-xs font-medium text-slate-400">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p>Sistema de Ventas &copy; 2026 - Universidad. Todos los derechos reservados.</p>
      </div>
    </footer>
  </div>
</template>

<script>
import FormularioVenta from './components/FormularioVenta.vue';
import ListadoProductos from './components/ListadoProductos.vue';
import ListadoVentas from './components/ListadoVentas.vue';
import api from './services/api';

export default {
  name: 'App',
  components: {
    FormularioVenta,
    ListadoProductos,
    ListadoVentas
  },
  data() {
    return {
      productos: [],
      ventas: [],
      cargandoProductos: false,
      cargandoVentas: false
    }
  },
  computed: {
    totalFacturado() {
      const suma = this.ventas.reduce((acc, current) => acc + parseFloat(current.total), 0);
      return suma.toFixed(2);
    }
  },
  methods: {
    async fetchProductos() {
      this.cargandoProductos = true;
      try {
        const response = await api.getProductos();
        this.productos = response.data;
      } catch (error) {
        console.error('Error al cargar productos:', error);
      } finally {
        this.cargandoProductos = false;
      }
    },
    async fetchVentas() {
      this.cargandoVentas = true;
      try {
        const response = await api.getVentas();
        this.ventas = response.data;
      } catch (error) {
        console.error('Error al cargar ventas:', error);
      } finally {
        this.cargandoVentas = false;
      }
    },
    actualizarDatos() {
      // Recargamos ambas listas cuando ocurre una venta
      this.fetchProductos();
      this.fetchVentas();
    }
  },
  mounted() {
    // Cargamos los datos iniciales
    this.fetchProductos();
    this.fetchVentas();
  }
}
</script>
