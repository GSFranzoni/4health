import axios from 'axios';

export default {

    login: (cpf, senha) => {
        return axios.post('http://localhost:8100/usuarios/auth', {
            cpf, senha
        });
    }
    
};