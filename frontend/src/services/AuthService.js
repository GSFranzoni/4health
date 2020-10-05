import axios from 'axios';

export default {

    login: (usr_cpf, usr_senha) => {
        return axios.post('http://localhost:8100/usuarios/auth', {
            usr_cpf, usr_senha
        });
    }
    
};