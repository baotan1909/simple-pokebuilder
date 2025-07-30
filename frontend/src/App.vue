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
  import { ref, onMounted } from 'vue'
  import { useRouter } from 'vue-router'
  import axios from 'axios'
  import AuthAPI from './services/AuthAPI.js'

  const router = useRouter()
  const isAuthenticated = ref(false)

  const checkAuth = async () => {
    try {
      const res = await AuthAPI.getProfile()
      isAuthenticated.value = !!res.data.user
    } catch (err) {
      isAuthenticated.value = false
    }
  }

  const handleLogout = async () => {
    try {
      await axios.post(
      import.meta.env.VITE_AUTH_BASE_URL + '/logout.php',
      {},
      {
        withCredentials: true
      }
    )
      isAuthenticated.value = false
      router.push('/')
    } catch (error) {
      console.error('Logout failed:', error)
    }
  }
  onMounted(() => {
    checkAuth()
  })
</script>