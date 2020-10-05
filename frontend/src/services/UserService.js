import axios from 'axios';

export default {

    getUsers: () => {
        return axios.get('http://localhost:8100/usuarios');
    }
    
};