import { ref } from "vue";

export default function useProduct() //on va y nettre tous les appels aux APIs qui concernent les produits
{
    const products = ref([]); //on lui donne un array vide avec "ref"

    const getProducts = async() => {
        let response = await axios.get('/api/products');

        return response.data.cartContent;
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

    return {
        add,
        getCount,
        products,
        getProducts
    }
}