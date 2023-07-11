import './bootstrap';

import Alpine from 'alpinejs';
import { createApp } from 'vue';
import AddToCart from './components/AddToCart.vue';

window.Alpine = Alpine;

Alpine.start();

const app = createApp(); //qui nous permettra de générer une instance de vue, qui vient de la ligne 1 dans le cas actuel

app.component('AddToCart', AddToCart); //enregister le component auprès de vue pour pouvoir l'utiliser 

app.mount('#app');