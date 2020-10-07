<template>
  <div id="q-app">
    <router-view />
  </div>
</template>
<script>
import AuthService from './services/AuthService';
import Notification from './util/Notification';
import axios from 'axios';

export default {
  name: 'App',
  created() {
    
  },
}
</script>
