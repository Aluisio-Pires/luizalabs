<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FormularioTransaction from "@/Pages/Transaction/Partials/FormularioTransaction.vue";

defineProps({
    types: Object,
    account: Object,
});
</script>

<template>
    <AppLayout title="Create Scanner">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Realizar Transação
            </h2>
        </template>
        <div class="w-full">
            <div class="w-full lg:w-2/3 mx-auto">
                <FormularioTransaction class="mt-[69px] mx-auto" :account="account" :types="types"/>
            </div>
        </div>
    </AppLayout>
</template>
