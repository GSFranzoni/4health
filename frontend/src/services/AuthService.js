import axios from 'axios';

export default {

    login: (cpf, senha) => {
        return axios.post('usuarios/auth', {
            cpf, senha
        });
    },
    me: (token) => {
        return axios.post('usuarios/me', {
            token
        });
    }
    
};