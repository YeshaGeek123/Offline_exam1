require('./bootstrap');

import Vue from 'vue'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import VueSwal from 'vue-swal'
import CallBoard from './components/CallBoard.vue';
import StudentTable from './components/StudentTable.vue';

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueSwal)

// Vue.component('notification', require('./components/Notification.vue').default);
// Vue.component('submission-table', require('./components/SubmissionTable.vue').default);
// Vue.component('notification-table', require('./components/NotificationTable.vue').default);
// Vue.component('evaluator-table', require('./components/EvaluatorTable.vue').default);
// Vue.component('student-table', require('./components/StudentTable.vue').default);
Vue.component('call-board', CallBoard);
Vue.component('student-table', StudentTable);

const app = new Vue({
    el: '#app'
});
