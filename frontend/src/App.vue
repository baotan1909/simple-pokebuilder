<template>
  <v-app>
    <v-app-bar app color="indigo" dark flat>
      <v-app-bar-title>Simple Pokémon TeamBuilder</v-app-bar-title>
      <v-spacer />
      <v-btn to="/" exact exact-active-class="v-btn--active" text>Home</v-btn>
      <v-btn to="/teambuilder" exact exact-active-class="v-btn--active" text>Team Builder</v-btn>
      <v-btn to="/dex" exact exact-active-class="v-btn--active" text>Pokedex</v-btn>
      <v-btn v-if="!isAuthenticated" to="/login" exact exact-active-class="v-btn--active" text>Login</v-btn>
      <v-btn v-else text @click="handleLogout">Logout</v-btn>
    </v-app-bar>

    <v-main>
      <v-container class="pa-4">
        <router-view />
      </v-container>
    </v-main>
  </v-app>
</template>

<script setup>
  import auth from './composables/auth.js'
  const { isAuthenticated, handleLogout } = auth
</script>