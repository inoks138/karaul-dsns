export const getVehicles = (params) => {
    return axios.get('/api/vehicles', {
        params,
    });
};
