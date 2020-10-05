<template>
  <q-layout>
    <q-page-container>
      <q-page padding class="row justify-center items-center">
        <q-card class="col-sm-6 col-md-4 col-12">
          <q-card-section>
              <div class="text-primary text-h5">Login</div>
          </q-card-section>
          <q-card-section>
            <q-input outlined v-model="cpf" type="text" label="Cpf" class="q-mb-sm"/>
            <q-input outlined v-model="senha" type="password" label="Senha" />
          </q-card-section>
          <q-card-actions align="right">
              <q-btn @click="login" color="primary" label="Entrar" class="q-mb-sm q-mr-sm" />
          </q-card-actions>
        </q-card>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import AuthService from '../services/AuthService.js';

export default {
    data() {
        return {
            cpf: '140.526.066.12',
            senha: '12345678'
        }
    },
    mounted() {
      
    },
    methods: {
        login() {
            AuthService.login(this.cpf, this.senha).then(
                response => {
                    const { token, usuario } = response.data;
                }
            ).catch(
                err => {
                    console.log(err);
                }
            );
        }
    }
};
</script>

<style>
</style>