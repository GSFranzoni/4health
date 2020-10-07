import axios from 'axios';

export default {

    insert: (solicitacao) => {
        return axios.post(`solicitacoes`, solicitacao);
    },
    getByMedico: (medico) => {
        return axios.get(`medicos/${medico}/solicitacoes`);
    },
    update: (id, solicitacao) => {
        return axios.put(`solicitacoes/${id}`, solicitacao);
    }
    
};