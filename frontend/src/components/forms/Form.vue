<template>
  <q-dialog ref="dialog" @hide="onDialogHide">
    <q-card class="q-dialog-plugin">
      <q-form @submit="onOKClick">
        <q-card-section>
          <div style="font-weight: 600" class="text-h5 text-primary q-my-sm">
            {{ config.title }}
          </div>
        </q-card-section>
        <q-card-section>
          <div class="q-mb-sm" v-for="field in config.fields" :key="field.name">
            <q-input
              v-if="field.type == 'date'"
              outlined
              :label="field.label"
              v-model="record[field.name]"
              mask="date"
              :rules="['date']"
            > 
              <template v-slot:append>
                <q-icon name="event" class="cursor-pointer">
                  <q-popup-proxy>
                    <q-date v-model="record[field.name]"></q-date>
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
            <q-input
              v-else
              :type="field.type"
              outlined
              :mask="field.mask"
              :rules="field.rules"
              v-model="record[field.name]"
              :label="field.label"
            />
          </div>
        </q-card-section>
        <q-card-actions class="q-mb-sm" align="right">
          <q-btn @click="onCancelClick" flat color="red-8" label="Cancelar" />
          <q-btn type="submit" class="q-ma-sm" color="primary" label="Salvar" />
        </q-card-actions>
      </q-form>
    </q-card>
  </q-dialog>
</template>

<script>
export default {
  props: ["init", "config"],
  data() {
    return {
      record: {},
    };
  },
  mounted() {
    let mapped = {};
    this.config.fields.forEach((field) => {
      mapped[field.name] = this.init[field.name] ? this.init[field.name] : "";
    });
    this.record = { ...mapped };
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
      this.$emit("ok", { record: this.record, hide: () => this.hide() });
    },

    onCancelClick() {
      this.hide();
    },
  },
};
</script>
<style>
.q-dialog-plugin {
  width: 500px;
  max-width: 100%;
}
</style>