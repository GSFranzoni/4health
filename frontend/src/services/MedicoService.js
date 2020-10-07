import axios from 'axios';

export default {

    getAll: () => {
        return axios.get('http://localhost:8100/medicos');
    },
    get: (id) => {
        return axios.get(`http://localhost:8100/medicos/${id}`);
    },
    getDisponiveis: () => {
        return axios.get(`http://localhost:8100/medicos/disponiveis`);
    },
    insert: (medico) => {
        return axios.post(`http://localhost:8100/medicos`, medico);
    },
    update: (id, medico) => {
        return axios.put(`http://localhost:8100/medicos/${id}`, medico);
    },
    delete: (id) => {
        return axios.delete(`http://localhost:8100/medicos/${id}`);
    }
    
};