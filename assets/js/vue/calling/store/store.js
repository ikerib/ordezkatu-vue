import Vue from "vue";
import Vuex from "vuex";

import employeezerrenda from "./modules/employeezerrenda";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        employeezerrenda
    }
});
