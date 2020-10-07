<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />
        <q-toolbar-title> 4HEALTH </q-toolbar-title>
        <Solicitacao/>
        <q-btn flat color="white" label="Sair" @click="logout"></q-btn>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      content-class="bg-grey-1"
    >
      <q-list>
        <q-item-label header class="text-grey-8"> MENU </q-item-label>
        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container
      ><transition
        mode="out-in"
        enter-active-class="animated fadeIn"
        leave-active-class="animated fadeOut"
      >
        <router-view
      /></transition>
    </q-page-container>
  </q-layout>
</template>

<script>
import EssentialLink from "components/EssentialLink.vue";
import Solicitacao from "components/Solicitacao.vue";
import SolicitacaoService from "../services/SolicitacaoService";

const linksData = [
  {
    title: "Início",
    icon: "home",
    link: "/home",
    tipo: 0,
  },
  {
    title: "Pacientes",
    icon: "school",
    link: "/admin/pacientes",
    tipo: 1,
  },
  {
    title: "Médicos",
    icon: "favorite",
    link: "/admin/medicos",
    tipo: 1,
  },
  {
    title: "Pacientes",
    icon: "people_alt",
    link: "/medico/pacientes",
    tipo: 2,
  },
  {
    title: "Exames",
    icon: "loyalty",
    link: "/medico/exames",
    tipo: 2,
  },
  {
    title: "Médicos",
    icon: "favorite",
    link: "/paciente/medicos",
    tipo: 3,
  },
  {
    title: "Minha ficha",
    icon: "perm_contact_calendar",
    link: "/paciente/ficha",
    tipo: 3,
  },
];

export default {
  name: "MainLayout",
  components: { EssentialLink, Solicitacao },
  data() {
    return {
      leftDrawerOpen: false,
      linksData,
    };
  },
  computed: {
    essentialLinks() {
      if (!this.$store.state.usuario) return [];
      return this.linksData.filter((link) => {
        return (
          link.tipo === 0 ||
          link.tipo === this.$store.state.usuario.tipo_usuario
        );
      });
    },
  },
  methods: {
    logout() {
      this.$store.commit("logout");
      this.$router.push("/auth");
    },
  }
};
</script>
