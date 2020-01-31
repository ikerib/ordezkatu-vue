import axios from "axios";

const state = {
    employeeList: []
};

const mutations = {
    SET_EMPLOYEELIST: ( state, payload ) => {
        state.employeeList = payload;
    }
};

const getters = {
    EMPLOYEELIST: ( state ) => {
        return state.employeeList;
    }
};

const actions = {
    GET_EMPLOYEELIST: async ( context, payload ) => {
        const urlZerrendaEmployee = Routing.generate("get_employeezerrenda", { "zerrendaid": payload });
        console.log("URIL");
        console.log(urlZerrendaEmployee);

        let { data } = await axios.get(urlZerrendaEmployee);
        context.commit("SET_EMPLOYEELIST", data);
    }
};

export default {
    state,
    mutations,
    getters,
    actions
}
