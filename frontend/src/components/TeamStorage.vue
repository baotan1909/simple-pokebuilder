<template>
  <v-container>
    <h1 class="mb-4">Your Stored Teams</h1>

    <v-alert
    v-if="Object.keys(teams).length === 0"
    type="info"
    variant="tonal"
    class="mb-4"
    >
      You haven't created any teams yet.
    </v-alert>

    <v-row v-else>
      <v-col
      v-for="team in Object.values(teams)"
      :key="team.id"
      cols="12"
      md="6"
      >
        <PokemonBox :team="team" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import PokemonBox from '../components/PokemonBox.vue'
const teams = {}
</script>