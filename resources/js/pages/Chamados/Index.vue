<script setup>
defineProps({
    chamados: {
        type: Array,
        default: () => [],
    },
});
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="mx-auto max-w-6xl">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    Chamados
                </h1>

                <p class="mt-2 text-gray-600">
                    Acompanhamento dos chamados cadastrados.
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
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ chamado.titulo }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ chamado.prioridade }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ chamado.status }}
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