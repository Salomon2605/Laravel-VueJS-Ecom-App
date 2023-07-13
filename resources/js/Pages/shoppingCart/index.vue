<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ShoppingCart from '@/components/ShoppingCart.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Produits" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Récapitulatif de votre Panier</h2>
        </template>

        <ShoppingCart></ShoppingCart>

    </AuthenticatedLayout>
</template>
