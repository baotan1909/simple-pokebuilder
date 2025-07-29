import API from './API.js'

export default {
  getAllPokemon() {
    return API().get('pokemon.php')
  },
  getPokemon(nameOrId) {
    return API().get('pokemon_detail.php', {
      params: { name: nameOrId }
    })
  }
}