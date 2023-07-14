<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StripeCheckout from '@/components/StripeCheckout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Paiement" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Paiement</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl flex justify-center mx-auto sm:px-6 lg:px-8">
                <StripeCheckout></StripeCheckout>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
