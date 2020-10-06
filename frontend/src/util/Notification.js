import { Notify } from 'quasar';
import { Loading } from 'quasar';

export default {
    positive(response) {
        Notify.create({
            type: 'positive',
            message: response.data.message
        });
        Loading.hide();
    },
    negative(error) {
        Notify.create({
            type: 'negative',
            message: error.response.data.message
        });
        Loading.hide();
    }
}