<template>
  <v-container class="fill-height" fluid>
    <v-row justify="center" align="center">
      <v-col cols="12" sm="8" md="5" lg="4">
        <v-card class="pa-6" elevation="12" rounded="xl">
          <v-card-title class="text-center pb-0">
            <v-icon icon="mdi-pokeball" size="48" color="red-darken-1" />
            <div class="mt-2 text-h5 font-weight-bold">Welcome to SPT</div>
            <div class="text-medium-emphasis text-subtitle-2">
              Build, save, and share your Pokémon teams!
            </div>
          </v-card-title>

          <v-card-text class="pt-6">
            <v-btn color="red-darken-1" class="mb-4" block size="large" prepend-icon="mdi-google" @click="loginWith('google')">
              Login with Google
            </v-btn>

            <v-btn color="indigo darken-4" class="mb-4" block size="large" prepend-icon="mdi-facebook" @click="loginWith('facebook')">
              Login with Facebook
            </v-btn>

            <v-btn color="grey-darken-4" class="mb-2" block size="large" prepend-icon="mdi-github" @click="loginWith('github')">
              Login with GitHub
            </v-btn>

            <v-alert v-if="alertMessage" type="info" class="mt-6" variant="tonal" density="comfortable" dismissible
            @click:close="alertMessage = ''">
              {{ alertMessage }}
            </v-alert>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
  import { ref } from 'vue'

  const alertMessage = ref('')
  const baseURL = import.meta.env.VITE_AUTH_BASE_URL

  const loginWith = (provider) => {
    if (provider === 'google') {
      window.location.href = `${baseURL}/login.php`
    } else {
      alertMessage.value = "This is just for fun. This website hasn't supported this login method yet."
    }
  }
</script>

<style scoped>
  .v-card-title > * {
    display: block;
  }

  .v-btn {
    text-transform: none;
    font-weight: 500;
  }
</style>