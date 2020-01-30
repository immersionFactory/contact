import './bootstrap';
import Vue from 'vue';

// import Routes from '@/js/routes.js';
import ContactUs from '@/js/views/ContactUs';

const app = new Vue({
    el: '#app',
    components: {
        ContactUs
    }
});

export default app;
