<template>
  <q-dialog ref="dialog" @hide="onDialogHide">
    <q-card class="q-ma-sm q-pa-sm q-dialog-plugin">
      <q-card-section>
        <div class="text-h4 text-primary">{{ nome }}</div>
      </q-card-section>
      <q-card-section>
        <div>PACIENTE</div>
        <div class="text-grey">{{ paciente.nome }}</div>
      </q-card-section>
      <q-card-section>
        <div>MÉDICO</div>
        <div class="text-grey">{{ medico.nome }}</div>
      </q-card-section>
      <q-card-section>
        <div class="text-h6">RESULTADO</div>
        <div>{{ resultado }}</div>
      </q-card-section>
      <q-card-section>
        <div class="text-h6">LAUDO</div>
        <div>{{ laudo }}</div>
      </q-card-section>
      <q-card-section>
        <div class="text-grey float-right q-my-sm">{{ format(data) }}</div>
      </q-card-section>
    </q-card>
  </q-dialog>
</template>

<script>
export default {
  props: ["nome", "data", "resultado", "laudo", "paciente", "medico"],
  methods: {
    show() {
      this.$refs.dialog.show();
    },

    hide() {
      this.$refs.dialog.hide();
    },

    onDialogHide() {
      this.$emit("hide");
    },

    onOKClick() {
      this.$emit("ok");
    },

    onCancelClick() {
      this.hide();
    },

    format(datetime) {
      const date = datetime.split(" ")[0];
      const time = datetime.split(" ")[1].substr(0, 5);

      return `${date.split("-").reverse().join("/").toString()} ${time}h`;
    },
  },
  async mounted() {},
};
</script>

<style>
</style>