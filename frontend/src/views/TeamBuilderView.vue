<template>
  <h1>Teambuilder</h1>
  <v-row>
    <v-col
      v-for="i in 6"
      :key="i"
    >
      <PokeSearch />
    </v-col>
  </v-row>
</template>
  
<script>
  import PokeSearch from '../components/PokeSearch.vue';
  export default{
    name: 'TeamBuilderView',
    components: {PokeSearch}
  }
</script>