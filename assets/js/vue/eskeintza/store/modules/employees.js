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
    }
};

const actions = {
    ACTION_DO_CHANGE_POSITION: async ( state, payload ) => {
        try {
            const putURL = Routing.generate("put_job_detail_set_position", { 'id': payload.jobdetail.id});
            const myData = {
                position: payload.position
            };
            let res = await axios.put(putURL, myData);
            if ( res.status === 201 ) {
                const jobid = state.getters.GET_JOBID;
                state.dispatch('ACTION_GET_JOB', jobid)
            }
        } catch ( e ) {
            await Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Arazo bat egon da. Jarri harremanetan informatika sailarekin"
            });
            console.log(e)
        }
    },
    ACTION_DO_CHECK_ALL: ( state) => {
        const available = state.getters.GET_AVAILABLEEMPLOYEEELIST;
        available.forEach(item => {
            state.dispatch('ACTION_ADD_REMOVE_EMPLOYEE_TO_LIST', item)
        })
    },
    ACTION_GET_JOB: async (state, jobid) => {
        const urlJobDetails = Routing.generate("get_job", { 'id': jobid});
        let { data } = await axios.get(urlJobDetails);
        state.job = data;
        const arrSelected= data.jobDetails.map(item => {
            return item
        }).sort((a,b) => {
            if ( a.position > b.position ) { return 1}
            if ( a.position < b.position ) { return -1}
            return 0;
        });
        state.commit("MUTATION_SET_SELECTED_EMPLOYEES", arrSelected);
    },
    ACTION_REMOVE_EMPLOYEE_FROM_LIST: async( state, payload ) => {
        console.log("ACTION_REMOVE_EMPLOYEE_FROM_LIST");
        const removeURL = Routing.generate("delete_jobdetail", { "id": payload.id });
        try {
            let res = await axios.delete(removeURL);
            if ( res.status === 204 ) {
                 await Swal.fire({
                     position: "top-end",
                     icon: "success",
                     title: "Aldaketak ongi gorde dira",
                     showConfirmButton: false,
                     timer: 300
                 });
                 state.dispatch('ACTION_GET_JOB', state.getters.GET_JOBID)
            }
        } catch ( e ) {
            console.log(e);
            await Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Arazo bat egon da. Jarri harremanetan informatika sailarekin"
            });
        }
    },
    ACTION_ADD_REMOVE_EMPLOYEE_TO_LIST: async (context,payload) => {
        if (state.selectedEmployeeList.some(el => el.employee.id === payload.employee.id) === false) {
            const urlParams = {
                "id": state.jobid,
                "": "?XDEBUG_SESSION_START=PHPSTORM"
            };
            const postUrl = Routing.generate('post_job_add_employee', urlParams );
            const sendData = {
                employeeid: payload.employee.id,
                position: payload.position ? payload.position : null
            };

            try {
                let res = await axios.post(postUrl, sendData);
                if ( res.status === 201 ){
                    context.dispatch('ACTION_GET_JOB', context.getters.GET_JOBID)
                }
            } catch ( e ) {
                await Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Arazo bat egon da. Jarri harremanetan informatika sailarekin"
                });
                console.log(e)
            }

        } else {
            // find jobdetail for selected employee
            let jobdetailidToRemove = context.getters.GET_SELECTEDEMPLOYEELIST;
            let miid = jobdetailidToRemove.filter( item => {
                if (payload.employee.id === item.employee.id) {
                    return item
                }
            });
            const myData = {
                id: miid[0].id
            };
            context.dispatch("ACTION_REMOVE_EMPLOYEE_FROM_LIST", myData);

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
    GET_AVAILABLEEMPLOYEEELIST: ( state ) => {
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
