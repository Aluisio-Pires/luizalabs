<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps, ref } from "vue";
import axios from "axios";
import { useForm } from "@inertiajs/vue3";

let props = defineProps({
    subledger: Object,
});

const form = useForm({
    name: props.subledger.name,
    description: props.subledger.description,
    errors: {},
});

const subledger = props.subledger;

const editarNome = ref(false);
const editarDescricao = ref(false);

const submit = () => {
    if (editarNome.value || editarDescricao.value) {
        axios
            .put(route("api.v1.subledgers.update", subledger.id), form)
            .then((response) => {
                editarNome.value = false;
                editarDescricao.value = false;
            })
            .catch((error) => {
                form.errors = error.response.data.errors;
            });
    }
};
</script>

<template>
    <AppLayout title="Create Scanner" @click="submit">
        <template #header>
            <div class="w-full grid grid-cols-1 lg:grid-cols-3 items-center">
                <div v-if="!editarNome" @click.stop="editarNome = true">
                    <div v-if="form.name" class="text-center text-gray-700">
                        {{ form.name }}
                    </div>
                    <div v-else class="text-center text-gray-500">
                        Transação não identificada
                    </div>
                </div>
                <div
                    v-else
                    @keydown.enter="submit"
                    @keydown.esc="
                        form.name = subledger.name;
                        editarNome = false;
                    "
                    @click.stop="editarNome = true"
                >
                    <input
                        v-model="form.name"
                        type="text"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
                </div>
                <div
                    class="text-center mt-2"
                    :class="
                        subledger.ledger.name === 'Entrada'
                            ? 'text-green-500'
                            : 'text-red-500'
                    "
                >
                    R$
                    {{
                        subledger.ledger.name === "Entrada"
                            ? $formatNumber(subledger.value)
                            : $formatNumber(-1 * subledger.value)
                    }}
                </div>
                <div class="text-center mt-2 text-gray-700">
                    {{ subledger.formatted_created_at }}
                </div>
            </div>
        </template>
        <div class="w-full bg-gray-100 px-2 lg:px-8">
            <div class="bg-gray-50 rounded-lg py-8 px-4 w-full mt-4">
                <div class="text-center font-bold">Descrição</div>
                <div
                    v-if="!editarDescricao"
                    @click.stop="editarDescricao = true"
                >
                    <div
                        v-if="form.description"
                        class="text-center text-gray-700"
                    >
                        {{ form.description }}
                    </div>
                    <div v-else class="text-center text-gray-500">
                        Descrição não informada
                    </div>
                </div>
                <div
                    v-else
                    @keydown.enter="submit"
                    @keydown.esc="
                        form.description = subledger.description;
                        editarDescricao = false;
                    "
                    @click.stop="editarDescricao = true"
                >
                    <input
                        v-model="form.description"
                        type="text"
                        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg py-8 px-4 w-full mt-4">
                <div class="text-center font-bold">Taxa</div>
                <div class="text-center text-gray-700">
                    R$
                    {{ $formatNumber(subledger.fee) }}
                </div>
            </div>
            <div class="bg-gray-50 rounded-lg py-8 px-4 w-full mt-4">
                <div class="text-center font-bold">Tipo de Transação</div>
                <div class="text-center text-gray-700">
                    {{ subledger.transaction.transaction_type.name }}
                </div>
            </div>
            <div
                v-if="subledger.transaction.type === 'transferencia'"
                class="bg-gray-50 rounded-lg py-8 px-4 w-full mt-4"
            >
                <div
                    v-if="
                        subledger.account_id ===
                        subledger.transaction.account_id
                    "
                >
                    <div class="text-center font-bold">Transferido para</div>
                    <div class="text-center text-gray-700">
                        {{ subledger.transaction.payee.user.name }}
                    </div>
                </div>
                <div v-else>
                    <div class="text-center font-bold">Recebido de</div>
                    <div class="text-center text-gray-700">
                        {{ subledger.transaction.account.user.name }}
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
