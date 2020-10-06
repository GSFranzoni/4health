import axios from 'axios';

export default {

    insert: (solicitacao) => {
        return axios.post('http://localhost:8100/solicitacoes', solicitacao);
    }
    
};