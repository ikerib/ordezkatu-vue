import axios from "axios";
import Swal from "sweetalert2";

const state = {
    availableEmployees: [],
    selectedEmployeeList: [],
    job: null
};

const mutations = {
    MUTATION_SET_JOBID: (state, payload) => {
        state.jobid = payload;
    },
    MUTATION_SET_SELECTED_EMPLOYEES: (state, payload) => {
        state.selectedEmployeeList = payload;
    },
    MUTATION_SET_EMPLOYEELIST: ( state, payload ) => {
        state.availableEmployees = payload;
    },
    MUTATION_REMOVE_EMPLOYEE_FROM_LIST: (state, payload) => {
        const removeIndex = state.selectedEmployeeList.map(item => {
            return item.id;
        }).indexOf(payload.id);
        state.selectedEmployeeList.splice(removeIndex, 1);
    }
};

const actions = {
    ACTION_GET_JOB: async (state, jobid) => {
        const urlJobDetails = Routing.generate("get_job", { 'id': jobid});
        let { data } = await axios.get(urlJobDetails);
        state.job = data;
        const arrSelected= data.jobDetails.map(item => {
            return item
        });
        state.commit("MUTATION_SET_SELECTED_EMPLOYEES", arrSelected);
    },
    ACTION_REMOVE_EMPLOYEE_FROM_LIST: async( state, payload ) => {
        console.log("ACTION_REMOVE_EMPLOYEE_FROM_LIST");
        const removeURL = Routing.generate("delete_jobdetail", { "id": payload.id });
        try {
            let res = await axios.delete(removeURL);
            if ( res.status === 204 ) {
                 Swal.fire({
                     position: "top-end",
                     icon: "success",
                     title: "Aldaketak ongi gorde dira",
                     showConfirmButton: false,
                     timer: 1000
                 });
                 state.dispatch('ACTION_GET_JOB', state.getters.GET_JOBID)
            }
        } catch ( e ) {
             console.log(e);
             Swal.fire({
                 icon: 'error',
                 title: 'Oops...',
                 text: 'Arazo bat egon da. Jarri harremanetan informatika sailarekin'
             })
        }
    },
    ACTION_ADD_REMOVE_EMPLOYEE_TO_LIST: async (context,payload) => {
        if (state.selectedEmployeeList.some(el => el.id === payload.id) === false) {
            // console.log('Ez dago zerrendan, gehitzen....');
            // POST
            const urlParams = {
                "id": state.jobid,
                "": "?XDEBUG_SESSION_START=PHPSTORM"
            };
            const postUrl = Routing.generate('post_job_add_employee', urlParams );
            const sendData = {
                employeeid: payload.employee.id,
                position: payload.position
            };

            axios.post(postUrl, sendData)
                 .then(response => {
                     state.selectedEmployeeList.push(payload);
                 })
                 .catch(e => {
                     Swal.fire({
                         icon: "error",
                         title: "Oops...",
                         text: "Arazo bat egon da. Jarri harremanetan informatika sailarekin"
                     });
                     console.log(e)
                 });

        } else {
            console.log("Zerrendan dago, ezabatzen...");
            console.log(payload);

            // const removeURL = Routing.generate('delete_jobdetail', { 'id': payload.jobdetailid});
            // const removeIndex = state.selectedEmployeeList.map(item => {
            //     return item.id;
            // }).indexOf(payload.id);
            // state.selectedEmployeeList.splice(removeIndex, 1);
        }
    },
    ACTION_GET_EMPLOYEELIST: async ( context, payload ) => {
        console.log("ACTION ACTION_GET_EMPLOYEELIST");
        const urlZerrendaEmployee = Routing.generate("get_employeezerrenda", { "zerrendaid": payload.zerrendaid });
        let { data } = await axios.get(urlZerrendaEmployee);
        // filter by Type
        if ( payload.typeid !== "-1" ) {
            const filtered = data.filter(function ( d ) {
                return d.type.id.toString() === payload.typeid;
            });
            context.commit("MUTATION_SET_EMPLOYEELIST", filtered);
        } else {
            context.commit("MUTATION_SET_EMPLOYEELIST", data);
        }


    },
    UPDATE_SELECTED_EMPLOYEELIST: (context, payload) => {
        console.log("UPDATE_SELECTED_EMPLOYEELIST");
        context.commit("SET_SELECTED_EMPLOYEELIST", payload)
    },
    INITIAL_SELECTED_EMPLOYEE: (context, payload) => {
        console.log("INITIAL_SELECTED_EMPLOYEE");
        console.log(payload);
        context.commit("SET_INITIAL_SELECTED_EMPLOYEELIST", payload)
    }
};

const getters = {
    GET_JOBID: (state) => {
        return state.jobid;
    },
    GET_EMPLOYEELIST: ( state ) => {
        return state.availableEmployees;
    },
    GET_SELECTEDEMPLOYEELIST: ( state ) => {
        return state.selectedEmployeeList;
    },
    GET_IS_SELECTED: (state) => (payload) => {
        return state.selectedEmployeeList.some(el => el.employee.id === payload.id)
    }
};

export default {
    state,
    mutations,
    getters,
    actions
}
