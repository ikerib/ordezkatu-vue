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
        let { data } = await axios.get(urlZerrendaEmployee);
        context.commit("SET_EMPLOYEELIST", data);
    },
    REMOVE_CALL: async ( context, payload ) => {
        console.log("REMOVINGGGG");
        // const urlCallDelete = Routing.generate("delete_calls", payload);
        const urlCallDelete = '/api/calls/' + payload.callid;
        console.log(urlCallDelete);
        axios.delete(urlCallDelete)
             .then(resp => {
                 // this.rowData.splice(index, -1)
                 context.dispatch("GET_EMPLOYEELIST", payload.zerrendaid);
             })
             .catch(error => {
                 console.log(error);
             })
    },
    ADD_CALL: async (context, payload) => {
        const postCallUrl = "/api/calls";
        axios.post(postCallUrl, payload)
             .then(response => {
                 console.log(response);
                 console.log("XIEEEEEEEEEEEEEE");
                 context.dispatch("GET_EMPLOYEELIST", payload.employeezerrendaid);
             })
             .catch(e => {
                 console.log("HORROR!!!");
                 this.errors.push(e);
             });
    }

};

export default {
    state,
    mutations,
    getters,
    actions
}
