<template>
  <v-app>
    <v-app-bar app color="indigo" dark flat>
      <v-app-bar-title>Simple Pokémon TeamBuilder</v-app-bar-title>
      <v-spacer />
      <v-btn to="/" exact exact-active-class="v-btn--active" text>Home</v-btn>
      <v-btn to="/teambuilder" exact exact-active-class="v-btn--active" text>Team Builder</v-btn>
      <v-btn to="/social" exact exact-active-class="v-btn--active" text>All Teams</v-btn>
      <v-btn to="/dex" exact exact-active-class="v-btn--active" text>Pokedex</v-btn>
      <v-btn v-if="!isAuthenticated" to="/login" exact exact-active-class="v-btn--active" text>Login</v-btn>
      <v-btn v-else text @click="handleLogout">Logout</v-btn>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>

    <v-footer app color="indigo-darken-4" class="text-white">
      <v-container fluid class="px-4 py-2">
        <v-row justify="space-between" align="center">
          <v-col cols="12" md="6" class="text-body-2 mb-1 mb-md-0">
            Made by baotan1909
          </v-col>
          <v-col cols="12" md="6" class="text-md-right">
            <v-btn icon href="https://github.com/baotan1909/simple-pokebuilder" target="_blank" rel="noopener">
              <v-icon>mdi-github</v-icon>
            </v-btn>
            <span class="ml-2 text-body-2">Check it out on GitHub</span>
          </v-col>
        </v-row>
      </v-container>
    </v-footer>
  </v-app>
</template>

<script setup>
  import auth from './composables/auth.js'
  const { isAuthenticated, handleLogout } = auth
</script>