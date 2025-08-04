<template>
  <v-progress-circular v-if="loading" indeterminate color="primary" size="64" class="d-flex mx-auto my-4"/>
  
  <v-table v-else class="elevation-2 rounded my-4 bordered-table" density="comfortable" hover aria-label="Pokedex table">
    <thead role="rowgroup">
      <tr class="bg-blue-grey-lighten-4" role="row">
        <th v-for="h in headers" :key="h" class="text-uppercase font-weight-bold text-center" role="columnheader" scope="col">
          {{ h }}
        </th>
      </tr>
    </thead>
    <tbody role="rowgroup">
      <tr v-for="(p) in pokemons" :key="p.id" role="row">
          <td class="text-center" role="cell">{{ p.id }}</td>
          <td class="text-center" role="cell"><img :src="p.sprite" :alt="`Sprite of ${p.name}`" width="128"/></td>
          <td class="text-center text-capitalize font-weight-medium" :class="{'text-error': p.error}" role="cell">{{ p.name }}</td>
          <td class="text-center" role="cell">
            <TypeBadge :types="p.types"/>
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
    <v-text-field v-model.number="jumpPage" type="number" label="Jump to" density="compact" style="max-width: 100px" hide-details/>
    <v-btn color="primary" @click="clickCallback(jumpPage)" :disabled="jumpPage < 1 || jumpPage > getPageCount()">
      Go
    </v-btn>
  </div>
</template>

<script setup>
  import { ref, onMounted } from 'vue'
  import Paginate from 'vuejs-paginate-next'
  import PokeAPI from '../services/PokeAPI.js'
  import TypeBadge from './TypeBadge.vue'
  
  const POKEMON_NUM = 151
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

    let start = (pageNum - 1) * PER_PAGE + 1
    const end = Math.min(start + PER_PAGE - 1, POKEMON_NUM)

    const temp = []

    for (let i = start; i <= end; i++) {
      try {
        const res = await PokeAPI.getPokemon(i)
        temp.push({
          id: res.data.id,
          sprite: res.data.sprites.other['official-artwork'].front_default,
          name: res.data.name,
          types: (res.data.past_types?.[0]?.types || res.data.types).map(t => t.type.name),
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
    cursor: pointer;
  }

  .text-error {
    color: #e53935;
    font-style: italic;
  }
</style>