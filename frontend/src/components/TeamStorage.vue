<template>
  <v-container>
    <h1 class="mb-4">Your Stored Teams</h1>

  <v-alert v-if="!isAuthenticated || noTeams" type="info" variant="tonal" class="mb-4">
      {{ alertMessage }}
    </v-alert>

    <v-row v-if="isAuthenticated && !noTeams">
      <v-col v-for="team in teamList" :key="team.id" cols="12" md="6">
        <PokemonBox :team="team" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, computed } from 'vue'
import useAuth from '../composables/useAuth.js'
import PokemonBox from '../components/PokemonBox.vue'

const { isAuthenticated } = useAuth()
const teams = ref({})

const noTeams = computed(() => Object.keys(teams.value).length === 0)
const teamList = computed(() => Object.values(teams.value))
const alertMessage = computed(() =>
  !isAuthenticated.value
    ? 'You need to log in to create and view your teams.'
    : "You haven't created any teams yet."
)
</script>
