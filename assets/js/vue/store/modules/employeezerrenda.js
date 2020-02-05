import axios from "axios";

const state = {
    employeeList: [],
    lastId: null,
    isCalling: false,
    show: false,
    valueCallStatus: null,
    notes: null
};

const mutations = {
    SET_EMPLOYEELIST: ( state, payload ) => {
        state.employeeList = payload;
    },
    SET_LAST_ID: (state, payload) => {
        state.lastId = payload;
    },
    SET_SHOW: (state, payload) => {
        console.log('Mutation show');
        console.log(payload);
        state.show = !state.show;
        state.valueCallStatus = payload.valueCallStatus;
        console.log(state.valueCallStatus);
        state.notes = payload.notes;
    },
    SET_CALL_STATUS: (state, payload) => {
        console.log("Mutation call status");
        state.valueCallStatus = payload;
    },
    SET_NOTES: (state, payload) => {
        console.log("Mutation notes");
        state.notes = payload;
    }
};

const getters = {
    EMPLOYEELIST: ( state ) => {
        return state.employeeList;
    },
    CURRENT_CALL: (state) => {
        return state.lastId;
    },
    SHOW: (state) => {
        return state.show;
    },
    VALUE_CALL_STATUS: (state) => {
        return state.valueCallStatus;
    },
    NOTES: (state) => {
        return state.notes;
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
        console.log("ADD_CALL");
        console.log(payload);
        const postCallUrl = "/api/calls?XDEBUG_SESSION_START=PHPSTORM";
        axios.post(postCallUrl, payload)
             .then(response => {
                 console.log("ADD_CALL response");
                 console.log(response);
                 context.commit("SET_LAST_ID", response.data.id);
                 context.dispatch("GET_EMPLOYEELIST", payload.zerrendaid)
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
            typeid: payload.valueCallStatus,
            notes: payload.notes
        }).then( response => {
            console.log(response);
            context.dispatch("GET_EMPLOYEELIST", payload.zerrendaid)
        }).catch( e => {
            console.log(e);
        })
    },
    TOOTGLE_SHOW: (context, payload) => {
        console.log('Action Toogle show');
        console.log(payload);
        context.commit('SET_SHOW', payload)
    },
    UPDATE_LAST_ID : (context, payload) => {
        console.log("Action UPDATE_LAST_ID:" + payload.id);
        context.commit('SET_LAST_ID', payload.id)
    },
    UPDATE_CALL_STATUS: (context, payload) => {
        console.log("Action UPDATE_CALL_STATUS");
        context.commit('SET_CALL_STATUS', payload)
    },
    UPDATE_NOTES: (context, payload) => {
        console.log("Action UPDATE_NOTES");
        context.commit('SET_NOTES', payload)
    }
};

export default {
    state,
    mutations,
    getters,
    actions
}
