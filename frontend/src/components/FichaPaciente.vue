<template>
  <div>
      <Exame v-for="exame in exames" :key="exame.id" v-bind="exame" />
  </div>
</template>

<script>
import ExameService from "../services/ExameService";
import PacienteService from "../services/PacienteService";
import Notification from "../util/Notification";
import Exame from '../components/Exame';

export default {
  props: ["id"],
  data() {
    return {
      exames: [],
    };
  },
  components: {
    Exame
  },
  methods: {
    reload() {
      ExameService.getByPaciente(this.id)
        .then((res) => {
          this.exames = res.data.body;
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