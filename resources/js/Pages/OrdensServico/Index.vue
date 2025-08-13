<template>
  <div class="min-h-screen bg-gradient-to-br from-purple-900 via-blue-900 to-purple-800">
    <!-- Header -->
    <div class="bg-white/10 backdrop-blur-md border-b border-white/20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
          <div class="flex items-center space-x-3">
            <button @click="$router.back()" class="text-white hover:text-purple-200 transition-colors">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
              </svg>
            </button>
            <div>
              <h1 class="text-2xl font-bold text-white">Ordens de Serviço</h1>
              <p class="text-purple-200">Gerencie todas as ordens de serviço</p>
            </div>
          </div>
          <button
            @click="novaOrdem"
            class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors flex items-center"
          >
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Nova Ordem
          </button>
        </div>
      </div>
    </div>

    <!-- Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white/10 backdrop-blur-md rounded-lg border border-white/20 p-6">
        <!-- Loading -->
        <div v-if="loading" class="text-center py-8">
          <div class="text-white">Carregando ordens de serviço...</div>
        </div>

        <!-- Empty State -->
        <div v-else-if="ordens.length === 0" class="text-center py-8">
          <div class="text-white text-lg mb-4">Nenhuma ordem de serviço encontrada</div>
          <button
            @click="novaOrdem"
            class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors"
          >
            Criar Primeira Ordem
          </button>
        </div>

        <!-- Orders List -->
        <div v-else class="space-y-4">
          <div
            v-for="ordem in ordens"
            :key="ordem.id"
            class="bg-white/5 backdrop-blur-sm rounded-lg border border-white/10 p-6 hover:bg-white/10 transition-colors"
          >
            <div class="flex justify-between items-start">
              <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                  <h3 class="text-lg font-semibold text-white">{{ ordem.numero }}</h3>
                  <span
                    :class="getStatusColor(ordem.status)"
                    class="px-2 py-1 rounded-full text-xs font-medium"
                  >
                    {{ getStatusLabel(ordem.status) }}
                  </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                  <div>
                    <span class="text-purple-200">Cliente:</span>
                    <span class="text-white ml-2">{{ ordem.cliente?.nome || 'N/A' }}</span>
                  </div>
                  <div>
                    <span class="text-purple-200">Equipamento:</span>
                    <span class="text-white ml-2">{{ ordem.equipamento }}</span>
                  </div>
                  <div>
                    <span class="text-purple-200">Valor Total:</span>
                    <span class="text-white ml-2">R$ {{ formatCurrency(ordem.valor_total) }}</span>
                  </div>
                </div>

                <div class="mt-2 text-sm text-gray-300">
                  <span>Entrada: {{ formatDate(ordem.data_entrada) }}</span>
                  <span v-if="ordem.data_saida" class="ml-4">Saída: {{ formatDate(ordem.data_saida) }}</span>
                </div>
              </div>

              <div class="flex space-x-2">
                <button
                  @click="visualizarOrdem(ordem.id)"
                  class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 transition-colors"
                >
                  Visualizar
                </button>
                <button
                  @click="imprimirOrdem(ordem.id)"
                  class="px-3 py-1 bg-green-600 text-white rounded text-sm hover:bg-green-700 transition-colors flex items-center"
                >
                  <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                  </svg>
                  Imprimir
                </button>
                <button
                  @click="editarOrdem(ordem.id)"
                  class="px-3 py-1 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 transition-colors"
                >
                  Editar
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'

const loading = ref(true)
const ordens = ref([])

onMounted(async () => {
  await carregarOrdens()
})

async function carregarOrdens() {
  try {
    const response = await fetch('/ordens-servico')
    if (response.ok) {
      ordens.value = await response.json()
    }
  } catch (error) {
    console.error('Erro ao carregar ordens:', error)
  } finally {
    loading.value = false
  }
}

function getStatusColor(status) {
  const colors = {
    'pendente': 'bg-yellow-500 text-yellow-900',
    'em_andamento': 'bg-blue-500 text-blue-900',
    'concluida': 'bg-green-500 text-green-900',
    'cancelada': 'bg-red-500 text-red-900'
  }
  return colors[status] || 'bg-gray-500 text-gray-900'
}

function getStatusLabel(status) {
  const labels = {
    'pendente': 'Pendente',
    'em_andamento': 'Em Andamento',
    'concluida': 'Concluída',
    'cancelada': 'Cancelada'
  }
  return labels[status] || status
}

function formatCurrency(value) {
  return new Intl.NumberFormat('pt-BR', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  }).format(value || 0)
}

function formatDate(date) {
  if (!date) return 'N/A'
  return new Date(date).toLocaleDateString('pt-BR')
}

function novaOrdem() {
  router.visit('/ordens-servico/create')
}

function visualizarOrdem(id) {
  router.visit(`/ordens-servico/${id}`)
}

function imprimirOrdem(id) {
  window.open(`/ordens-servico/${id}/imprimir`, '_blank')
}

function editarOrdem(id) {
  router.visit(`/ordens-servico/${id}/edit`)
}
</script>
