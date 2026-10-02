<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";

// Props recebidos do backend
const props = defineProps({
  chamados: {
    type: Array,
    default: () => [],
  },

  responsaveis: {
    type: Array,
    default: () => [],
  },

  filtros: {
    type: Object,
    default: () => ({
      status: "",
      prioridade: "",
      responsavel_id: "",
    }),
  },
});

const page = usePage();

// Formulário para filtros
const filtroForm = useForm({
  status: props.filtros.status ?? "",
  prioridade: props.filtros.prioridade ?? "",
  responsavel_id: props.filtros.responsavel_id ?? "",
});

// Função para aplicar os filtros
function aplicarFiltros() {
  filtroForm.get("/chamados", {
    preserveState: true,
    preserveScroll: true,
  });
}

// Função para limpar os filtros
function limparFiltros() {
  filtroForm.reset();

  filtroForm.get("/chamados", {
    preserveState: true,
    preserveScroll: true,
  });
}

// Funções para classes CSS
function classePrioridade(prioridade) {
  return {
    Baixa: "bg-gray-100 text-gray-700",
    Média: "bg-yellow-100 text-yellow-800",
    Alta: "bg-red-100 text-red-800",
  }[prioridade];
}

// Função para classes CSS
function classeStatus(status) {
  return {
    Aberto: "bg-blue-100 text-blue-800",
    "Em andamento": "bg-yellow-100 text-yellow-800",
    Concluído: "bg-green-100 text-green-800",
  }[status];
}
</script>

<template>
  <div class="min-h-screen bg-gray-100 p-8">
    <div class="mx-auto max-w-6xl">
      <div
        v-if="page.props.flash?.success"
        class="mb-6 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800"
      >
        {{ page.props.flash.success }}
      </div>

      <div class="mb-8 flex items-start justify-between gap-4">
        <div>
          <h1 class="text-3xl font-bold text-gray-900">Chamados</h1>

          <p class="mt-2 text-gray-600">Acompanhamento dos chamados cadastrados.</p>
        </div>

        <Link
          href="/chamados/criar"
          class="rounded-md bg-blue-600 px-5 py-2.5 font-medium text-white hover:bg-blue-700"
        >
          Novo chamado
        </Link>
      </div>

      <div class="mb-6 rounded-lg bg-white p-6 shadow">
        <p class="text-sm text-gray-500">Total de chamados</p>

        <p class="mt-1 text-3xl font-bold text-gray-900">
          {{ chamados.length }}
        </p>
      </div>

      <div class="mb-6 rounded-lg bg-white p-6 shadow">
        <div class="grid gap-4 md:grid-cols-4">
          <div>
            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">
              Status
            </label>

            <select
              id="status"
              v-model="filtroForm.status"
              class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"
            >
              <option value="">Todos</option>
              <option value="Aberto">Aberto</option>
              <option value="Em andamento">Em andamento</option>
              <option value="Concluído">Concluído</option>
            </select>
          </div>

          <div>
            <label for="prioridade" class="mb-2 block text-sm font-medium text-gray-700">
              Prioridade
            </label>

            <select
              id="prioridade"
              v-model="filtroForm.prioridade"
              class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"
            >
              <option value="">Todas</option>
              <option value="Baixa">Baixa</option>
              <option value="Média">Média</option>
              <option value="Alta">Alta</option>
            </select>
          </div>

          <div>
            <label for="responsavel" class="mb-2 block text-sm font-medium text-gray-700">
              Responsável
            </label>

            <select
              id="responsavel"
              v-model="filtroForm.responsavel_id"
              class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none"
            >
              <option value="">Todos</option>

              <option
                v-for="responsavel in responsaveis"
                :key="responsavel.id"
                :value="responsavel.id"
              >
                {{ responsavel.nome }}
              </option>
            </select>
          </div>

          <div class="flex items-end gap-2">
            <button
              type="button"
              :disabled="filtroForm.processing"
              @click="aplicarFiltros"
              class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
            >
              Filtrar
            </button>

            <button
              type="button"
              @click="limparFiltros"
              class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
            >
              Limpar
            </button>
          </div>
        </div>
      </div>

      <div class="overflow-hidden rounded-lg bg-white shadow">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                Título
              </th>

              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                Prioridade
              </th>

              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                Status
              </th>

              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                Responsável
              </th>

              <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">
                Abertura
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            <tr v-for="chamado in chamados" :key="chamado.id" class="hover:bg-gray-50">
              <td class="px-6 py-4 text-sm">
                <Link
                  :href="`/chamados/${chamado.id}`"
                  class="text-blue-600 hover:underline"
                >
                  {{ chamado.titulo }}
                </Link>
              </td>

              <td class="px-6 py-4 text-sm text-gray-700">
                <span
                  class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium"
                  :class="classePrioridade(chamado.prioridade)"
                >
                  {{ chamado.prioridade }}
                </span>
              </td>

              <td class="px-6 py-4 text-sm text-gray-700">
                <span
                  class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium"
                  :class="classeStatus(chamado.status)"
                >
                  {{ chamado.status }}
                </span>
              </td>

              <td class="px-6 py-4 text-sm text-gray-700">
                {{ chamado.responsavel?.nome }}
              </td>

              <td class="px-6 py-4 text-sm text-gray-700">
                {{ chamado.data_abertura }}
              </td>
            </tr>

            <tr v-if="chamados.length === 0">
              <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                Nenhum chamado cadastrado.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
