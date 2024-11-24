<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FormularioAccount from "@/Pages/Account/Partials/FormularioAccount.vue";
</script>

<template>
    <AppLayout title="Create Scanner">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Conta
            </h2>
        </template>
        <div class="w-full">
            <div class="w-full lg:w-2/3 mx-auto">
                <FormularioAccount class="mt-[69px] mx-auto" />
            </div>
        </div>
    </AppLayout>
</template>
