<template>
  <h1>Teambuilder</h1>
  <v-row>
    <v-col
      v-for="i in 6"
      :key="i"
    >
      <PokeSearch :items="items"/>
      <PokeDisplay/>
    </v-col>
  </v-row>
</template>
  
<script setup>
import { ref, onMounted } from 'vue'
import PokeSearch from '../components/PokeSearch.vue'
import PokeDisplay from '../components/PokeDisplay.vue'
import PokeAPI from '../services/PokeAPI.js'

const items = ref([])
const error = ref(null)

async function loadItems() {
  try {
    const response = await PokeAPI.getAllPokemon()
    items.value = response.data.pokemon_species.map(p =>
      p.name.charAt(0).toUpperCase() + p.name.slice(1)
    )
  } catch (err) {
    error.value = 'Failed to load Pokemon.'
  }
}

onMounted(() => loadItems())
</script>