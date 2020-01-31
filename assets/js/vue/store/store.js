import Vue from "vue";
import Vuex from "vuex";

import employeezerrenda from "./modules/employeezerrenda";
import calls from "./modules/calls";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        employeezerrenda,
        calls
    }
});
