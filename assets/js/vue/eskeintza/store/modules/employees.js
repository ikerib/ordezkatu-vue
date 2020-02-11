import axios from "axios";

const state = {
    availableEmployees: [],
    selectedEmployeeList: []
};

const mutations = {
    SET_EMPLOYEELIST: ( state, payload ) => {
        console.log("Mutation SET_EMPLOYEELIST");
        state.availableEmployees = payload;
    },
    SET_SELECTED_EMPLOYEELIST: ( state, payload ) => {
        console.log("MUTATION SET_SELECTED_EMPLOYEELIST");
        if (state.selectedEmployeeList.some(el => el.id === payload.id) === false) {
        // if ( state.selectedEmployeeList.includes(payload) === false ) {
            console.log('Ez dago zerrendan, gehitzen....');
            state.selectedEmployeeList.push(payload);
        } else {
            console.log("Zerrendan dago, ezabatzen...");
            console.log(payload);
            // state.selectedEmployeeList.splice(state.selectedEmployeeList.indexOf(payload), 1)
            const removeIndex = state.selectedEmployeeList.map(item => {
                return item.id;
            }).indexOf(payload.id);
            state.selectedEmployeeList.splice(removeIndex, 1);
        }
    },
    REMOVE_SELECTED_EMPLOYEELIST: (state, payload) => {
        console.log("MUTATION REMOVE_SELECTED_EMPLOYEELIST");

        const removeIndex = state.selectedEmployeeList.map(item => {
            return item.id;
        }).indexOf(payload.id);
        state.selectedEmployeeList.splice(removeIndex, 1);

    }
};

const getters = {
    EMPLOYEELIST: ( state ) => {
        console.log("GETTER EMPLOYEELIST");
        return state.availableEmployees;
    },
    SELECTEDEMPLOYEELIST: ( state ) => {
        console.log("GETTER SELECTEDEMPLOYEELIST");
        return state.selectedEmployeeList;
    },
    IS_SELECTED: (state) => (payload) => {
        return state.selectedEmployeeList.some(el => el.id === payload.id)
    }
};

const actions = {
    GET_EMPLOYEELIST: async ( context, payload ) => {
        console.log("ACTION GET_EMPLOYEELIST");
        const urlZerrendaEmployee = Routing.generate("get_employeezerrenda", { "zerrendaid": payload.zerrendaid });
        let { data } = await axios.get(urlZerrendaEmployee);
        // filter by Type
        console.log("FILTRO GABE");
        console.log(data);
        if ( payload.typeid !== "-1" ) {
            const filtered = data.filter(function ( d ) {
                console.log(d.type.id);
                console.log(typeof (d.type.id));
                console.log(payload.typeid);
                console.log(typeof (payload.typeid));
                return d.type.id.toString() === payload.typeid;
                // console.log(d);
                // return false
            });
            console.log("FILTRATUTA");
            console.log(filtered);
            context.commit("SET_EMPLOYEELIST", filtered);
        } else {
            context.commit("SET_EMPLOYEELIST", data);
        }


    },
    UPDATE_SELECTED_EMPLOYEELIST: (context, payload) => {
        console.log("UPDATE_SELECTED_EMPLOYEELIST");
        context.commit("SET_SELECTED_EMPLOYEELIST", payload)
    }
};

export default {
    state,
    mutations,
    getters,
    actions
}
