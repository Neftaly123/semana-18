<template>
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
    <div class="flex items-center justify-between mb-4">
      <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
        Inventario de Productos
      </h2>
      <span class="px-2.5 py-1 text-xs font-semibold bg-indigo-50 text-indigo-600 rounded-full">
        {{ productos.length }} Productos
      </span>
    </div>

    <!-- Spinner de carga -->
    <div v-if="cargando" class="flex flex-col items-center justify-center py-8">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div>
      <p class="text-sm text-slate-400 mt-2">Cargando inventario...</p>
    </div>

    <!-- Tabla de productos -->
    <div v-else class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase">
            <th class="py-3 px-4 font-semibold text-slate-500">ID</th>
            <th class="py-3 px-4 font-semibold text-slate-500">Nombre</th>
            <th class="py-3 px-4 font-semibold text-slate-500">Precio</th>
            <th class="py-3 px-4 font-semibold text-slate-500 text-right">Stock</th>
            <th class="py-3 px-4 font-semibold text-slate-500 text-center">Estado</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
          <tr v-for="producto in productos" :key="producto.id" class="hover:bg-slate-50/50 transition-colors">
            <td class="py-3.5 px-4 text-sm font-medium text-slate-400">#{{ producto.id }}</td>
            <td class="py-3.5 px-4 text-sm font-semibold text-slate-700">{{ producto.nombre }}</td>
            <td class="py-3.5 px-4 text-sm font-medium text-slate-600">${{ parseFloat(producto.precio).toFixed(2) }}</td>
            <td class="py-3.5 px-4 text-sm font-bold text-slate-800 text-right">{{ producto.stock }}</td>
            <td class="py-3.5 px-4 text-center">
              <span 
                v-if="producto.stock > 10" 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100"
              >
                Disponible
              </span>
              <span 
                v-else-if="producto.stock > 0" 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100"
              >
                Bajo Stock
              </span>
              <span 
                v-else 
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-50 text-rose-700 border border-rose-100"
              >
                Agotado
              </span>
            </td>
          </tr>
          <tr v-if="productos.length === 0">
            <td colspan="5" class="py-8 text-center text-sm text-slate-400">
              No hay productos registrados.
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ListadoProductos',
  props: {
    productos: {
      type: Array,
      required: true
    },
    cargando: {
      type: Boolean,
      default: false
    }
  }
}
</script>
