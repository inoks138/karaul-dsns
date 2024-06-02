export const getEmployees = (params) => {
    return axios.get('/api/employees', {
        params,
    });
};
