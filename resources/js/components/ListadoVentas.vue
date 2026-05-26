<template>
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-violet-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>
        Registro de Ventas
      </h2>
      <span class="px-2.5 py-1 text-xs font-semibold bg-violet-50 text-violet-600 rounded-full">
        {{ ventas.length }} Transacciones
      </span>
    </div>

    <!-- Spinner de carga -->
    <div v-if="cargando" class="flex flex-col items-center justify-center py-8">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-violet-500"></div>
      <p class="text-sm text-slate-400 mt-2">Cargando historial de ventas...</p>
    </div>

    <!-- Tabla de ventas -->
    <div v-else class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase">
            <th class="py-3 px-4 font-semibold text-slate-500">Folio</th>
            <th class="py-3 px-4 font-semibold text-slate-500">Producto</th>
            <th class="py-3 px-4 font-semibold text-slate-500 text-center">Cantidad</th>
            <th class="py-3 px-4 font-semibold text-slate-500 text-right">Total</th>
            <th class="py-3 px-4 font-semibold text-slate-500 text-right">Fecha y Hora</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          <tr v-for="venta in ventas" :key="venta.id" class="hover:bg-slate-50/50 transition-colors">
            <td class="py-3.5 px-4 text-sm font-medium text-slate-400">#VT-{{ String(venta.id).padStart(4, '0') }}</td>
            <td class="py-3.5 px-4 text-sm font-semibold text-slate-700">
              {{ venta.producto ? venta.producto.nombre : 'Producto no disponible' }}
            </td>
            <td class="py-3.5 px-4 text-sm font-medium text-slate-600 text-center">{{ venta.cantidad }}</td>
            <td class="py-3.5 px-4 text-sm font-bold text-violet-600 text-right">${{ parseFloat(venta.total).toFixed(2) }}</td>
            <td class="py-3.5 px-4 text-sm text-slate-500 text-right">
              {{ formatFecha(venta.created_at) }}
            </td>
          </tr>
          <tr v-if="ventas.length === 0">
            <td colspan="5" class="py-8 text-center text-sm text-slate-400">
              No se han registrado ventas hoy.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ListadoVentas',
  props: {
    ventas: {
      type: Array,
      required: true
    },
    cargando: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    formatFecha(fechaString) {
      if (!fechaString) return '';
      const fecha = new Date(fechaString);
      return fecha.toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      }) + ' ' + fecha.toLocaleTimeString('es-ES', {
        hour: '2-digit',
        minute: '2-digit'
      });
    }
  }
}
</script>
