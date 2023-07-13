export default function useProduct() //on va y nettre tous les appels aux APIs qui concernent les produits
{
    const add = async(productId) => {
        let response = await axios.post('/api/products', {
            productId: productId
        });

        console.log(response);
    }

    const getCount = async() => {
        let response = await axios.get('/api/products/count');

        return response.data.count;
    }

    return {
        add,
        getCount,
    }
}