import axios from 'axios';

export default {

    get: (id) => {
        return axios.get(`usuarios/${id}`);
    },
    update: (id, usuario) => {
        return axios.put(`usuarios/${id}`, usuario);
    },
    insertMedico: (medico, usuario) => {
        return axios.post(`medicos/${medico}/usuario`, { ...usuario });
    },
    insertPaciente: (paciente, usuario) => {
        return axios.post(`pacientes/${paciente}/usuario`, { ...usuario });
    }
     
};