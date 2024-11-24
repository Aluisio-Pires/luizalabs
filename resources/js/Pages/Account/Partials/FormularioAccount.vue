<script setup>
import {useForm} from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    balance: "",
    credit_limit: "once",
    errors: {},
});

const submit = () => {
    form.post(route('accounts.store'), {
        onSuccess: () => form.reset('balance', 'credit_limit'),
    });
};
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <div>
                <InputLabel for="balance" value="Saldo" />
                <TextInput
                    id="balance"
                    v-model="form.balance"
                    type="number"
                    class="mt-1 block w-full"
                    placeholder="1000.00"
                    required
                    autofocus
                />
                <InputError class="mt-2" :message="form.errors.balance" />
            </div>

            <div class="mt-4">
                <InputLabel for="credit_limit" value="Limite de Crédito" />
                <TextInput
                    id="credit_limit"
                    v-model="form.credit_limit"
                    type="number"
                    class="mt-1 block w-full"
                    required
                    placeholder="1000.00"
                />
                <InputError class="mt-2" :message="form.errors.credit_limit" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Criar Conta
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
