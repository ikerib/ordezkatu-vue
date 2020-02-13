import axios from "axios";
import Swal from "sweetalert2";

const state = {
    employeeList: [],
    allEmployeeList: [],
    lastId: null,
    isCalling: false,
    show: false,
    valueCallStatus: null,
    notes: null,
    filterCallStatus: null
};

const mutations = {
    SET_EMPLOYEELIST: ( state, payload ) => {
        if (( state.filterCallStatus === "-1" ) || (state.filterCallStatus === null) ){
            state.employeeList = payload;
            state.allEmployeeList = payload;
        } else if (state.filterCallStatus === "0") {
            state.employeeList = state.allEmployeeList.filter(item => {
                return !item.lastErantzuna;
            });
        } else {
            state.employeeList = state.allEmployeeList.filter(item => {
                return item.lastErantzuna.id.toString() === state.filterCallStatus.toString();
            });
        }
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
    },
    SET_FILTER_CALL_STATUS: (state, payload) => {
        state.filterCallStatus = payload;
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
    },
    GET_FILER_CALL_STATUS: (state) => {
        return state.filterCallStatus
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
                 Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Arazo bat egon da. Jarri harremanetan informatika sailarekin'
                 })
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
                 Swal.fire({
                     icon: "error",
                     title: "Oops...",
                     text: "Arazo bat egon da. Jarri harremanetan informatika sailarekin"
                 });
                 console.log(e)
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
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Arazo bat egon da. Jarri harremanetan informatika sailarekin'
            })
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
