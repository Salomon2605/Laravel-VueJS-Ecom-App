<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import AddToCart from '@/components/AddToCart.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Produits" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Liste des Produits</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Remove py-8 -->
                <div class="mx-auto container py-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4">
                        <div v-for="product in $page.props.products" :key="product.id" tabindex="0"
                            class="focus:outline-none">
                            <div>
                                <img :src="product.image" alt="Product image" class="w-full h-44 focus:outline-none" />
                            </div>
                            <div class="bg-white">
                                <div class="flex items-center justify-between px-4 pt-4">
                                    <div>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 focus:outline-none"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm3 0h4a1 1 0 010 2H5a1 1 0 010-2zm6 0h2a1 1 0 010 2h-2a1 1 0 010-2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="bg-yellow-200 py-1.5 px-6 rounded-full">
                                        <p class="text-xs text-yellow-700 focus:outline-none">{{ product.price }}</p>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center">
                                        <h2 class="text-lg font-semibold focus:outline-none">{{ product.name }}</h2>
                                        <p class="text-xs text-gray-600 pl-5 focus:outline-none"></p>
                                    </div>
                                    <p class="text-xs text-gray-600 mt-2 focus:outline-none">{{ product.description }}</p>
                                    <!-- <div class="flex mt-4">
                                        <div>
                                        <p class="text-xs text-gray-600 px-2 bg-gray-200 py-1 focus:outline-none">12 months warranty</p>
                                        </div>
                                        <div class="pl-2">
                                        <p class="text-xs text-gray-600 px-2 bg-gray-200 py-1 focus:outline-none">Complete box</p>
                                        </div>
                                    </div> -->
                                    <!-- <add-to-cart :product-id="{{ $product->id }}"></add-to-cart> -->
                                    <AddToCart></AddToCart>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
