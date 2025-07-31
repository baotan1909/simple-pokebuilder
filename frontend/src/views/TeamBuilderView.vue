<template>
  <v-row justify="center" class="mb-6">
    <v-col cols="12" class="text-center">
      <h1 class="text-h2 font-weight-bold">Teambuilder</h1>
    </v-col>
    <v-col cols="12" v-if="error">
      <v-alert type="error" variant="tonal" class="mx-auto" max-width="400">
        {{ error }}
      </v-alert>
    </v-col>
  </v-row>

  <v-row class="mb-4" align="center" justify="center">
    <v-col cols="8" md="10">
      <v-text-field v-model="newName" label="Team Name" variant="outlined" density="comfortable" hide-details/>
    </v-col>
    <v-col cols="4" md="2">
      <SaveButton @save="saveTeam" />
    </v-col>
  </v-row>
  
  <v-row dense v-if="!error">
    <v-col
      v-for="i in 6" :key="i" cols="12" xs="6" sm="4" md="2">
      <v-card elevation="4" class="pa-3 d-flex flex-column align-center">
        <PokeSearch :items="items" @select="updateSelection(i, $event)" class="mb-2 w-100"/>
        <PokeDisplay :pokemon="selected[i - 1]" />
      </v-card>
    </v-col>
  </v-row>
  <TeamStorage ref="teamStorageRef" />
</template>
  
<script setup>
  import { ref, onMounted } from 'vue'
  import auth from '../composables/auth.js'
  import { useNotify } from '../composables/useNotify.js'
  import PokeAPI from '../services/PokeAPI.js'
  import PokeSearch from '../components/PokeSearch.vue'
  import PokeDisplay from '../components/PokeDisplay.vue'
  import SaveButton from '../components/SaveButton.vue'
  import TeamStorage from '../components/TeamStorage.vue'

  const newName = ref('Untitled')
  const items = ref([])
  const selected = ref(Array(6).fill(null))
  const error = ref(null)
  const teamStorageRef = ref()
  const { user, isAuthenticated } = auth
  const { notify } = useNotify()

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

  async function saveTeam() {
    if (!isAuthenticated.value) {
      notify('You must log in before using this function.')
      return
    }
    const allNull = selected.value.every(p => p === null)
    if (allNull) {
      notify('Select at least one Pokémon.')
      return
    }

    if (!newName.value.trim()) {
      newName.value = 'Untitled'
    }

    const pokemons = selected.value.map(id => ({
      species: id ? items.value.find(i => i.id === id)?.name || 'Unknown' : 'Unknown',
      dex_number: id || 0
    }))

    try {
      await PokeAPI.createTeam({
        user_id: user.value.id,
        name: newName.value.trim(),
        pokemons
      })

      newName.value = ''
      selected.value = Array(6).fill(null)
      notify('Saved team successfully.')
      teamStorageRef.value?.loadTeams?.()
    } catch (err) {
      notify('Failed to save team.')
    }
  }
  onMounted(() => loadItems())
</script>