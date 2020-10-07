import axios from 'axios';

export default {

    getAll: () => {
        return axios.get(`medicos`);
    },
    get: (id) => {
        return axios.get(`medicos/${id}`);
    },
    getDisponiveis: () => {
        return axios.get(`medicos/disponiveis`);
    },
    insert: (medico) => {
        return axios.post(`medicos`, medico);
    },
    update: (id, medico) => {
        return axios.put(`medicos/${id}`, medico);
    },
    delete: (id) => {
        return axios.delete(`medicos/${id}`);
    }
    
};