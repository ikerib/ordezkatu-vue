import axios from "axios";

const state = {
    calls: []
};

const getters = {
    CALLS: state => {
        return state.calls;
    }
};

const mutations = {
    SET_CALL: ( state, calls ) => {
        console.log("kiki:");
        console.log(calls);
        state.calls = calls;
    },
    ADD_CALL: ( state, payload ) => {
        state.calls.push(payload);
    }
};

const actions = {
    GET_CALLS: async ( context, payload ) => {
        const url = "/api/calls/employeezerrenda/" + payload.zerrendaid + "/" + payload.employeeid;
        let { data } = await axios.get(url);
        console.log("GETCALL:");
        console.log(data);
        context.commit("SET_CALL", data);


    },
    SAVE_TODO: async ( context, payload ) => {
        let { data } = await Axios.post("http://yourwebsite.com/api/todo");
        context.commit("ADD_TODO", payload);
    },
};

export default {
    state,
    mutations,
    getters,
    actions
}
