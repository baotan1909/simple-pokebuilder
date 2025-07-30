<template>
    <div v-if="pokemon && data" class="pokemon-card pa-4 d-flex flex-column align-center justify-start">
        <v-img :src="data.sprite" alt="Pokemon Sprite" width="140" height="140" class="mb-4"/>
        <div class="d-flex flex-wrap justify-center">
            <TypeBadge :types="data.types"/>
        </div>
    </div>
    <div v-else-if="loading" class="pa-4 d-flex align-center justify-center" style="min-height: 180px;">
        <v-progress-circular indeterminate color="primary" class="mr-2" />
        <span>Loading...</span>
    </div>
</template>
  
<script setup>
    import { ref, onUpdated } from 'vue'
    import PokeAPI from '../services/PokeAPI.js'
    import TypeBadge from './TypeBadge.vue'

    const props = defineProps({
        pokemon: Number
    })
  
    const data = ref(null)
    const loading = ref(false)
    let lastFetched = ''
  
    async function fetchData(id) {
        if (!id || id === lastFetched) { return }

        loading.value = true

        try {
            const res = await PokeAPI.getPokemon(id)
            data.value = {
                sprite: res.data.sprites.other['official-artwork'].front_default,
                types: (res.data.past_types?.[0]?.types || res.data.types).map(t => t.type.name)
            }
            lastFetched = id
        } catch (e) {
            data.value = {
                sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/0.png', 
                types: ['unknown'],
            }
        }

        loading.value = false
    }

    onUpdated(() => {
        fetchData(props.pokemon)
    })
  </script>
  
  
<style scoped>
    .pokemon-card {
        height: 260px;
        background-color: #f9f9f9;
        border-radius: 16px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    }
</style>