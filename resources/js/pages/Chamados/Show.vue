<script setup>
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  chamado: {
    type: Object,
    required: true,
  },
});

const deleteForm = useForm({});

function deletarChamado() {
  if (confirm("Tem certeza que deseja excluir este chamado?")) {
    deleteForm.delete(`/chamados/${props.chamado.id}`, {
      });
  }
}

function classePrioridade(prioridade) {
  return {
    Baixa: "bg-gray-100 text-gray-700",
    Média: "bg-yellow-100 text-yellow-800",
    Alta: "bg-red-100 text-red-800",
  }[prioridade];
}

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
    <div class="mx-auto max-w-4xl">
      <div class="mb-8">
        <Link href="/chamados" class="text-sm text-blue-600 hover:underline">
          ← Voltar para chamados
        </Link>

        <div class="mt-4 flex items-start justify-between gap-4">
          <div>
            <p class="text-sm text-gray-500">Chamado #{{ chamado.id }}</p>

            <h1 class="mt-1 text-3xl font-bold text-gray-900">
              {{ chamado.titulo }}
            </h1>
          </div>

          <div class="flex items-center gap-3">
            <span
              class="inline-flex rounded-full px-3 py-1 text-sm font-medium"
              :class="classeStatus(chamado.status)"
            >
              {{ chamado.status }}
            </span>

            <Link
              :href="`/chamados/${chamado.id}/editar`"
              class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700"
            >
              Editar
            </Link>
            <button
                type="button"
                :disabled="deleteForm.processing"
                @click="deletarChamado"
                class="rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 disabled:opacity-50"
            >
                Excluir 
            </button>
          </div>
        </div>
      </div>

      <div class="rounded-lg bg-white shadow">
        <div class="border-b border-gray-200 p-6">
          <h2 class="text-lg font-semibold text-gray-900">Descrição</h2>

          <p class="mt-3 whitespace-pre-line text-gray-700">
            {{ chamado.descricao }}
          </p>
        </div>

        <div class="grid gap-6 p-6 md:grid-cols-3">
          <div>
            <p class="text-sm text-gray-500">Prioridade</p>

            <span
              class="mt-2 inline-flex rounded-full px-2.5 py-1 text-xs font-medium"
              :class="classePrioridade(chamado.prioridade)"
            >
              {{ chamado.prioridade }}
            </span>
          </div>

          <div>
            <p class="text-sm text-gray-500">Responsável</p>

            <p class="mt-2 font-medium text-gray-900">
              {{ chamado.responsavel?.nome }}
            </p>
          </div>

          <div>
            <p class="text-sm text-gray-500">Data de abertura</p>

            <p class="mt-2 font-medium text-gray-900">
              {{ chamado.data_abertura }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
