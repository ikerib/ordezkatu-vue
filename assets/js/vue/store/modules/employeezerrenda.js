import axios from "axios";

const state = {
    employeeList: [],
    lastId: null,
    isCalling: false,
    show: false
};

const mutations = {
    SET_EMPLOYEELIST: ( state, payload ) => {
        state.employeeList = payload;
    },
    SET_LAST_ID: (state, payload) => {
        state.lastId = payload;
    },
    SET_SHOW: (state) => {
        console.log('Mutation show');
        state.show = !state.show;
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
    },
    TOOTGLE_SHOW: (context) => {
        console.log('Action Toogle show');
        context.commit('SET_SHOW')
    },
    UPDATE_LAST_ID : (context, payload) => {
        console.log("Action UPDATE_LAST_ID:" + payload);
        context.commit('SET_LAST_ID', payload)
    }
};

export default {
    state,
    mutations,
    getters,
    actions
}
