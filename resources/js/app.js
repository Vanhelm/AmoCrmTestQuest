//Библиотека axios(http клиент)
window.axios = require('axios');

//Установка заголовка
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

//Подключение vue
window.Vue = require('vue').default;

//Импорт валидации клиентской
import Vuelidate from 'vuelidate'
//Маска для удобного ввода номера
import VueMask from 'v-mask'
// Использование маски
Vue.use(VueMask);
//Подключение валидации
Vue.use(Vuelidate)

// Определение шаблонов
Vue.component('form-price', require('./components/FormPrice.vue').default);

// Использование vue
const app = new Vue({
    el: '#app',
});