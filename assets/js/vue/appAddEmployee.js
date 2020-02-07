import Vue from 'vue';
import App from './AppAddEmployee';

import  store  from './store/store'

import moment from 'moment'

Vue.filter("formatDate", function ( value ) {
    if ( value ) {
        return moment(String(value)).format("DD/DD/YYYY HH:MM:SS");
    }
});

const app = new Vue({
    el: '#app',
    store,
    render: h => h(App)
});
