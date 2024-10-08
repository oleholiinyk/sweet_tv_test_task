import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import {createBootstrap} from 'bootstrap-vue-next'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-next/dist/bootstrap-vue-next.css'

import App from './App.vue'
import router from './router'
import Toastification from '@/plugins/toastification'

const app = createApp(App)

app.use(createPinia())
app.use(createBootstrap())
app.use(router)
app.use(Toastification);

app.mount('#app')
