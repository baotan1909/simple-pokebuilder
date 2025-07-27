import API from './API.js'

export default {
    getPokemonSprite(id) {
      return `https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/${id}.png`
    },
    getPokemon(pokemon) {
      return API().get('pokemon/' + pokemon)
    }
  }