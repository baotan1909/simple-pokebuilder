<template>
  <v-progress-circular
    v-if="loading"
    indeterminate
    color="primary"
    size="64"
    class="d-flex mx-auto my-4"
  />
  
  <v-table
    v-else
    class="elevation-2 rounded my-4 bordered-table"
    density="comfortable"
    hover
  >
    <thead>
      <tr class="bg-blue-grey-lighten-4">
        <th v-for="h in headers" :key="h" class="text-uppercase font-weight-bold text-center">
          {{ h }}
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(p) in pokemons" :key="p.id">
          <td class="text-center">{{ p.id }}</td>
          <td class="text-center"><img :src="p.sprite" alt="sprite" width="128"/></td>
          <td class="text-center text-capitalize font-weight-medium" :class="{'text-error': p.error}">{{ p.name }}</td>
          <td class="text-center">
          <span
            v-for="(type, i) in p.types"
            :key="i"
            class="ma-1 type-badge"
            :class="type.toLowerCase()"
            size="small"
            label
          >
            {{ type }}
        </span>
        </td>
      </tr>
    </tbody>
  </v-table>

  <div class="d-flex justify-center my-4">
    <paginate
      :page-count="getPageCount()"
      :click-handler="clickCallback"
      :force-page="currentPage"
      :prev-text="'‹ Prev'"
      :next-text="'Next ›'"
      :container-class="'paginate-container'"
      :page-class="'page-item'"
      :active-class="'active'"
      :disabled-class="'disabled'"
    />
  </div>
  <div class="d-flex justify-center align-center mt-2 gap-4">
    <v-text-field
      v-model.number="jumpPage"
      type="number"
      label="Jump to"
      density="compact"
      style="max-width: 100px"
      hide-details
    />
    <v-btn
      color="primary"
      @click="clickCallback(jumpPage)"
      :disabled="jumpPage < 1 || jumpPage > getPageCount()"
    >
      Go
    </v-btn>
  </div>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import Paginate from 'vuejs-paginate-next'
  import PokeAPI from '../services/PokeAPI.js'
  
  const POKEMON_NUM = 1025
  const PER_PAGE = 20
  const headers = ['Index', 'Sprite', 'Name', 'Type']
  const pokemons = ref([])
  const loading = ref(true)
  const currentPage = ref(1)
  const jumpPage = ref(1)
  
  function getPageCount() {
    return Math.ceil(POKEMON_NUM / PER_PAGE)
  }

  function clickCallback(pageNum) {
    currentPage.value = pageNum
    jumpPage.value = pageNum
    loadPokemonPage(pageNum)
  }

  async function loadPokemonPage(pageNum) {
    pokemons.value = []
    loading.value = true

    const start = (pageNum - 1) * PER_PAGE + 1
    const end = Math.min(start + PER_PAGE - 1, POKEMON_NUM)

    const temp = []

    for (let i = start; i <= end; i++) {
      try {
        const res = await PokeAPI.getPokemon(i)
        temp.push({
          id: i,
          sprite: PokeAPI.getPokemonSprite(i),
          name: res.data.name,
          types: res.data.types.map(t => t.type.name),
          error: false,
        })
      } catch (e) {
        temp.push({
          id: i,
          sprite: 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/0.png', 
          name: 'Unavailable',
          types: ['unknown'],
          error: true,
        })
      }
    }

    pokemons.value = temp
    loading.value = false
  }

  onMounted(() => loadPokemonPage(1))
</script>

<style scoped>
  .v-table {
    border-collapse: separate;
    border-spacing: 0;
    background-color: white;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    border-radius: 12px;
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
  }

  tbody td,
  thead th {
    border: 1px solid #E0E0E0;
  }

  tbody td {
    padding: 14px 18px;
    font-size: 1rem;
    vertical-align: middle;
    transition: background-color 0.25s ease, transform 0.2s ease;
  }

  tbody tr:hover {
    background-color: #f1f8ff;
    transform: scale(1.01);
    cursor: pointer;
  }

  .text-error {
    color: #e53935;
    font-style: italic;
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
  
  .type-badge:hover {
    transform: scale(1.05);
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