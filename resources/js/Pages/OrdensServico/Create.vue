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
              <h1 class="text-2xl font-bold text-white">Nova Ordem de Serviço</h1>
              <p class="text-purple-200">Criar nova ordem de serviço</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Form -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white/10 backdrop-blur-md rounded-lg border border-white/20 p-6">
        <form @submit.prevent="submitForm" class="space-y-6">
          <!-- Informações Básicas -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-white mb-2">Número da Ordem</label>
              <input
                v-model="form.numero"
                type="text"
                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
                placeholder="Ex: OS-2024-001"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-white mb-2">Cliente</label>
              <select
                v-model="form.cliente_id"
                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-purple-500"
                required
              >
                <option value="">Selecione um cliente</option>
                <option v-for="cliente in clientes" :key="cliente.id" :value="cliente.id">
                  {{ cliente.nome }}
                </option>
              </select>
            </div>
          </div>

          <!-- Equipamento -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label class="block text-sm font-medium text-white mb-2">Equipamento</label>
              <input
                v-model="form.equipamento"
                type="text"
                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
                placeholder="Ex: Smartphone"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-white mb-2">Marca</label>
              <input
                v-model="form.marca"
                type="text"
                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
                placeholder="Ex: Samsung"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-white mb-2">Modelo</label>
              <input
                v-model="form.modelo"
                type="text"
                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
                placeholder="Ex: Galaxy S21"
                required
              />
            </div>
          </div>

          <div>
            <label class="block text-sm font-medium text-white mb-2">Número de Série</label>
            <input
              v-model="form.numero_serie"
              type="text"
              class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
              placeholder="Opcional"
            />
          </div>

          <!-- Defeito -->
          <div>
            <label class="block text-sm font-medium text-white mb-2">Defeito Relatado</label>
            <textarea
              v-model="form.defeito_relatado"
              rows="3"
              class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
              placeholder="Descreva o defeito relatado pelo cliente"
              required
            ></textarea>
          </div>

          <!-- Valores -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label class="block text-sm font-medium text-white mb-2">Valor Mão de Obra</label>
              <input
                v-model="form.valor_mao_obra"
                type="number"
                step="0.01"
                min="0"
                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
                placeholder="0.00"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-white mb-2">Valor Peças</label>
              <input
                v-model="form.valor_pecas"
                type="number"
                step="0.01"
                min="0"
                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
                placeholder="0.00"
                required
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-white mb-2">Valor Total</label>
              <input
                v-model="form.valor_total"
                type="number"
                step="0.01"
                min="0"
                class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
                placeholder="0.00"
                required
              />
            </div>
          </div>

          <!-- Garantia -->
          <div>
            <label class="block text-sm font-medium text-white mb-2">Dias de Garantia</label>
            <input
              v-model="form.garantia_dias"
              type="number"
              min="0"
              class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
              placeholder="Ex: 90"
            />
          </div>

          <!-- Observações -->
          <div>
            <label class="block text-sm font-medium text-white mb-2">Observações</label>
            <textarea
              v-model="form.observacoes"
              rows="3"
              class="w-full px-3 py-2 bg-white/10 border border-white/20 rounded-md text-white placeholder-purple-200 focus:outline-none focus:ring-2 focus:ring-purple-500"
              placeholder="Observações adicionais"
            ></textarea>
          </div>

          <!-- Botões -->
          <div class="flex justify-end space-x-4 pt-6">
            <button
              type="button"
              @click="$router.back()"
              class="px-6 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors"
            >
              Cancelar
            </button>
            <button
              type="button"
              @click="visualizarPDF"
              class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors flex items-center"
            >
              <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
              </svg>
              Visualizar PDF
            </button>
            <button
              type="submit"
              :disabled="loading"
              class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 disabled:opacity-50 transition-colors"
            >
              {{ loading ? 'Criando...' : 'Criar Ordem' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { router } from '@inertiajs/vue3'

const loading = ref(false)
const clientes = ref([])

const form = reactive({
  numero: '',
  cliente_id: '',
  tecnico_id: null,
  equipamento: '',
  marca: '',
  modelo: '',
  numero_serie: '',
  defeito_relatado: '',
  defeito_encontrado: '',
  solucao_aplicada: '',
  pecas_utilizadas: '',
  valor_mao_obra: 0,
  valor_pecas: 0,
  valor_total: 0,
  status: 'pendente',
  data_entrada: new Date().toISOString().split('T')[0],
  data_saida: '',
  garantia_dias: 90,
  observacoes: ''
})

onMounted(async () => {
  await carregarClientes()
})

async function carregarClientes() {
  try {
    const response = await fetch('/api/clientes')
    if (response.ok) {
      clientes.value = await response.json()
    }
  } catch (error) {
    console.error('Erro ao carregar clientes:', error)
  }
}

async function submitForm() {
  loading.value = true

  try {
    const response = await fetch('/ordens-servico', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify(form)
    })

    if (response.ok) {
      const data = await response.json()

      // Mostrar modal de sucesso com opção de imprimir
      if (confirm('Ordem de serviço criada com sucesso! Deseja imprimir agora?')) {
        // Abrir PDF em nova aba
        window.open(`/ordens-servico/${data.id}/imprimir`, '_blank')
      }

      router.visit('/dashboard')
    } else {
      const error = await response.json()
      alert('Erro ao criar ordem de serviço: ' + (error.message || 'Erro desconhecido'))
    }
  } catch (error) {
    console.error('Erro:', error)
    alert('Erro ao criar ordem de serviço')
  } finally {
    loading.value = false
  }
}

const visualizarPDF = () => {
  // Verificar se há dados mínimos para visualizar
  if (!form.numero || !form.cliente_id || !form.equipamento) {
    alert('Preencha pelo menos o número da ordem, cliente e equipamento para visualizar o PDF')
    return
  }

  // Criar dados temporários para visualização
  const dadosTemp = {
    numero: form.numero,
    cliente_id: form.cliente_id,
    equipamento: form.equipamento,
    marca: form.marca || 'Marca Exemplo',
    modelo: form.modelo || 'Modelo Exemplo',
    defeito_relatado: form.defeito_relatado || 'Defeito exemplo',
    valor_mao_obra: form.valor_mao_obra || 0,
    valor_pecas: form.valor_pecas || 0,
    valor_total: form.valor_total || 0,
    garantia_dias: form.garantia_dias || 90,
    observacoes: form.observacoes || ''
  }

  // Abrir uma nova aba com um PDF de exemplo
  const url = `/ordens-servico/preview?${new URLSearchParams(dadosTemp).toString()}`
  window.open(url, '_blank')
}
</script>
