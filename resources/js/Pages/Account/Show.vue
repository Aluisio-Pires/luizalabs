<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
import { Link } from "@inertiajs/vue3";
let props = defineProps({
    account: Object,
});

Echo.private("Account.Report." + props.account.id).listen(
    ".account.report",
    (e) => {
        if (e.id === props.account.id) {
            props.account.balance = e.balance;
        }
    },
);
</script>

<template>
    <AppLayout title="Create Scanner">
        <template #header>
            <div class="w-full grid grid-cols-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Conta
                </h2>
                <div class="col-span-3 flex justify-end">
                    <Link
                        :href="route('accounts.createTransaction', account.id)"
                        class="bg-green-500 text-white py-2 px-4 rounded"
                        prefetch="mount"
                        :cacheFor="['30m', '30m']"
                    >
                        Fazer Transação
                    </Link>
                </div>
            </div>
        </template>
        <div class="w-full flex justify-between px-2 lg:px-8 mt-4">
            <div>Número da Conta: {{ account.number }}</div>
            <div
                :class="
                    account.balance >= 0 ? 'text-green-500' : 'text-red-500'
                "
            >
                Saldo: R$ {{ $formatNumber(account.balance) }}
            </div>
            <div
                :class="
                    account.balance >= 0 ? 'text-green-500' : 'text-red-500'
                "
            >
                Limite de Crédito: R$ {{ $formatNumber(account.credit_limit) }}
            </div>
        </div>
    </AppLayout>
</template>
