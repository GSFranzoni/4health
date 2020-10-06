<template>
  <q-card class="q-ma-sm">
    <q-card-section>
      <div class="text-h5 text-primary">Cadastro de usuário</div>
    </q-card-section>
    <q-card-section>
      <q-input class="q-mb-sm" outlined v-model="usuario.cpf" label="Cpf" />
      <q-input
        class="q-mb-sm"
        type="password"
        outlined
        v-model="usuario.senha"
        label="Senha"
      />
    </q-card-section>
    <q-card-actions align="right">
      <q-btn @click="back" flat color="grey-9" label="Voltar" />
      <q-btn
        @click="id ? edit() : save()"
        class="q-ma-sm"
        color="primary"
        label="Salvar"
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import UsuarioService from "../../services/UsuarioService";
import Notification from "../../util/Notification";

export default {
  props: ["id", "medico", "paciente"],
  data() {
    return {
      mode: "save",
      usuario: {
        cpf: "",
        senha: "",
      },
    };
  },
  methods: {
    save() {
      if (this.medico) {
        return UsuarioService.insertMedico(this.medico, this.usuario)
          .then(Notification.positive)
          .catch(Notification.negative);
      }
      UsuarioService.insertPaciente(this.paciente, this.usuario)
        .then(Notification.positive)
        .catch(Notification.negative);
    },
    edit() {
      UsuarioService.update(this.id, this.usuario)
        .then(Notification.positive)
        .catch(Notification.negative);
    },
    back() {
      this.$router.go(-1);
    },
  },
  mounted() {
    if (!this.id) {
      return;
    }
    UsuarioService.get(this.id).then((response) => {
      this.usuario = {
        cpf: response.data.body.cpf,
        senha: "",
      };
    });
  },
};
</script>

<style>
</style>