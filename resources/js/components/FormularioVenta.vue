<template>
  <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2 mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      Registrar Nueva Venta
    </h2>

    <!-- Alertas de éxito y error -->
    <div v-if="mensajeExito" class="mb-4 p-3 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-lg text-sm font-medium flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      {{ mensajeExito }}
    </div>

    <div v-if="mensajeError" class="mb-4 p-3 bg-rose-50 border border-rose-100 text-rose-800 rounded-lg text-sm font-medium flex items-center gap-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-rose-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
      {{ mensajeError }}
    </div>

    <form @submit.prevent="guardarVenta" class="space-y-5">
      <!-- Selección de Producto -->
      <div>
        <label for="producto" class="block text-sm font-semibold text-slate-700 mb-1.5">Seleccionar Producto</label>
        <div class="relative">
          <select 
            id="producto" 
            v-model="formulario.producto_id" 
            @change="alCambiarProducto"
            class="w-full bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm appearance-none"
            :disabled="enviando"
          >
            <option value="" disabled>-- Seleccione un producto --</option>
            <option 
              v-for="prod in productos" 
              :key="prod.id" 
              :value="prod.id"
            >
              {{ prod.nombre }} - ${{ parseFloat(prod.precio).toFixed(2) }} (Disponibles: {{ prod.stock }})
            </option>
          </select>
          <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400">
            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
              <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
            </svg>
          </div>
        </div>
      </div>

      <!-- Cantidad Vendida -->
      <div>
        <label for="cantidad" class="block text-sm font-semibold text-slate-700 mb-1.5">Cantidad a Vender</label>
        <input 
          id="cantidad" 
          type="number" 
          v-model.number="formulario.cantidad" 
          min="1" 
          :max="productoSeleccionado ? productoSeleccionado.stock : ''"
          placeholder="Ingrese la cantidad"
          class="w-full bg-slate-50 border border-slate-200 text-slate-700 py-2.5 px-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all text-sm"
          :disabled="!formulario.producto_id || enviando"
        />
        <!-- Error local de stock -->
        <p v-if="errorStock" class="mt-1.5 text-xs font-semibold text-rose-500">
          * {{ errorStock }}
        </p>
      </div>

      <!-- Detalle y Cálculo en tiempo real -->
      <div v-if="productoSeleccionado" class="bg-indigo-50/50 rounded-xl p-4 border border-indigo-50/30">
        <div class="flex justify-between text-sm text-slate-600 mb-1.5">
          <span>Precio Unitario:</span>
          <span class="font-semibold text-slate-800">${{ parseFloat(productoSeleccionado.precio).toFixed(2) }}</span>
        </div>
        <div class="flex justify-between text-sm text-slate-600 mb-1.5">
          <span>Cantidad:</span>
          <span class="font-semibold text-slate-800">{{ formulario.cantidad || 0 }}</span>
        </div>
        <hr class="border-indigo-100 my-2">
        <div class="flex justify-between items-center text-indigo-900">
          <span class="font-bold text-sm uppercase tracking-wider">Total a Pagar:</span>
          <span class="text-xl font-extrabold text-indigo-700">${{ totalCalculado }}</span>
        </div>
      </div>

      <!-- Botón de Envío -->
      <button 
        type="submit" 
        :disabled="!esFormularioValido || enviando"
        class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:bg-slate-200 disabled:text-slate-400 text-white font-semibold py-2.5 px-4 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all text-sm flex items-center justify-center gap-2 cursor-pointer"
      >
        <span v-if="enviando" class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></span>
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        {{ enviando ? 'Registrando venta...' : 'Registrar Venta' }}
      </button>
    </form>
  </div>
</template>

<script>
import api from '../services/api';

export default {
  name: 'FormularioVenta',
  props: {
    productos: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      formulario: {
        producto_id: '',
        cantidad: ''
      },
      enviando: false,
      mensajeExito: '',
      mensajeError: ''
    }
  },
  computed: {
    productoSeleccionado() {
      if (!this.formulario.producto_id) return null;
      return this.productos.find(p => p.id === this.formulario.producto_id) || null;
    },
    errorStock() {
      if (!this.productoSeleccionado) return '';
      if (!this.formulario.cantidad) return '';
      if (this.formulario.cantidad <= 0) return 'La cantidad debe ser mayor a 0.';
      if (this.formulario.cantidad > this.productoSeleccionado.stock) {
        return `Stock insuficiente. Solo quedan ${this.productoSeleccionado.stock} unidades en existencia.`;
      }
      return '';
    },
    totalCalculado() {
      if (!this.productoSeleccionado || !this.formulario.cantidad || this.formulario.cantidad <= 0) {
        return '0.00';
      }
      return (parseFloat(this.productoSeleccionado.precio) * parseInt(this.formulario.cantidad)).toFixed(2);
    },
    esFormularioValido() {
      return (
        this.formulario.producto_id && 
        this.formulario.cantidad && 
        this.formulario.cantidad > 0 && 
        !this.errorStock
      );
    }
  },
  methods: {
    alCambiarProducto() {
      // Reiniciamos cantidad por defecto al cambiar el producto
      this.formulario.cantidad = 1;
      this.mensajeError = '';
      this.mensajeExito = '';
    },
    async guardarVenta() {
      if (!this.esFormularioValido) return;

      this.enviando = true;
      this.mensajeError = '';
      this.mensajeExito = '';

      try {
        const payload = {
          producto_id: this.formulario.producto_id,
          cantidad: this.formulario.cantidad
        };

        const response = await api.registrarVenta(payload);

        if (response.data.success) {
          this.mensajeExito = response.data.message || 'Venta registrada con éxito.';
          
          // Emitimos evento al componente padre indicando que se ha registrado una venta
          this.$emit('venta-registrada');

          // Reseteamos el formulario
          this.formulario.producto_id = '';
          this.formulario.cantidad = '';
        } else {
          this.mensajeError = response.data.message || 'Ocurrió un error al procesar la venta.';
        }
      } catch (error) {
        if (error.response && error.response.data && error.response.data.message) {
          this.mensajeError = error.response.data.message;
        } else {
          this.mensajeError = 'Error de red. No se pudo conectar con el servidor.';
        }
      } finally {
        this.enviando = false;
      }
    }
  }
}
</script>
