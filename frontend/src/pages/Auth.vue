<template>
  <q-layout>
    <q-page-container>
      <q-page padding class="row justify-center items-center">
        <q-form @submit="login" class="col-sm-5 col-md-3 col-10">
          <q-card class="q-dialog-plugin" style="width: 100%">
          <q-card-section>
            <div class="text-primary text-h5">Login</div>
          </q-card-section>
          <q-card-section>
            <q-input
              outlined
              v-model="cpf"
              type="text"
              label="Cpf"
              class="q-mb-sm"
              :rules="[(val) => (val && val.length > 13) || 'Preencha o cpf']"
              mask="###.###.###-##"
            />
            <q-input
              outlined
              v-model="senha"
              type="password"
              label="Senha"
              :rules="[
                (val) =>
                  val.length > 7 || 'A senha precisa ter 8 caracteres ou mais',
              ]"
            />
          </q-card-section>
          <q-card-actions align="right">
            <q-btn
              type="submit"
              color="primary"
              label="Entrar"
              class="q-mb-sm q-mr-sm"
            />
          </q-card-actions>
        </q-card>
        </q-form>
        
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script>
import AuthService from "../services/AuthService.js";
import axios from "axios";
import Notification from "../util/Notification";

export default {
  data() {
    return {
      cpf: "140.526.066-12",
      senha: "12345678",
    };
  },
  mounted() {},
  methods: {
    login() {
      AuthService.login(this.cpf, this.senha)
        .then((response) => {
          const { token, usuario } = response.data;
          this.$store.commit("setUsuario", usuario);
          localStorage.setItem("token", token);
          Notification.positive(response);
          this.$router.push("/");
        })
        .catch(Notification.negative);
    },
  },
};
</script>

<style>
</style>