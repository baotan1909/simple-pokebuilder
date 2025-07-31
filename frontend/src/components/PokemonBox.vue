<template> 
    <v-card class="pa-4 mb-4 rounded-xl" elevation="3">
      <v-card-title class="text-h6 font-weight-bold">
        {{ team.name }}
      </v-card-title>
  
      <v-divider class="my-2" />
  
      <v-row justify="center" class="pokemon-list mb-2 flex-wrap" style="overflow-x: auto;">
        <v-col v-for="(p, i) in displayPokemons" :key="i" cols="auto" class="d-flex justify-center">
          <img :src="p.sprite" :alt="p.name" width="64" height="64"/>
        </v-col>
      </v-row>

      <v-divider class="my-2" />
  
      <v-row align="center" class="mt-1">
        <v-col cols="auto" class="d-flex align-center">
          <v-icon icon="mdi-heart" color="red" start />
          <span class="ml-1 font-weight-medium">{{ team.likes }} Likes</span>
        </v-col>
      </v-row>
    </v-card>
  </template>
  
  <script setup>
  import { onMounted, ref } from 'vue'
  import PokeAPI from '../services/PokeAPI.js'
  
  const props = defineProps({
    team: {
      type: Object,
      required: true
    }
  })
  
  const displayPokemons = ref([])
  
  onMounted(async () => {
  const result = []
  for (const p of props.team.pokemons) {
    try {
      const res = await PokeAPI.getPokemon(p.dex_number)
      result.push({
        name: p.species,
        sprite: res.data.sprites.other['official-artwork'].front_default,
      })
    } catch (err) {
      result.push({
        name: 'Unknown',
        sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/0.png',
      })
    }
  }
  displayPokemons.value = result
  })
</script>  