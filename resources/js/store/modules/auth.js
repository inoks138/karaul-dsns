const LOCAL_STORAGE_USER_TOKEN_KEY = 'user_token';

export default {
    namespaced: false,

    state: {
        user: {
            token: localStorage.getItem(LOCAL_STORAGE_USER_TOKEN_KEY) ?? "",
            id: null,
            name: "",
            role: {},
            employee: {},
        },
        isLoadedUserInfo: false,
        guard: {
            id: null,
            startTime: null,
        },
        isLoadedGuard: false,
    },

    mutations: {
        setUserToken(state, token) {
            localStorage.setItem(LOCAL_STORAGE_USER_TOKEN_KEY, token);
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

            state.user.token = token;
        },
        setUserInfo(state, userInfo) {
            state.user.id = userInfo.id;
            state.user.name = userInfo.name;
            state.user.role = userInfo.role;
            state.user.employee = userInfo.employee;
        },
        setIsLoadedUserInfo(state, value) {
            state.isLoadedUserInfo = value;
        },
        setGuard(state, guard) {
            state.guard.id = guard.id;
            state.guard.startTime = guard.start_time;
        },
        setIsLoadedGuard(state, value) {
            state.isLoadedGuard = value;
        },
    },

    getters: {
        getIsLoadedUserInfo(state) {
            return state.isLoadedUserInfo;
        },
        getIsLoadedGuard(state) {
            return state.isLoadedGuard;
        },
    },

    actions: {
        login({}, payload) {
            return axios.post('/login', payload);
        },
        getUserInfo() {
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
