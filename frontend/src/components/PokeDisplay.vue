<template>
    <div v-if="pokemon && data" class="pokemon-card pa-4 d-flex flex-column align-center justify-start">
        <v-img
            :src="data.sprite"
            alt="Pokemon Sprite"
            width="140"
            height="140"
            class="mb-4"
        />
        <div class="d-flex flex-wrap justify-center">
            <span
            v-for="(type, i) in data.types"
            :key="i"
            class="ma-1 type-badge"
            :class="type.toLowerCase()"
            >
                {{ type }}
            </span>
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

    .type-badge {
        display: inline-block;
        min-width: 90px;
        padding: 6px 12px;
        border-radius: 9999px;
        font-size: 0.9rem;
        font-weight: 700;
        color: white;
        text-transform: capitalize;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        letter-spacing: 0.5px;
        user-select: none;
        transition: transform 0.2s;
        text-align: center;
    }

    .normal   { background-color: #A8A77A; }
    .fire     { background-color: #EE8130; }
    .water    { background-color: #6390F0; }
    .electric { background-color: #F7D02C; color: black; }
    .grass    { background-color: #7AC74C; }
    .ice      { background-color: #96D9D6; color: black; }
    .fighting { background-color: #C22E28; }
    .poison   { background-color: #A33EA1; }
    .ground   { background-color: #E2BF65; color: black; }
    .flying   { background-color: #A98FF3; }
    .psychic  { background-color: #F95587; }
    .bug      { background-color: #A6B91A; }
    .rock     { background-color: #B6A136; color: black; }
    .ghost    { background-color: #735797; }
    .dragon   { background-color: #6F35FC; }
    .dark     { background-color: #705746; }
    .steel    { background-color: #B7B7CE; color: black; }
    .fairy    { background-color: #D685AD; }
    .unknown  { background-color: red; }
</style>