<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { defineProps } from "vue";
import { WhenVisible, Link, usePage } from "@inertiajs/vue3";
import Fee from "@/Pages/Fee/Partials/Fee.vue";
defineProps({
    fees: Object,
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
                    Taxas
                </h2>
                <Link
                    :href="route('fees.create')"
                    class="bg-green-500 text-white py-2 px-4 rounded"
                    prefetch="mount"
                    :cacheFor="['30m', '30m']"
                >
                    Criar Taxa
                </Link>
            </div>
        </template>
        <div class="grid grid-cols-12 bg-gray-100 px-2 lg:px-8 py-8">
            <div class="col-span-3 text-center">Nome</div>
            <div class="col-span-3 text-center">Valor</div>
            <div class="col-span-3 text-center">Transação Associada</div>
            <div class="col-span-3 text-center">Atualizar Taxa</div>
        </div>
        <div
            v-for="fee in fees"
            :key="fee.id"
            class="grid grid-cols-12 bg-gray-50 py-8 px-2 lg:px-8"
        >
            <Fee :fee="fee" />
        </div>
        <WhenVisible
            always
            :params="{
                data: {
                    page: currentPage + 1,
                },
                only: ['fees', 'currentPage'],
                preserveUrl: true,
            }"
        >
            <div v-show="false">loading...</div>
        </WhenVisible>
    </AppLayout>
</template>
