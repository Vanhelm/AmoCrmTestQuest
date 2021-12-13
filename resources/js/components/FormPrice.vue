<template>
    <!-- просто форма для отправки с данными и перемеными vue -->
    <form class="w-full max-w-xl mx-auto sm:p-10 p-4" @submit.prevent="sendData">
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="name">
                Имя
            </label>
            </div>
            <div class="md:w-2/3">
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight 
                    focus:outline-none focus:bg-white focus:border-purple-500"
                    :class="{ 'border-red-400': $v.form.name.$error }" 
                    id="name" 
                    type="text"
                    v-model.trim="$v.form.name.$model"
                >
                <div class="text-red-400" v-if="$v.form.name.$error">Поля обязательно, от 2 до 10 симоволов</div>
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="email">
                Email
            </label>
            </div>
            <div class="md:w-2/3">
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight 
                    focus:outline-none focus:bg-white focus:border-purple-500" 
                    :class="{ 'border-red-400': $v.form.email.$error }" 
                    id="email" 
                    type="Email" 
                    placeholder=""
                    v-model="$v.form.email.$model"
                >
                <div class="text-red-400" v-if="$v.form.email.$error">Поля обязательно, email должен быть валидным</div>
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="phone">
                Телефон
            </label>
            </div>
            <div class="md:w-2/3">
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight 
                    focus:outline-none focus:bg-white focus:border-purple-500" 
                    :class="{ 'border-red-400': $v.form.phone.$error }" 
                    id="phone" 
                    type="text"
                    v-mask="'+7 ### ### ## ##'"
                    v-model="$v.form.phone.$model"
                >
                <div class="text-red-400" v-if="$v.form.phone.$error">Поля обязательно</div>
            </div>
        </div>
        <div class="md:flex md:items-center mb-6">
            <div class="md:w-1/3">
            <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="price">
                Цена
            </label>
            </div>
            <div class="md:w-2/3">
                <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight 
                    focus:outline-none focus:bg-white focus:border-purple-500" 
                    :class="{ 'border-red-400': $v.form.price.$error }" 
                    id="price" 
                    type="text"
                    v-model="$v.form.price.$model"
                >
                <div class="text-red-400" v-if="$v.form.price.$error">Поля обязательно, должно быть число</div>
            </div>
        </div>
        <div class="md:flex md:items-center">
            <div class="md:w-1/3"></div>
            <div class="md:w-2/3">
                <button 
                    :class="{
                        'bg-red-500 hover:bg-red-400': submitStatus === 'ERROR',
                        'bg-purple-500 hover:bg-purple-400': submitStatus !== 'ERROR'
                        }"
                    class="shadow focus:shadow-outline focus:outline-none text-white 
                    font-bold py-2 px-4 rounded"
                    :disabled="submitStatus === 'PENDING'"
                >
                    Отправить
                </button>
                <p v-if="submitStatus === 'OK'">Данные отправлены!</p>
                <p v-if="submitStatus === 'WRONG'">Ошибка при передачи данных!</p>
                <p class="text-red-500" v-if="submitStatus === 'ERROR'">Есть ошибки.</p>
                <p v-if="submitStatus === 'PENDING'">Отправка...</p>
            </div>
        </div>
    </form>
</template>

<script>
import { required, minLength, maxLength, email, integer } from 'vuelidate/lib/validators'

export default {

    data(){
        return{
            //Переменные для формы(имя, телефон, email, цена)
            form:{
                name:null,
                phone:'+7',
                email:null,
                price: null,
            },
            submitStatus: null,
        }
    },
    // Валидация с помощью библиотеки
    validations: {
        form:{
            name: {
                required,
                minLength: minLength(2),
                maxLength: maxLength(10),
            },
            email:{
                required,
                email,
            },
            phone:{
                required,
            },
            price:{
                required,
                integer,
            }
        }
    },
    
    methods:{
        // отправка данных на сервер
        sendData(){
            this.$v.$touch()
            if (this.$v.$invalid) {
                this.submitStatus = 'ERROR'
            } else {
                // do your submit logic here
                this.submitStatus = 'PENDING'
                axios.post('/src/Send.php', this.form)
                .then(res => {
                    console.log(res.data)
                    this.submitStatus = 'OK'
                    setTimeout(() => {
                        this.form = {name: null, phone: '+ 7', price:null, email: null}
                        this.$v.$reset()
                        this.submitStatus = null
                    }, 1500)
                })
                .catch(error => {
                    console.log(error.response.data)
                    setTimeout(() => {
                        this.submitStatus = 'WRONG'
                    }, 500)
                    setTimeout(() => {
                        this.submitStatus = null
                    }, 1500)
                })
                
            }
        }
    }
}
</script>