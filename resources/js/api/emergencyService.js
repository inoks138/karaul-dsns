export const getEmergencies = () => {
    return axios.get(`/api/emergencies`);
};

export const getEmergency = (emergencyId) => {
    return axios.get(`/api/emergencies/${emergencyId}`);
};

export const acceptLiquidation = (emergencyId) => {
    return axios.post(`/api/emergencies/${emergencyId}/accept-liquidation`);
};

export const declineLiquidation = (emergencyId, payload) => {
    return axios.post(`/api/emergencies/${emergencyId}/decline-liquidation`, payload);
};

export const closeLiquidation = (emergencyId) => {
    return axios.post(`/api/emergencies/${emergencyId}/close`);
};

export const syncLiquidations = (emergencyId, payload) => {
    return axios.post(`/api/emergencies/${emergencyId}/sync-liquidations`, payload);
}

export const getEmergencyComments = (emergencyId) => {
    return axios.get(`/api/emergencies/${emergencyId}/comments`);
}

export const storeEmergencyComment = (emergencyId, payload) => {
    return axios.post(`/api/emergencies/${emergencyId}/comments`, payload);
}
