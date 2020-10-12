<template>
  <transition
    mode="out-in"
    enter-active-class="animated bounceIn"
    leave-active-class="animated bounceOut"
  >
    <q-btn
      v-if="solicitacao"
      flat
      class="q-mx-lg"
      push
      color="white"
      text-color="white"
      icon="chat"
    >
      <q-badge color="warning" floating>1</q-badge>
      <q-popup-proxy>
        <q-banner>
          <q-card flat class="solicitacao-card">
            <q-card-section>
              <div style="font-size: 1rem">
                O paciente {{ paciente.nome }} fez uma solicitação de
                atendimento no dia {{ format(solicitacao.data) }}
              </div>
            </q-card-section>
            <q-card-actions align="right">
              <q-btn
                v-close-popup
                @click="updateAceite(0)"
                flat
                color="red-8"
                label="Recusar"
              />
              <q-btn
                v-close-popup
                @click="updateAceite(true)"
                color="primary"
                label="Aceitar"
              />
            </q-card-actions>
          </q-card>
        </q-banner>
      </q-popup-proxy>
    </q-btn>
  </transition>
</template>

<script>
import { mapState } from "vuex";
import PacienteService from "../services/PacienteService";
import SolicitacaoService from "../services/SolicitacaoService";
import Notification from "../util/Notification";

export default {
  data() {
    return {
      paciente: {},
    };
  },
  computed: mapState(["solicitacao"]),
  methods: {
    updateAceite(aceito) {
      SolicitacaoService.update(this.solicitacao.id, { aceito: aceito })
        .then(Notification.positive)
        .catch(Notification.negative)
        .finally(() => {
          setTimeout(() => this.$store.commit("setSolicitacao", null), 200);
        });
    },
    format(datetime) {
      const date = datetime.split(" ")[0];
      const time = datetime.split(" ")[1].substr(0, 5);

      return `${date.split("-").reverse().join("/").toString()} às ${time}h`;
    },
  },
  async mounted() {
    if (this.$store.state.usuario.tipo_usuario != 2) {
      return;
    }
    const solicitacoes = (await SolicitacaoService.getByMedico(this.$store.state.info.id)).data.body;
    if(solicitacoes.length > 0) {
      this.$store.commit("setSolicitacao", solicitacoes[0]);
      this.paciente = (await PacienteService.get(this.solicitacao.paciente)).data.body;
    }
  },
};
</script>

<style>
.solicitacao-card {
  width: 300px !important;
  max-width: 100%;
}
</style>