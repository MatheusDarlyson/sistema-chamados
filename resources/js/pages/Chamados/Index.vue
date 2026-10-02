<script setup>
import { Link, usePage } from '@inertiajs/vue3'; 


// Função para definir a classe CSS com base na prioridade do chamado
function classePrioridade(prioridade) {
    return {
        'Alta': 'bg-red-100 text-red-800',
        'Média': 'bg-yellow-100 text-yellow-800',
        'Baixa': 'bg-green-100 text-green-800',
    }[prioridade];
}

// Função para definir a classe CSS com base no status do chamado
function classeStatus(status) {
    return {
        'Aberto': 'bg-blue-100 text-blue-800',
        'Em andamento': 'bg-yellow-100 text-yellow-800',
        'Fechado': 'bg-green-100 text-green-800',
    }[status];
}


defineProps({  // Recebe a lista de chamados como propriedade
    chamados: {
        type: Array,
        default: () => [],
    },
});

const page = usePage();
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
                    <h1 class="text-3xl font-bold text-gray-900">
                        Chamados
                    </h1>

                    <p class="mt-2 text-gray-600">
                        Acompanhamento dos chamados cadastrados.
                    </p>
                </div>

                <Link
                    href="/chamados/criar"
                    class="rounded-md bg-blue-600 px-5 py-2.5 font-medium text-white hover:bg-blue-700"
                >
                    Novo chamado
                </Link>
            </div>

            <div class="mb-6 rounded-lg bg-white p-6 shadow">
                <p class="text-sm text-gray-500">
                    Total de chamados
                </p>

                <p class="mt-1 text-3xl font-bold text-gray-900">
                    {{ chamados.length }}
                </p>
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
                        <tr
                            v-for="chamado in chamados"
                            :key="chamado.id"
                            class="hover:bg-gray-50"
                        >
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
                            <td
                                colspan="5"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                Nenhum chamado cadastrado.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</template>