<template>
  <q-card>
    <q-card-section>
        <div class="text-h5">{{ pac_nome }}</div>
    </q-card-section>
    <q-card-section>
        <div class="h6">ENDEREÇO</div>
        <div>{{ pac_uf }}</div>
        <div>{{ pac_cidade }}</div>
        <div>{{ pac_logradouro }}</div>
        <div>{{ pac_bairro }}</div>
        <div>{{ pac_numero_casa }}</div>
    </q-card-section>
    <q-card-section>
        <div class="h6">TELEFONE</div>
        <div>{{ pac_telefone }}</div>
    </q-card-section>
  </q-card>
</template>

<script>
export default {
    props: [ 'pac_nome', 'pac_uf', 'pac_cidade', 'pac_logradouro', 'pac_bairro', 'pac_numero_casa', 'pac_telefone' ]
};
</script>

<style>
</style>