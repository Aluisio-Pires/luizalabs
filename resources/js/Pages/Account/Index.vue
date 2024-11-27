<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
import { WhenVisible, Link, usePage } from "@inertiajs/vue3";
import Account from "@/Pages/Account/Account.vue";
defineProps({
    accounts: Object,
    currentPage: Number,
});
</script>

<template>
    <AppLayout title="Create Scanner">
        <template #header>
            <div class="justify-between flex">
                <h2
                    class="font-semibold text-xl text-gray-800 leading-tight my-auto"
                >
                    Contas
                </h2>
                <Link
                    :href="route('accounts.create')"
                    class="bg-green-500 text-white py-2 px-4 rounded"
                    prefetch="mount"
                    :cacheFor="['30m', '30m']"
                >
                    Criar Conta
                </Link>
            </div>
        </template>
        <div class="grid grid-cols-12 bg-gray-100 px-2 lg:px-8 py-8">
            <div class="col-span-3 text-center">Número da Conta</div>
            <div class="col-span-3 text-center">Saldo</div>
            <div class="col-span-3 text-center">Limite de Crédito</div>
            <div class="col-span-3 text-center">Opções</div>
        </div>
        <div
            v-for="account in accounts"
            :key="account.id"
            class="grid grid-cols-12 bg-gray-50 py-8 px-2 lg:px-8"
        >
            <Account :account="account" />
        </div>
        <WhenVisible
            always
            :params="{
                data: {
                    page: currentPage + 1,
                },
                only: ['accounts', 'currentPage'],
                preserveUrl: true,
            }"
        >
            <div v-show="currentPage < accounts.last_page">loading...</div>
        </WhenVisible>
    </AppLayout>
</template>
