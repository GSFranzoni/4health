import axios from 'axios';

export default {

    insert: (solicitacao) => {
        return axios.post('http://localhost:8100/solicitacoes', solicitacao);
    },
    getByMedico: (medico) => {
        return axios.get(`http://localhost:8100/medicos/${medico}/solicitacoes`);
    },
    update: (id, solicitacao) => {
        return axios.put(`http://localhost:8100/solicitacoes/${id}`, solicitacao);
    }
    
};