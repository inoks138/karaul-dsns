export const getCurrentGuard = () => {
    return axios.get('/api/guards/current');
};

export const startGuard = (payload) => {
    return axios.post('/api/guards', payload);
};

export const storeUnits = (guardId, payload) => {
    return axios.post(`/api/guards/${guardId}/create-units`, payload);
};

export const createVehicleNotes = (guardId, payload) => {
    return axios.post(`/api/guards/${guardId}/create-vehicle-notes`, payload);
};

export const getInternalServiceTypes = () => {
    return axios.get('/api/guards/internal-service-types');
};

export const getEndGuardData = (guardId) => {
    return axios.get(`/api/guards/${guardId}/end-guard-data`);
};

export const endGuard = (guardId, payload) => {
    return axios.post(`/api/guards/${guardId}/end-guard`, payload);
}
