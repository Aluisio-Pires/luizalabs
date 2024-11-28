<script setup>
import { useForm } from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NumberInput from "@/Components/NumberInput.vue";
import { ref } from "vue";
import TextInput from "@/Components/TextInput.vue";

const form = useForm({
    name: "",
    description: "",
    type: "fixed",
    value: "",
    transaction_type_name: "saque",
    errors: {},
});

const types = ref([
    {
        slug: "fixed",
        label: "Fixo",
    },
    {
        slug: "percentage",
        label: "Percentual",
    },
]);

const transaction_types = ref([
    {
        slug: "saque",
        label: "Saque",
    },
    {
        slug: "transferencia",
        label: "Transferência",
    },
]);

const submit = () => {
    form.post(route("fees.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <div class="flex space-x-4">
                <div>
                    <InputLabel for="type" value="Tipo de Taxação" />
                    <select
                        v-model="form.type"
                        id="type"
                        class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    >
                        <option v-for="type in types" :value="type.slug">
                            {{ type.label }}
                        </option>
                    </select>
                </div>
                <div>
                    <InputLabel
                        for="transaction_type_name"
                        value="Tipo de Transação"
                    />
                    <select
                        v-model="form.transaction_type_name"
                        id="transaction_type_name"
                        class="mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    >
                        <option
                            v-for="type in transaction_types"
                            :value="type.slug"
                        >
                            {{ type.label }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <InputLabel for="name" value="Nome da Taxa" />
                <TextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder=""
                />
                <InputError class="mt-2" :message="form.errors.name" />
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
                <InputLabel for="value" value="Valor" />

                <NumberInput
                    id="value"
                    v-model="form.value"
                    type="number"
                    class="mt-1 block w-full"
                    required
                    placeholder="1000,00"
                />
                <InputError class="mt-2" :message="form.errors.value" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Criar Taxa
                </PrimaryButton>
            </div>
        </form>
    </div>
</template>
