<script setup>
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    chamado: {
        type: Object,
        required: true,
    },

    responsaveis: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    titulo: props.chamado.titulo,
    descricao: props.chamado.descricao,
    prioridade: props.chamado.prioridade,
    status: props.chamado.status,
    responsavel_id: props.chamado.responsavel_id,
});

function atualizarChamado() {
    form.put(`/chamados/${props.chamado.id}`);
}
</script>

<template>
    <div class="min-h-screen bg-gray-100 p-8">
        <div class="mx-auto max-w-3xl">

            <div class="mb-8">
                <Link
                    :href="`/chamados/${chamado.id}`"
                    class="text-sm text-blue-600 hover:underline"
                >
                    ← Voltar para o chamado
                </Link>

                <h1 class="mt-4 text-3xl font-bold text-gray-900">
                    Editar chamado
                </h1>

                <p class="mt-2 text-gray-600">
                    Atualize as informações do chamado.
                </p>
            </div>

            <form
                @submit.prevent="atualizarChamado"
                class="space-y-6 rounded-lg bg-white p-8 shadow"
            >
                <div>
                    <label
                        for="titulo"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Título
                    </label>

                    <input
                        id="titulo"
                        v-model="form.titulo"
                        type="text"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                    >

                    <p
                        v-if="form.errors.titulo"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.titulo }}
                    </p>
                </div>

                <div>
                    <label
                        for="descricao"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Descrição
                    </label>

                    <textarea
                        id="descricao"
                        v-model="form.descricao"
                        rows="5"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                    ></textarea>

                    <p
                        v-if="form.errors.descricao"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ form.errors.descricao }}
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label
                            for="prioridade"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Prioridade
                        </label>

                        <select
                            id="prioridade"
                            v-model="form.prioridade"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                        >
                            <option value="Baixa">Baixa</option>
                            <option value="Média">Média</option>
                            <option value="Alta">Alta</option>
                        </select>
                    </div>

                    <div>
                        <label
                            for="responsavel_id"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Responsável
                        </label>

                        <select
                            id="responsavel_id"
                            v-model="form.responsavel_id"
                            class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                        >
                            <option
                                v-for="responsavel in responsaveis"
                                :key="responsavel.id"
                                :value="responsavel.id"
                            >
                                {{ responsavel.nome }}
                            </option>
                        </select>

                        <p
                            v-if="form.errors.responsavel_id"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ form.errors.responsavel_id }}
                        </p>
                    </div>
                </div>

                <div>
                    <label
                        for="status"
                        class="mb-2 block text-sm font-medium text-gray-700"
                    >
                        Status
                    </label>

                    <select
                        id="status"
                        v-model="form.status"
                        class="w-full rounded-md border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                    >
                        <option value="Aberto">Aberto</option>
                        <option value="Em andamento">Em andamento</option>
                        <option value="Concluído">Concluído</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3">
                    <Link
                        :href="`/chamados/${chamado.id}`"
                        class="rounded-md border border-gray-300 px-6 py-2 font-medium text-gray-700 hover:bg-gray-50"
                    >
                        Cancelar
                    </Link>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="rounded-md bg-blue-600 px-6 py-2 font-medium text-white hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        {{ form.processing ? 'Salvando...' : 'Salvar alterações' }}
                    </button>
                </div>
            </form>

        </div>
    </div>
</template>