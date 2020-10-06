import axios from 'axios';

export default {

    get: (id) => {
        return axios.get(`http://localhost:8100/usuarios/${id}`);
    },
    update: (id, usuario) => {
        return axios.put(`http://localhost:8100/usuarios/${id}`, usuario);
    },
    insertMedico: (medico, usuario) => {
        return axios.post(`http://localhost:8100/medicos/${medico}/usuario`, { ...usuario });
    },
    insertPaciente: (paciente, usuario) => {
        return axios.post(`http://localhost:8100/pacientes/${paciente}/usuario`, { ...usuario });
    }
     
};