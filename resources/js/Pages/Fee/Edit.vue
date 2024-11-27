<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import FormularioUpdateFee from "@/Pages/Fee/Partials/FormularioUpdateFee.vue";
import { Link, router } from "@inertiajs/vue3";

let props = defineProps({
    fee: Object,
});

const destroy = () => {
    router.delete(route("fees.destroy", props.fee.id));
};
</script>

<template>
    <AppLayout title="Create Scanner">
        <template #header>
            <div class="flex justify-between items-center text-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Atualizar Taxa
                </h2>
                <form @submit.prevent="destroy">
                    <button
                        class="bg-red-500 hover:bg-red-500/90 click:bg-red-600 text-white py-2 px-4 rounded"
                    >
                        Excluir Taxa
                    </button>
                </form>
            </div>
        </template>
        <div class="w-full">
            <div class="w-full lg:w-2/3 mx-auto">
                <FormularioUpdateFee :fee="fee" class="mt-[69px] mx-auto" />
            </div>
        </div>
    </AppLayout>
</template>
