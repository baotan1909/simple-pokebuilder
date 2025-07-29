<template>
    <v-autocomplete
    :items="items"
    label="Select Pokémon"
    />
</template>

<script setup>
    import { ref, onMounted } from 'vue'
    import PokeAPI from '../services/PokeAPI.js'

    const items = ref([])

    async function loadItems() {
        try {
            const response = await PokeAPI.getAllPokemon()
            items.value = response.data.pokemon_species.map(p => 
                p.name.charAt(0).toUpperCase() + p.name.slice(1)
            )
            console.log(response.data.pokemon_species)
            console.log(items.value)
        } catch {}
    }

    onMounted(() => loadItems())
</script>