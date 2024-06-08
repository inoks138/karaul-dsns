import {getEmergencies} from "../../api/emergencyService";

export default {
    namespaced: false,

    state: {
        emergencies: [],
        isLoadingEmergencies: false,
    },

    mutations: {
        setEmergencies(state, emergencies) {
            state.emergencies = emergencies;
        },
        setIsLoadingEmergencies(state, value) {
            state.isLoadedUserInfo = value;
        },
    },

    getters: {
        getEmergencies(state) {
            return state.emergencies;
        },
        getIsLoadingEmergencies(state) {
            return state.isLoadingEmergencies;
        },
    },

    actions: {
        fetchEmergencies({commit}) {
            commit('setIsLoadingEmergencies', true);

            getEmergencies()
                .then(response => {
                    commit('setEmergencies', response.data);
                })
                .finally(() => {
                    commit('setIsLoadingEmergencies', false);
                });
        },
        setIsAcceptedByYd({state}, payload) {
            const {id, value} = payload;

            const index = state.emergencies.findIndex(item => item.id === id);

            if (index !== -1) {
                const newEmergency = state.emergencies[index];

                newEmergency.liquidation_request.is_accepted = value;

                Vue.set(state.emergencies, index, newEmergency);
            }
        }
    },
};
