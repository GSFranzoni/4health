<template>
  <q-card class="q-ma-sm">
    <q-card-section>
      <div class="text-h6">Cadastro de médico</div>
    </q-card-section>
    <q-card-section>
      <q-input class="q-mb-sm" outlined v-model="medico.nome" label="Nome" />
      <q-input class="q-mb-sm" outlined v-model="medico.crm" label="Crm" />
      <q-input
        class="q-mb-sm"
        outlined
        v-model="medico.especialidade"
        label="Especialidade"
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
import MedicoService from '../../services/MedicoService';
import Notification from '../../util/Notification';

export default {
  props: ["id"],
  data() {
    return {
      medico: {
        nome: "",
        crm: "",
        especialidade: ""
      },
    };
  },
  methods: {
    save() {
      MedicoService.insert(this.medico)
        .then(Notification.positive)
        .catch(Notification.negative);
    },
    edit() {
      MedicoService.update(this.id, this.medico)
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
    MedicoService.get(this.id).then(
      response => {
        this.medico = {
          nome: response.data.body.nome,
          crm: response.data.body.crm,
          especialidade: response.data.body.especialidade
        };
      }
    );
  },
};
</script>

<style>
.form {
  margin: 10px;
}
</style>