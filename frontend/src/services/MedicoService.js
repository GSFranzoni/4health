import axios from 'axios';

export default {

    getAll: () => {
        return axios.get('http://localhost:8100/medicos');
    }
    
};