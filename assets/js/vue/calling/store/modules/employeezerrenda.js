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
        state.show = !state.show;
        state.valueCallStatus = payload.valueCallStatus;
        state.notes = payload.notes;
    },
    SET_CALL_STATUS: (state, payload) => {
        state.valueCallStatus = payload;
    },
    SET_NOTES: (state, payload) => {
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
        const urlZerrendaEmployee = Routing.generate("get_job", { "id": payload });
        let { data } = await axios.get(urlZerrendaEmployee);
        context.commit("SET_EMPLOYEELIST", data.jobDetails);
    },
    REMOVE_CALL: async ( context, payload ) => {
        // const urlCallDelete = Routing.generate("delete_calls", payload);
        const urlCallDelete = '/api/calls/' + payload.callid;
        axios.delete(urlCallDelete)
             .then(resp => {
                 context.dispatch("GET_EMPLOYEELIST", payload.jobid);
             })
             .catch(error => {
                 console.log(error);
             })
    },
    ADD_CALL: async (context, payload) => {
        const postCallUrl = "/api/calls?XDEBUG_SESSION_START=PHPSTORM";
        axios.post(postCallUrl, payload)
             .then(response => {
                 context.commit("SET_LAST_ID", response.data.id);
                 context.dispatch("GET_EMPLOYEELIST", payload.jobid)
             })
             .catch(e => {
                 console.log("HORROR!!!");
                 this.errors.push(e);
             });
    },
    UPDATE_CALL: async (context, payload) => {
        // const putUrl = "/api/calls/" + payload.id + '?XDEBUG_SESSION_START=PHPSTORM';
        const putUrl = "/api/calls/" + payload.id ;
        axios.put(putUrl, {
            erantzunaid: payload.valueCallStatus,
            notes: payload.notes
        }).then( response => {
            context.dispatch("GET_EMPLOYEELIST", payload.jobid)
        }).catch( e => {
            console.log(e);
        })
    },
    TOOTGLE_SHOW: (context, payload) => {
        context.commit('SET_SHOW', payload)
    },
    UPDATE_LAST_ID : (context, payload) => {
        context.commit('SET_LAST_ID', payload.id)
    },
    UPDATE_CALL_STATUS: (context, payload) => {
        context.commit('SET_CALL_STATUS', payload)
    },
    UPDATE_NOTES: (context, payload) => {
        context.commit('SET_NOTES', payload)
    }
};

export default {
    state,
    mutations,
    getters,
    actions
}
