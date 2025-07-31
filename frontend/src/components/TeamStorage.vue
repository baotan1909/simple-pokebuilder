<template>
  <v-container>
    <h1 class="mb-4">Your Stored Teams</h1>

  <v-alert v-if="!isAuthenticated || noTeam" type="info" variant="tonal" class="mb-4">
      {{ alertMessage }}
    </v-alert>

    <v-row>
  <v-col v-for="team in displayTeams" :key="team.id" cols="12" md="6">
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

const noTeam = computed(() => Object.keys(teams.value).length === 0)
const teamList = computed(() => Object.values(teams.value))
const displayTeams = computed(() => {return isAuthenticated.value && !noTeam.value ? teamList.value : []})
const alertMessage = computed(() =>
  !isAuthenticated.value
    ? 'You need to log in to create and view your teams.'
    : "You haven't created any teams yet."
)
</script>