<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FormularioFee from "@/Pages/Fee/Partials/FormularioFee.vue";
import FormularioUpdateFee from "@/Pages/Fee/Partials/FormularioUpdateFee.vue";

defineProps({
    fee: Object,
});
</script>

<template>
    <AppLayout title="Create Scanner">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Criar Taxa
            </h2>
        </template>
        <div class="w-full">
            <div class="w-full lg:w-2/3 mx-auto">
                <FormularioUpdateFee :fee="fee" class="mt-[69px] mx-auto" />
            </div>
        </div>
    </AppLayout>
</template>
