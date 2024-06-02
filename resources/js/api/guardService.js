export const getCurrentGuard = () => {
    return axios.get('/api/guards/current');
};

export const startGuard = (payload) => {
    return axios.post('/api/guards', payload);
};

export const storeUnits = (guardId, payload) => {
    return axios.post(`/api/guards/${guardId}/create-units`, payload);
};
