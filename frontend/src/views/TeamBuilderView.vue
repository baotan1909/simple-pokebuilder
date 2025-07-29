<template>
  <v-row justify="center" class="mb-6">
    <v-col cols="12" class="text-center">
      <h1 class="text-h4 font-weight-bold">Teambuilder</h1>
    </v-col>
    <v-col cols="12" v-if="error">
      <v-alert type="error" variant="tonal" class="mx-auto" max-width="400">
        {{ error }}
      </v-alert>
    </v-col>
  </v-row>

  <v-row dense v-if="!error">
    <v-col
      v-for="i in 6"
      :key="i"
      cols="12"
      xs="6"
      sm="4"
      md="2"
    >
      <v-card elevation="4" class="pa-3 d-flex flex-column align-center">
        <PokeSearch
          :items="items"
          @select="updateSelection(i, $event)"
          class="mb-2 w-100"
        />
        <PokeDisplay :pokemon="selected[i - 1]" />
      </v-card>
    </v-col>
  </v-row>
</template>
  
<script setup>
  import { ref, onMounted } from 'vue'
  import PokeSearch from '../components/PokeSearch.vue'
  import PokeDisplay from '../components/PokeDisplay.vue'
  import PokeAPI from '../services/PokeAPI.js'

  const items = ref([])
  const selected = ref(Array(6).fill(null))
  const error = ref(null)

  async function loadItems() {
    try {
      const response = await PokeAPI.getAllPokemon()
      items.value = response.data.pokemon_species.map(p => {
        const id = p.url.match(/\/(\d+)\//)[1]
        return {
          id: parseInt(id),
          name: p.name.charAt(0).toUpperCase() + p.name.slice(1)
        }
      })
    } catch (err) {
      error.value = 'Failed to load Pokemon.'
    }
  }

  function updateSelection(index, value) {
    selected.value[index - 1] = value
  }

  onMounted(() => loadItems())
</script>