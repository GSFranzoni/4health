<template>
  <q-table
    class="q-ma-sm"
    :title="title"
    :data="data"
    :columns="columns"
    :filter="filter"
    no-data-label="Nenhum registro encontrado..."
    row-key="name"
  >
    <template v-slot:top-right>
      <q-input
        class="q-mt-md"
        outlined
        debounce="300"
        v-model="filter"
        placeholder="Pesquisar"
      >
        <template v-slot:prepend>
          <q-icon name="search" />
        </template>
      </q-input>
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
  </q-table>
</template>

<script>
export default {
  props: ["title", "data", "columns", "actions", "addButton"],
  data() {
    return {
      filter: ''
    };
  },
  methods: {
    handle(action, value) {
      action.handle(value);
    },
  },
  mounted() {},
};
</script>

<style>
</style>