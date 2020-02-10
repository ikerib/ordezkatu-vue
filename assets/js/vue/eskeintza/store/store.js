import Vue from "vue";
import Vuex from "vuex";

import employees from "./modules/employees";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        employees
    }
});
