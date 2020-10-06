<template>
  <div id="q-app">
    <router-view />
  </div>
</template>
<script>
import AuthService from './services/AuthService';
import Notification from './util/Notification';

export default {
  name: 'App',
  mounted() {
  },
}
</script>
