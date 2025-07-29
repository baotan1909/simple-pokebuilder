<template>
    <v-autocomplete
      :items="items"
      label="Select Pokemon"
      no-data-text="No Pokemon found."
    />
    <v-alert v-if="error" type="error" variant="tonal" class="mt-2">
      {{ error }}
    </v-alert>
</template>

<script setup>
    import { ref, onMounted } from 'vue'
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