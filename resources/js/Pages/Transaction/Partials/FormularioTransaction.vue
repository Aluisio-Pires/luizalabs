<script setup>
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    types: Object,
    account: Object,
});

const form = useForm({
    description: null,
    type: "deposito",
    amount: null,
    account_number: props.account.number,
    payee_number: null,
    errors: {},
});

const submit = () => {
    if(form.type !== 'transferencia') {
        form.payee_number = null;
    }
    form.post(route('transactions.store'), {
        onSuccess: () => form.reset('description', 'type', 'amount', 'transaction_type_id', 'payee_number'),
    });
};
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="type" value="Tipo de Transação" />
                <select v-model="form.type"
                        id="type"
                        class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                >
                    <option v-for="type in types" :value="type.slug">
                        {{ type.name }}
                    </option>
                </select>
            </div>

            <div class="mt-4">
                <InputLabel for="description" value="Descrição" />
                <TextInput
                    id="description"
                    v-model="form.description"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Opcional"
                />
                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="mt-4">
                <InputLabel for="amount" value="Valor" />
                <TextInput
                    id="amount"
                    v-model="form.amount"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder="1000.00"
                    required
                />
                <InputError class="mt-2" :message="form.errors.amount" />
            </div>

            <div v-if="form.type === 'transferencia'" class="mt-4">
                <InputLabel for="payee_number" value="Número da conta de destino" />
                <TextInput
                    id="payee_number"
                    v-model="form.payee_number"
                    type="number"
                    class="mt-1 block w-full"
                    :placeholder="'Exemplo: ' + account.number"
                />
                <InputError class="mt-2" :message="form.errors.payee_number" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Realizar Transação
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
