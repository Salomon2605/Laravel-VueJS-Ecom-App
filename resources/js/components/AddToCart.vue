<template>
    <div class="flex items-center justify-between py-4">
        <button 
            class="bg-indigo-500 text-white p-2"
            v-on:click.prevent="addToCart"
        >Ajouter au panier</button>
    </div>
</template>

<script setup>
    import { createToaster } from "@meforma/vue-toaster";
    import useProduct from '../composables/products/index';
    import { cartEmitter } from '../composables/products/eventBus';

    const { add } = useProduct(); //destructuration de la methode add pour l'utiliser
    const productId = defineProps(['product-id']);

    const toaster = createToaster();

    const addToCart = async() => {
        await axios.get('/sanctum/csrf-cookie'); //on recupère le token csrf 
        await axios.get('/api/user').then(async(res) => {
            //maintenant qu'on est connecté 
            let cartCount = await add(productId); //ici l'ajout au panier va se faire et on envoie aussi le count en return, donc on peut le recuperer 
            
            //on va emettre l'evenement, syntaxe : emitter.emit('unNomDappel', 'arg1', 'arg2', ...);
            cartEmitter.emit('cartCountUpdated', cartCount);
            toaster.success("Produit ajouté au panier", { position: "top", duration: 3000});
        })
        .catch(() => {
            // alert("Merci de vous connecter pour ajouter un produit.");
            toaster.error("Merci de vous connecter pour ajouter un produit.", { position: "top", duration: 3000});
        });
    }
</script>