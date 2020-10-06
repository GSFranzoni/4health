import axios from 'axios';

export default {

    getByPaciente: (paciente) => {
        return axios.get(`http://localhost:8100/pacientes/${paciente}/exames`);
    }
    
};