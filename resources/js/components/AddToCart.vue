<template>
    <div class="flex items-center justify-between py-4">
        <button 
            class="bg-indigo-500 text-white p-2"
            v-on:click.prevent="addToCart"
        >Ajouter au panier</button>
    </div>
</template>

<script setup>
    import useProduct from '../composables/products/index';

    const { add } = useProduct(); //destructuration de la methode add pour l'utiliser
    const productId = defineProps(['product-id']);

    const addToCart = async() => {
        await axios.get('/sanctum/csrf-cookie'); //on recupère le token csrf 
        await axios.get('/api/user').then(async(res) => {
            //maintenant qu'on est connecté 
            await add(productId);
        })
        .catch(err => console.log(err));
    }
</script>