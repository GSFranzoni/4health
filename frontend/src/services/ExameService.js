import axios from 'axios';

export default {

    getByPaciente: (paciente) => {
        return axios.get(`pacientes/${paciente}/exames`);
    },
    getByMedico: (medico) => {
        return axios.get(`medicos/${medico}/exames`);
    },
    insert: (exame) => {
        return axios.post(`exames`, exame);
    },
    update: (id, exame) => {
        return axios.put(`exames/${id}`, exame);
    }
    
};