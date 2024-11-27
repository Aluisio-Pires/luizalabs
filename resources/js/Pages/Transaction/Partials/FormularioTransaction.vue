<script setup>
import {useForm, usePage, router} from "@inertiajs/vue3";
import axios from "axios";
import {ref} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ModalProcessing from "@/Pages/Transaction/Partials/ModalProcessing.vue";
import NumberInput from "@/Components/NumberInput.vue";

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

const enableSubmit = ref(true);
const showModal = ref(false);
const statusTransaction = ref('pendente');
const messageTransaction = ref(null);
const transactionId = ref(null);

const page = usePage()
Echo.private('Transaction.Report.' + page.props.auth.user.id)
    .listen('.transaction.report', (e) => {
        processTransaction(e);
    });

const processTransaction = (data) => {
    statusTransaction.value = data.success === true ? 'sucesso' : 'falha';
    messageTransaction.value = data.message;
    setTimeout(() => {
        clearModal()
        if (data.success === true) {
            router.get(route("accounts.index"));
        } else {
            setTimeout(() => {
                enableSubmit.value = true;
            }, 100);
        }
    }, 2000);
}

const clearModal = () => {
    showModal.value = false;
    statusTransaction.value = 'pendente';
    messageTransaction.value = null;
}

const submit = () => {
    enableSubmit.value = false;
    axios
        .post(route("api.v1.transactions.store", form))
        .then((response) => {
            transactionId.value = response.data.transaction.id;
            showModal.value = true;
        })
        .catch((error) => {
            form.errors = error.response.data.errors;
            enableSubmit.value = true;
        });
}
</script>

<template>
    <div>
        <ModalProcessing :show="showModal" :status="statusTransaction" :message="messageTransaction"/>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="type" value="Tipo de Transação"/>
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
                <InputLabel for="description" value="Descrição"/>
                <TextInput
                    id="description"
                    v-model="form.description"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Opcional"
                />
                <InputError class="mt-2" v-for="error in form.errors.description" :message="error"/>
            </div>

            <div class="mt-4">
                <InputLabel for="amount" value="Valor"/>
                <NumberInput
                    id="amount"
                    v-model="form.amount"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder="1000,00"
                    required
                />
                <InputError class="mt-2" v-for="error in form.errors.amount" :message="error"/>
            </div>

            <div v-if="form.type === 'transferencia'" class="mt-4">
                <InputLabel for="payee_number" value="Número da conta de destino"/>
                <TextInput
                    id="payee_number"
                    v-model="form.payee_number"
                    type="number"
                    class="mt-1 block w-full"
                    :placeholder="'Exemplo: ' + account.number"
                />
                <InputError class="mt-2" v-for="error in form.errors.payee_number" :message="error"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25 cursor-not-allowed': !enableSubmit }"
                               :disabled="!enableSubmit">
                    Realizar Transação
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
