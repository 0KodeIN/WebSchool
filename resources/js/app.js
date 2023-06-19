/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';
import router from './router/router';
import { setCookie, getCookie, delCookie } from './cookie';
const app = createApp({});
createApp.$cookie = {
    setCookie,
    getCookie,
    delCookie
};



import ButtonComponent from './components/ButtonComponent.vue';
import Header from './components/Header.vue';
import Admin from './components/Admin.vue';
import App from './components/App.vue';
import Register from './components/Register.vue';



app.component('button-component', ButtonComponent);
app.component('v-header', Header);
app.component('admin', Admin);
app.component('app',App);
app.component('register',Register);
// export default{
//     components:{
//         ExampleComponent,
//         ButtonComponent,
//         Header,
//         Admin
// }
// }


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */
app.use(router);
app.mount('#app');

