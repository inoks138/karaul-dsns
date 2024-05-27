import axios from "axios";

const LOCAL_STORAGE_USER_TOKEN_KEY = 'user_token'

export default {
    namespaced: false,

    state: {
        user: {
            token: JSON.parse(localStorage.getItem(LOCAL_STORAGE_USER_TOKEN_KEY)) ?? "",
            name: "",
            role: "",
        },
        IsLoadingUserInfo: false,
    },

    mutations: {
        setUserToken(state, token) {
            localStorage.setItem(
                LOCAL_STORAGE_USER_TOKEN_KEY,
                JSON.stringify(token)
            )

            state.user.token = token;
        },
        setUserInfo(state, userInfo) {
            state.user.name = userInfo.name;
            state.user.role = userInfo.role;
        },
        setIsLoadingUserInfo(state, value) {
            state.IsLoadingUserInfo = value;
        },
    },

    getters: {
        getIsLoadingUserInfo(state) {
            return state.IsLoadingUserInfo;
        },
    },

    actions: {
        login({}, payload) {
            return axios.post('/login', payload);
        },
        getUserInfo({}) {
            return axios.get('/auth/user');
        },
        logout() {
            return axios.post('/logout');
        },
        resetUser({state}) {
            state.user.token = "";
            state.user.name = "";
            state.user.role = "";

            localStorage.removeItem(LOCAL_STORAGE_USER_TOKEN_KEY)
        },
    },
};
