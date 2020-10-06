<template>
  <q-dialog ref="dialog" @hide="onDialogHide">
    <q-card class="q-dialog-plugin">
      <q-card-section>
        <div class="text-h6">{{ title }}</div>
      </q-card-section>
      <q-card-section>
        <q-input
          v-for="field in fields"
          :key="field.name"
          class="q-mb-sm"
          :type="field.type"
          outlined
          v-model="record[field.name]"
          :label="field.label"
        />
      </q-card-section>
      <q-card-actions align="right">
        <q-btn @click="onCancelClick" flat color="grey-9" label="Voltar" />
        <q-btn
          @click="onOKClick"
          class="q-ma-sm"
          color="primary"
          label="Salvar"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
export default {
  props: ["init", "fields", "title"],
  data() {
    return {
      record: {},
    };
  },
  mounted() {
    this.record = { ...this.init };
  },
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
      this.$emit("ok", this.record);
      this.hide();
    },

    onCancelClick() {
      this.hide();
    },
  },
};
</script>