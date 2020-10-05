<template>
  
</template>

<script>

import UserService from '../../services/UserService';

export default {
    data() { 
        return {
            columns: [
                { name: 'usr_id', label: 'ID', field: 'usr_id', align: 'left' },
                { name: 'usr_cpf', label: 'CPF', field: 'usr_cpf', align: 'left' },
                { name: 'usr_ativo', label: 'ATIVO', field: 'usr_ativo', align: 'left' },
                { name: 'usr_tipo', label: 'TIPO', field: 'usr_tipo', align: 'left' },
            ],
            users: []
        }
    },
    components: {
        
    },
    mounted() {
        UserService.getUsers().then(
            response => {
                this.users = response.data.body.map((user) => {
                    return { ...user, usr_tipo: user.usr_tipo.tipo_descricao }
                });
            }
        ).catch(
            error => {

            }
        )
    }
}
</script>

<style>

</style>