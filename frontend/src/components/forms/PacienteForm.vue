<template>
  <q-card class="q-ma-sm">
    <q-card-section>
      <div class="text-h6">Cadastro de paciente</div>
    </q-card-section>
    <q-card-section>
      <q-input class="q-mb-sm" outlined v-model="paciente.nome" label="Nome" />
      <q-input class="q-mb-sm" outlined v-model="paciente.uf" label="Estado" />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.cidade"
        label="Cidade"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.logradouro"
        label="Logradouro"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.bairro"
        label="Bairro"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.numero_casa"
        label="Número"
      />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="paciente.telefone"
        label="Telefone"
      />
    </q-card-section>
    <q-card-actions align="right">
      <q-btn @click="back" flat color="grey-9" label="Voltar" />
      <q-btn
        @click="id? edit(): save()"
        class="q-ma-sm"
        color="primary"
        label="Salvar"
      />
    </q-card-actions>
  </q-card>
</template>

<script>
import PacienteService from '../../services/PacienteService';
import Notification from '../../util/Notification';

export default {
  props: [ "id" ],
  data() {
    return {
      paciente: {
        nome: "",
        uf: "",
        cidade: "",
        logradouro: "",
        bairro: "",
        numero_casa: "",
        telefone: ""
      },
    };
  },
  methods: {
    save() {
      PacienteService.insert(this.paciente)
        .then(Notification.positive)
        .catch(Notification.negative);
    },
    edit() {
      PacienteService.update(this.id, this.paciente)
        .then(Notification.positive)
        .catch(Notification.negative);
    },
    back() {
      this.$router.go(-1);
    }
  },
  mounted() {
    if(!this.id) {
      return;
    }
    PacienteService.get(this.id).then(
      response => {
        this.paciente = response.data.body;
      }
    );
  },
};
</script>

<style>
</style>