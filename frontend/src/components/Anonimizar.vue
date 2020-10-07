<template>
  <q-item
    clickable
    @click="onclick"
    v-if="usuario != null && usuario.tipo_usuario == 3"
  >
    <q-item-section avatar>
      <q-icon name="delete_forever" />
    </q-item-section>
    <q-item-section>
      <q-item-label>Deletar meu registro</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script>
import { mapState } from "vuex";
import PacienteService from "../services/PacienteService";
import Notification from "../util/Notification";

export default {
  computed: mapState(["usuario"]),
  methods: {
    onclick() {
      this.$q
        .dialog({
          title: "Confirmação",
          message: "Você realmente deseja excluir o seu registro?",
          cancel: true,
          persistent: true,
        })
        .onOk(() => {
          this.anonimizar();
        });
    },
    anonimizar() {
      PacienteService.anonimizar()
        .then(Notification.positive)
        .then(() => {
            this.$store.commit('logout');
            this.$router.push('/auth');
        })
        .catch(Notification.negative);
    },
  },
};
</script>

<style>
</style>