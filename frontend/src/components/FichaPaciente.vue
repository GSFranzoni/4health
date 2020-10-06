<template>
  <div class="q-ma-md">
    <q-card class="q-mb-sm">
      <q-card-section>
        <div class="text-h5">{{ paciente.nome }}</div>
        <div class="text-grey">
          {{ paciente.cidade }} - {{ paciente.uf }}
        </div>
        <div class="text-grey">Contato: {{ paciente.telefone }}</div>
      </q-card-section>
    </q-card>
    <q-card v-for="exame in exames" :key="exame.id" class="q-mb-sm">
      <q-card-section>
        <div class="text-h5 text-primary">{{ exame.nome }}</div>
        <div class="text-grey">{{ exame.data }}</div>
      </q-card-section>
      <q-card-section>
        <div class="text-h6 text-primary">RESULTADO</div>
        <div>{{ exame.resultado }}</div>
      </q-card-section>
      <q-card-section>
        <div class="text-h6 text-primary">LAUDO</div>
        <div>{{ exame.laudo }}</div>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import ExameService from "../services/ExameService";
import PacienteService from "../services/PacienteService";
import Notification from "../util/Notification";

export default {
  props: ["id"],
  data() {
    return {
      exames: [],
      paciente: {},
    };
  },
  methods: {
    reload() {
      ExameService.getByPaciente(this.id)
        .then((res) => {
          this.exames = res.data.body;
        })
        .catch(Notification.negative);
      PacienteService.get(this.id)
        .then((res) => {
          this.paciente = res.data.body;
        })
        .catch(Notification.negative);
    },
  },
  mounted() {
    this.reload();
  },
};
</script>

<style>
</style>