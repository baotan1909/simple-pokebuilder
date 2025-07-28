import API from './API.js'

const spriteBaseUrl = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork'

export default {
  getPokemonSprite(id) {
    return `${spriteBaseUrl}/${id}.png`
  },
  getFailedSprite() {
    return `${spriteBaseUrl}/0.png`
  },
  getPokemon(pokemon) {
    return API().get('pokemon/' + pokemon)
  } 
}