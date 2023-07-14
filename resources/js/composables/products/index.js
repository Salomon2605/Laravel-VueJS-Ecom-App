import { ref } from "vue";

export default function useProduct() //on va y nettre tous les appels aux APIs qui concernent les produits
{
    const products = ref([]); //on lui donne un array vide avec "ref"
    const cartCount = ref(0);

    const getProducts = async() => {
        let response = await axios.get('/api/products');

        products.value = response.data.cartContent;

        cartCount.value = response.data.cartCount;
    }

    const add = async(productId) => {
        let response = await axios.post('/api/products', {
            productId: productId
        });

        return response.data.count;
    }

    const getCount = async() => {
        let response = await axios.get('/api/products/count');

        return response.data.count;
    }

    const increaseQuantity = async(id) => {
        await axios.get('/api/products/increase/' + id);
    }

    const decreaseQuantity = async(id) => {
        await axios.get('/api/products/decrease/' + id);
    }

    const destroyProduct = async(id) => {
        await axios.delete('/api/products/' + id);
    }

    return {
        add,
        getCount,
        products,
        getProducts,
        increaseQuantity,
        decreaseQuantity,
        destroyProduct,
        cartCount
    }
}