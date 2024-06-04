export const getVehicleNoteStates = () => {
    return axios.get('/api/vehicles/notes/states');
};
