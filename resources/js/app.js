/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue'
import VueToastr2 from 'vue-toastr-2';
import 'vue-toastr-2/dist/vue-toastr-2.min.css';
import VueExcelEditor from 'vue-excel-editor';
import VueGoodTablePlugin from 'vue-good-table';
import 'vue-good-table/dist/vue-good-table.css';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import VueMoment from 'vue-moment';
import VueSweetalert2 from 'vue-sweetalert2';
import { ValidationProvider, ValidationObserver } from "vee-validate";

Vue.use(VueToastr2);
Vue.use(VueExcelEditor);
Vue.use(VueGoodTablePlugin);
Vue.use(Loading, {
    loader: 'dots',
    color: '#3490DC'
});
Vue.use(VueMoment);
Vue.use(VueSweetalert2);

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('dashboard-index', require('./components/Dashboard/Index.vue').default);
Vue.component('dashboard-user', require('./components/Dashboard/User.vue').default);

Vue.component('guru-index', require('./components/Guru/Index.vue').default);

Vue.component('siswa-index', require('./components/Siswa/Index.vue').default);

Vue.component('kelas-index', require('./components/Kelas/Index.vue').default);

Vue.component('poin-index', require('./components/Poin/Index.vue').default);
Vue.component('poin-create', require('./components/Poin/Create.vue').default);
Vue.component('poin-cek', require('./components/Poin/Cek.vue').default);
Vue.component('poin-siswa', require('./components/Poin/Siswa.vue').default);

Vue.component('penebusan-index', require('./components/Penebusan/Index.vue').default);

Vue.component('sanksi-index', require('./components/Sanksi/Index.vue').default);

Vue.component('penghargaan-index', require('./components/Penghargaan/Index.vue').default);

Vue.component('semester-index', require('./components/Semester/Index.vue').default);

Vue.component('pengaduan-index', require('./components/Pengaduan/Index.vue').default);
Vue.component('pengaduan-create', require('./components/Pengaduan/Create.vue').default);

Vue.component('operasi-index', require('./components/Operasi/Index.vue').default);

Vue.component('profile-index', require('./components/Profile/Index.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
