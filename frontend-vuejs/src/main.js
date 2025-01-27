import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap/dist/js/bootstrap.min.js"
import "chart.js/dist/chart.min.js"

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import { reactive } from 'vue'
import langJson from '@/assets/lang/lang.json'

let app = createApp(App)
app.config.globalProperties.glob = reactive({
  "lang":"en",
  "langData": langJson
})
app.use(router).mount('#app')
