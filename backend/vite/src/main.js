import { createApp } from 'vue'

import TestApp from './apps/TestApp.vue'

if (document.getElementById('test-app')) {
    createApp(TestApp).mount('#test-app')
}
