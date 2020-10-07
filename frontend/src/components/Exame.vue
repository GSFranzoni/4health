<template>
  <q-dialog ref="dialog" @hide="onDialogHide">
    <q-card class="q-ma-sm q-pa-sm q-dialog-plugin">
      <div class="float-right">
        <q-card-section >
        <div class="text-h5">Paciente</div>
        <div class="text-grey">{{ paciente }}</div>
      </q-card-section>
      <q-card-section>
        <div class="text-h5">Médico</div>
        <div class="text-grey">{{ medico }}</div>
      </q-card-section>
      </div>
      <q-card-section>
        <div class="text-h5 text-primary">{{ nome }}</div>
        <div class="text-grey">{{ data }}</div>
      </q-card-section>
      <q-card-section>
        <div class="text-h6">RESULTADO</div>
        <div>{{ resultado }}</div>
      </q-card-section>
      <q-card-section>
        <div class="text-h6">LAUDO</div>
        <div>{{ laudo }}</div>
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
  },
  async mounted() {
  }
};
</script>

<style>
</style>