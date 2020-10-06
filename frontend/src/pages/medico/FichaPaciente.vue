<template>
  <div>
    <FichaPaciente :id="paciente" />
    <q-page-sticky position="bottom-right" :offset="[18, 18]">
      <q-btn @click="createExame" fab icon="add" color="primary" />
    </q-page-sticky>
  </div>
</template>

<script>
import FichaPaciente from "../../components/FichaPaciente";

export default {
  props: ["paciente"],
  components: {
    FichaPaciente,
  },
  methods: {
    createExame() {
        console.log("dfgdfggdf");
    },
  },
};
</script>

<style>
</style>