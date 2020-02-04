import axios from "axios";

const state = {
    employeeList: [],
    lastId: null
};

const mutations = {
    SET_EMPLOYEELIST: ( state, payload ) => {
        state.employeeList = payload;
    },
    SET_LAST_ID: (state, payload) => {
        state.lastId = payload;
    }
};

const getters = {
    EMPLOYEELIST: ( state ) => {
        return state.employeeList;
    },
    CURRENT_CALL: (state) => {
        return state.lastId;
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
        axios.delete(urlCallDelete)
             .then(resp => {
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
                 console.log("ADD_CALL");
                 console.log(response);
                 context.commit("SET_LAST_ID", response.data.id);
                 context.dispatch("GET_EMPLOYEELIST", payload.employeezerrendaid)
             })
             .catch(e => {
                 console.log("HORROR!!!");
                 this.errors.push(e);
             });
    },
    UPDATE_CALL: async (context, payload) => {
        console.log("XIEEEEEEEEEEEErrrrrrrrrrrrr");
        console.log(payload);
        // const putUrl = "/api/calls/" + payload.id + '?XDEBUG_SESSION_START=PHPSTORM';
        const putUrl = "/api/calls/" + payload.id ;
        axios.put(putUrl, {
            typeid: payload.valueCallStatus
        }).then( response => {
            console.log(response);
            context.dispatch("GET_EMPLOYEELIST", payload.zerrendaid)
        }).catch( e => {
            console.log(e);
        })
    }
};

export default {
    state,
    mutations,
    getters,
    actions
}
