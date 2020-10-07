import axios from 'axios';

export default {

    getByPaciente: (paciente) => {
        return axios.get(`http://localhost:8100/pacientes/${paciente}/exames`);
    },
    getByMedico: (medico) => {
        return axios.get(`http://localhost:8100/medicos/${medico}/exames`);
    },
    insert: (exame) => {
        return axios.post(`http://localhost:8100/exames`, exame);
    }
    
};