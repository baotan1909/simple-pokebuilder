<template>
  <v-app>
    <v-app-bar app color="indigo" dark flat>
    <v-app-bar-nav-icon @click="openDrawer" class="d-md-none" />
    <v-app-bar-title>
      <router-link to="/" class="d-flex align-center ga-2 text-white text-decoration-none">
        <img src="/icon.png" alt="Pokemon icon" width="32" height="32" style="object-fit: cover" />
        <span>Simple Pokémon TeamBuilder</span>
      </router-link>
    </v-app-bar-title>

    <v-spacer class="d-none d-md-flex" />
    <div class="d-none d-md-flex">
      <v-btn to="/" exact exact-active-class="v-btn--active" text>Home</v-btn>
      <v-btn to="/teambuilder" exact exact-active-class="v-btn--active" text>Team Builder</v-btn>
      <v-btn to="/social" exact exact-active-class="v-btn--active" text>All Teams</v-btn>
      <v-btn to="/dex" exact exact-active-class="v-btn--active" text>Pokedex</v-btn>
      <v-btn v-if="!isAuthenticated" to="/login" exact exact-active-class="v-btn--active" text>Login</v-btn>
      <v-btn v-else text @click="handleLogout">Logout</v-btn>
    </div>
  </v-app-bar>

  <v-navigation-drawer v-model="drawer" temporary left class="d-md-none">
    <v-sheet class="pa-4 d-flex justify-space-between align-center">
      <div class="text-h6">Menu</div>
      <v-btn icon @click="closeDrawer">
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-sheet>

    <v-divider />
    <v-list nav dense>
      <v-list-item link to="/" @click="closeDrawer">
        <v-list-item-icon><v-icon>mdi-home</v-icon></v-list-item-icon>
        <v-list-item-title>Home</v-list-item-title>
      </v-list-item>
      <v-list-item link to="/teambuilder" @click="closeDrawer">
        <v-list-item-icon><v-icon>mdi-pokeball</v-icon></v-list-item-icon>
        <v-list-item-title>Team Builder</v-list-item-title>
      </v-list-item>
      <v-list-item link to="/social" @click="closeDrawer">
        <v-list-item-icon><v-icon>mdi-account-group</v-icon></v-list-item-icon>
        <v-list-item-title>All Teams</v-list-item-title>
      </v-list-item>
      <v-list-item link to="/dex" @click="closeDrawer">
        <v-list-item-icon><v-icon>mdi-book-open-page-variant</v-icon></v-list-item-icon>
        <v-list-item-title>Pokedex</v-list-item-title>
      </v-list-item>
      <v-list-item v-if="!isAuthenticated" link to="/login" @click="closeDrawer">
        <v-list-item-icon><v-icon>mdi-login</v-icon></v-list-item-icon>
        <v-list-item-title>Login</v-list-item-title>
      </v-list-item>
      <v-list-item v-else @click="() => { handleLogout(); closeDrawer() }">
        <v-list-item-icon><v-icon>mdi-logout</v-icon></v-list-item-icon>
        <v-list-item-title>Logout</v-list-item-title>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>

    <v-main>
      <router-view />
    </v-main>

    <v-footer color="indigo-darken-4" class="text-white">
      <v-container fluid class="px-4 py-2">
        <v-row align="center">
          <v-col cols="12" md="4" class="text-body-2 mb-1 mb-md-0 text-md-left text-center">
            <a href="https://www.flaticon.com/free-icons/pokemon" title="pokemon icons"
            class="text-white text-decoration-none d-inline-flex align-center ga-2"
            target="_blank" rel="noopener">
              <img src="/icon.png" alt="Pokemon icon created by Darius Dan - Flaticon" width="32" height="32" style="object-fit: cover">
              <span>Icon by Darius Dan - Flaticon</span>
            </a>
          </v-col>

          <v-col cols="12" md="4" class="text-center mb-2 mb-md-0">
            <div class="text-h6 font-weight-bold mb-1">Made by Thái Dương Bảo Tân</div>
            <div class="text-body-2" style="opacity: 0.8;">
              ©1995–2025 Pokémon characters and names are copyright © The Pokémon Company and/or Nintendo.
            </div>
          </v-col>

          <v-col cols="12" md="4" class="text-md-right text-center">
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
  import { ref } from 'vue'
  import auth from './composables/auth.js'
  const { isAuthenticated, handleLogout } = auth
  const drawer = ref(false)
  function openDrawer() {
    drawer.value = true
  }
  function closeDrawer() {
    drawer.value = false
  }
</script>