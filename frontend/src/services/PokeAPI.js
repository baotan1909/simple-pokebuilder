import API from './API.js'

export default {
  // Teams
  createTeam(payload) {
    return API().post('teams.php', payload)
  },

  // PokeAPI
  getAllPokemon() {
    return API().get('pokemon.php')
  },
  getPokemon(nameOrId) {
    return API().get('pokemon_detail.php', {
      params: { name: nameOrId }
    })
  }
}