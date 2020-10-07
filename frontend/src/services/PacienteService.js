import axios from 'axios';

export default {

    getAll: () => {
        return axios.get(`pacientes`);
    },
    get: (id) => {
        return axios.get(`pacientes/${id}`);
    },
    insert: (paciente) => {
        return axios.post(`pacientes`, paciente);
    },
    update: (id, paciente) => {
        return axios.put(`pacientes/${id}`, paciente);
    },
    delete: (id) => {
        return axios.delete(`pacientes/${id}`);
    },
    anonimizar: () => {
        return axios.post(`paciente/anonimizar`);
    }
    
};