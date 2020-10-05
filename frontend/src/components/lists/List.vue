<template>
  <q-table
    :title="title"
    :data="data"
    :columns="columns"
    no-data-label="Nenhum registro encontrado..."
    row-key="name"
  >
    <template v-slot:top-right>
      <q-btn @click="$emit('create')" color="primary" icon="add" round></q-btn>
    </template>

    <template v-slot:body-cell-actions="props">
      <q-td :props="props">
        <q-fab flat color="black" push icon="settings" direction="right">
          <q-fab-action
            v-for="action in actions"
            :key="action.icon"
            :icon="action.icon"
            :color="action.color"
            @click="handle(action, props.row)"
          />
        </q-fab>
      </q-td>
    </template>

    <template v-slot:body-cell="props">
      <q-td :props="props">
        <div v-if="props.value == 0 || props.value == 1">
          <q-icon
            v-if="props.value == 1"
            size="sm"
            color="primary"
            name="check_circle"
          />
          <q-icon v-else size="sm" color="red-8" name="cancel" />
        </div>
        <div v-else>
          {{ props.value }}
        </div>
      </q-td>
    </template>
  </q-table>
</template>

<script>
export default {
  props: ["title", "data", "columns", "actions"],
  data() {
    return {};
  },
  methods: {
    handle(action, value) {
        action.handle(value);
    },
  },
  mounted() {
  }
};
</script>

<style>
</style>