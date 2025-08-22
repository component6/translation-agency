import { createApp } from 'vue'

import App from './apps/App.vue'

if (document.getElementById('app')) {
    createApp(App).mount('#app')
}
