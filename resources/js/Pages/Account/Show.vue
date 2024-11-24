<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
defineProps({
    account: Object,
});

</script>

<template>
    <AppLayout title="Create Scanner">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Conta
            </h2>
        </template>
        <div class="w-full flex justify-between px-2 lg:px-8 mt-4">
            <div>
                Número da Conta: {{ account.number }}
            </div>
            <div :class=" account.balance >= 0 ? 'text-green-500' : 'text-red-500'">
                Saldo: {{ account.balance }}
            </div>
            <div :class=" account.balance >= 0 ? 'text-green-500' : 'text-red-500'">
                Limite de Crédito: {{ account.credit_limit }}
            </div>
        </div>
    </AppLayout>
</template>
