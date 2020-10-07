import axios from 'axios';

export default {

    getAll: () => {
        return axios.get('http://localhost:8100/pacientes');
    },
    get: (id) => {
        return axios.get(`http://localhost:8100/pacientes/${id}`);
    },
    insert: (paciente) => {
        return axios.post(`http://localhost:8100/pacientes`, paciente);
    },
    update: (id, paciente) => {
        return axios.put(`http://localhost:8100/pacientes/${id}`, paciente);
    },
    delete: (id) => {
        return axios.delete(`http://localhost:8100/pacientes/${id}`);
    },
    anonimizar: () => {
        return axios.post(`http://localhost:8100/paciente/anonimizar`);
    }
    
};